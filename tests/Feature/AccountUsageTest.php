<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AccountUsage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AccountUsageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now('UTC')->setDate(2026, 9, 24)->setTime(12, 0));
        config(['analytics' => [
            'app_id' => 'test-app',
            'webhook_url' => 'https://workflow.example/webhook/shared',
            'tenant_id' => 'test-tenant',
            'client_id' => 'test-client',
            'client_secret' => 'server-only-secret',
        ]]);
        Cache::flush();
        Http::preventStrayRequests();
    }

    public function test_dashboard_uses_only_the_signed_in_email_and_keeps_credentials_server_side(): void
    {
        $this->fakeAzure($this->azureResult());
        $user = User::factory()->create(['email' => 'owner@example.com']);
        $response = $this->actingAs($user)->get('/dashboard?userId=other@example.com');
        $response->assertOk()->assertSee('12,345')->assertSee('1.25 s')->assertSee('September 2026')
            ->assertDontSee('server-only-secret')->assertDontSee('server-only-token')
            ->assertDontSee('other@example.com')->assertDontSee('Active users');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        Http::assertSent(function (Request $request): bool {
            if (! str_contains($request->url(), '/query')) {
                return false;
            }
            $query = $request['query'];
            $this->assertStringContainsString('tostring(customDimensions["userId"]) == "owner@example.com"', $query);
            $this->assertStringContainsString('tostring(customDimensions["webhookUrl"]) == "https://workflow.example/webhook/shared"', $query);
            $this->assertStringContainsString('datetime(2026-09-01T00:00:00+00:00)', $query);
            $this->assertStringNotContainsString('other@example.com', $query);

            return $request->hasHeader('Authorization', 'Bearer server-only-token');
        });
        Http::assertSent(fn (Request $request): bool => str_contains($request->url(), '/oauth2/token')
            && $request['client_secret'] === 'server-only-secret'
            && $request['resource'] === 'https://api.applicationinsights.io');
    }

    public function test_guests_and_unverified_users_never_trigger_analytics_queries(): void
    {
        Http::fake();
        $this->get('/dashboard')->assertRedirect('/login');
        $this->actingAs(User::factory()->unverified()->create())->get('/dashboard')->assertRedirect('/email/verify');
        Http::assertNothingSent();
    }

    public function test_query_values_are_escaped_even_when_an_email_contains_quotes(): void
    {
        $this->fakeAzure($this->azureResult());
        $email = '"odd\\name"@example.com';
        $user = User::factory()->create(['email' => $email]);
        app(AccountUsage::class)->forUser($user);

        Http::assertSent(function (Request $request) use ($email): bool {
            if (! str_contains($request->url(), '/query')) {
                return false;
            }
            // The literal must round-trip without adding a query operator.
            $line = explode("\n", explode('customDimensions["userId"]) == ', $request['query'])[1])[0];
            $literal = substr($line, 0, -2);

            return json_decode($literal, true, flags: JSON_THROW_ON_ERROR) === $email;
        });
    }

    public function test_cache_is_separate_per_account_email_and_month_and_expires_after_five_minutes(): void
    {
        $this->fakeAzure($this->azureResult());
        $service = app(AccountUsage::class);
        $first = User::factory()->create();
        $second = User::factory()->create();
        $service->forUser($first);
        $service->forUser($first);
        Http::assertSentCount(2);
        $service->forUser($second);
        Http::assertSentCount(4);
        $first->email = 'changed@example.com';
        $service->forUser($first);
        Http::assertSentCount(6);
        $this->travel(301)->seconds();
        $service->forUser($first);
        Http::assertSentCount(8);

        $this->travelTo(now('UTC')->setDate(2026, 9, 30)->setTime(23, 59));
        $service->forUser($first);
        $this->travel(2)->minutes();
        $this->assertSame('October 2026', $service->forUser($first)['month']);
        Http::assertSentCount(12);
    }

    public function test_empty_results_are_zero_but_missing_measurements_are_not(): void
    {
        $user = User::factory()->create();
        $this->fakeAzure($this->azureResult([
            'trace_events' => 0, 'requests' => 0, 'request_events' => 0,
            'total_tokens' => 0, 'token_events' => 0, 'avg_seconds' => null, 'duration_samples' => 0,
        ]));
        $usage = app(AccountUsage::class)->forUser($user);
        $this->assertTrue($usage['available']);
        $this->assertSame(0, $usage['requests']);
        $this->assertSame(0, $usage['tokens']);
        $this->assertNull($usage['avg_seconds']);

        Cache::flush();
        $this->fakeAzure($this->azureResult([
            'trace_events' => 3, 'request_events' => 0, 'token_events' => 0,
            'duration_samples' => 0, 'avg_seconds' => null,
        ]));
        $usage = app(AccountUsage::class)->forUser($user);
        $this->assertTrue($usage['available']);
        $this->assertNull($usage['requests']);
        $this->assertNull($usage['tokens']);
        $this->assertNull($usage['avg_seconds']);
    }

    public function test_missing_configuration_does_not_make_anonymous_requests(): void
    {
        config(['analytics.client_secret' => '']);
        Http::fake();
        $this->actingAs(User::factory()->create())->get('/dashboard')->assertOk()
            ->assertSee('Usage data is currently unavailable.')->assertDontSee('Tokens used');
        Http::assertNothingSent();
    }

    public function test_http_errors_partial_and_malformed_results_show_unavailable_and_are_cached(): void
    {
        $user = User::factory()->create();
        foreach ([
            [[], 401], [[], 429], [[], 500],
            [$this->azureResult() + ['error' => ['code' => 'PartialError']], 200],
            [['tables' => []], 200],
            [$this->azureResult(['total_tokens' => 'invalid']), 200],
            [$this->azureResult(['avg_seconds' => null]), 200],
        ] as [$body, $status]) {
            Cache::flush();
            $this->fakeAzure($body, $status);
            $this->actingAs($user)->get('/dashboard')->assertOk()
                ->assertSee('Usage data is currently unavailable.')->assertDontSee('Tokens used');
            $this->assertFalse(app(AccountUsage::class)->forUser($user)['available']);
            Http::assertSentCount(2);
        }
    }

    public function test_connection_and_token_errors_do_not_break_the_dashboard(): void
    {
        $user = User::factory()->create();
        foreach ([Http::failedConnection(), Http::response(['error' => 'invalid_client'], 401), Http::response([])] as $response) {
            Cache::flush();
            Http::swap(new Factory);
            Http::preventStrayRequests();
            Http::fake(['*' => $response]);
            $this->actingAs($user)->get('/dashboard')->assertOk()
                ->assertSee('Usage data is currently unavailable.');
        }
    }

    private function fakeAzure(array $body, int $status = 200): void
    {
        Http::swap(new Factory);
        Http::preventStrayRequests();
        Http::fake([
            'https://login.microsoftonline.com/*' => Http::response(['access_token' => 'server-only-token']),
            'https://api.applicationinsights.io/*' => Http::response($body, $status),
        ]);
    }

    private function azureResult(array $overrides = []): array
    {
        // Deliberately put columns in a different order than the KQL projection.
        $values = array_replace([
            'avg_seconds' => 1.25, 'total_tokens' => 12345, 'requests' => 7,
            'trace_events' => 14, 'request_events' => 14, 'token_events' => 7, 'duration_samples' => 7,
        ], $overrides);

        return ['tables' => [[
            'name' => 'PrimaryResult',
            'columns' => array_map(fn (string $name): array => ['name' => $name, 'type' => $name === 'avg_seconds' ? 'real' : 'long'], array_keys($values)),
            'rows' => [array_values($values)],
        ]]];
    }
}
