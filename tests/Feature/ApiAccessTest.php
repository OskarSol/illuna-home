<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApiAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_issues_a_private_unique_key_and_assigns_free_server_side(): void
    {
        Notification::fake();
        $this->travelTo(now()->startOfSecond());
        $this->post('/register', [
            'name' => 'Beta Tester', 'email' => 'beta@example.test',
            'invitation_code' => 'testing-invite-only',
            'password' => 'a-long-test-passphrase', 'password_confirmation' => 'a-long-test-passphrase',
            'plan' => 'usage', 'tokens_used' => 9000, 'api_key' => 'attacker-controlled',
            'api_key_hash' => 'attacker-controlled', 'last_login_at' => '2000-01-01',
        ])->assertRedirect('/dashboard');

        $user = User::firstOrFail();
        $this->assertSame('free', $user->plan);
        $this->assertSame(0, $user->tokens_used);
        $this->assertTrue($user->created_at->equalTo(now()));
        $this->assertTrue($user->last_login_at->equalTo(now()));
        $this->assertTrue($user->api_key_created_at->equalTo(now()));
        $this->assertMatchesRegularExpression('/^illuna_[a-f0-9]{64}$/', $user->api_key);
        $this->assertSame(hash('sha256', $user->api_key), $user->api_key_hash);
        $raw = DB::table('users')->where('id', $user->id)->value('api_key');
        $this->assertNotSame($user->api_key, $raw);
        $this->assertStringNotContainsString($user->api_key, $raw);
        $this->assertArrayNotHasKey('api_key', $user->toArray());
        $this->assertArrayNotHasKey('api_key_hash', $user->toArray());
        $other = User::factory()->create();
        $this->assertNotSame($other->api_key, $user->api_key);
        $this->expectException(QueryException::class);
        DB::table('users')->where('id', $other->id)->update(['api_key_hash' => $user->api_key_hash]);
    }

    public function test_last_login_changes_only_after_successful_authentication(): void
    {
        $this->travelTo(now()->startOfSecond());
        $lastLogin = now()->subDays(2);
        $user = User::factory()->create(['password' => 'a-long-test-passphrase', 'last_login_at' => $lastLogin]);
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertTrue($user->fresh()->last_login_at->equalTo($lastLogin));
        $this->post('/login', ['email' => $user->email, 'password' => 'a-long-test-passphrase'])->assertRedirect('/dashboard');
        $this->assertTrue($user->fresh()->last_login_at->equalTo(now()));
        $this->travel(2)->hours();
        $this->get('/dashboard')->assertOk();
        $this->assertTrue($user->fresh()->last_login_at->equalTo(now()->subHours(2)));
    }

    public function test_key_pages_and_rotation_require_login_and_verification(): void
    {
        $this->get('/api-key')->assertRedirect('/login');
        $this->post('/api-key/rotate')->assertRedirect('/login');
        $user = User::factory()->unverified()->create();
        $this->actingAs($user)->get('/api-key')->assertRedirect('/email/verify');
        $this->post('/api-key/rotate')->assertRedirect('/email/verify');
        $this->assertSame($user->api_key, $user->fresh()->api_key);
    }

    public function test_only_the_signed_in_users_key_appears_and_responses_are_not_cached(): void
    {
        $endpoint = 'https://private-api.example.test/webhook-test/demo';
        config(['illuna.api_url' => $endpoint]);
        $user = User::factory()->create();
        $other = User::factory()->create();
        $response = $this->actingAs($user)->get('/api-key?user_id='.$other->id)
            ->assertOk()->assertSee($user->api_key)->assertSee('x-api-key: '.$user->api_key)
            ->assertDontSee($other->api_key)->assertSee('A small REST example.')
            ->assertSee($endpoint)->assertSee('This is a test webhook.');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        foreach (['/demo', '/docs/examples-and-implementation'] as $path) {
            $this->get($path)->assertOk()->assertSee('YOUR_API_KEY')
                ->assertSee('https://api.example.com/v1/adapt')
                ->assertDontSee($user->api_key)->assertDontSee($other->api_key)->assertDontSee($endpoint);
        }
        $this->get('/dashboard')->assertOk()->assertDontSee($user->api_key);
        config(['illuna.api_url' => null]);
        $this->get('/api-key')->assertOk()->assertSee('Your API endpoint is being prepared.')
            ->assertDontSee('id="personal-request"', false);
    }

    public function test_rotation_requires_current_password_and_replaces_only_own_key(): void
    {
        $user = User::factory()->create(['password' => 'a-long-test-passphrase', 'tokens_used' => 250000]);
        $other = User::factory()->create();
        $oldKey = $user->api_key;
        $oldHash = $user->api_key_hash;
        $this->actingAs($user)->from('/api-key')->post('/api-key/rotate')->assertSessionHasErrors('current_password');
        $this->post('/api-key/rotate', ['current_password' => 'wrong'])->assertSessionHasErrors('current_password');
        $this->assertSame($oldKey, $user->fresh()->api_key);
        $this->post('/api-key/rotate', [
            'current_password' => 'a-long-test-passphrase', 'id' => $other->id,
            'api_key' => 'attacker-controlled', 'plan' => 'usage', 'tokens_used' => 0,
        ])->assertRedirect('/api-key')->assertSessionHas('status', 'api-key-renewed');
        $updated = $user->fresh();
        $this->assertNotSame($oldKey, $updated->api_key);
        $this->assertSame(hash('sha256', $updated->api_key), $updated->api_key_hash);
        $this->assertDatabaseMissing('users', ['api_key_hash' => $oldHash]);
        $this->assertSame('free', $updated->plan);
        $this->assertSame(250000, $updated->tokens_used);
        $this->assertSame($other->api_key, $other->fresh()->api_key);
        $this->assertNull(session('_old_input.current_password'));
        $this->get('/api-key')->assertOk()->assertSee($updated->api_key)->assertDontSee($oldKey);
    }

    public function test_rotation_has_csrf_protection_and_a_rate_limit(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->app->instance('env', 'production');
        $this->post('/api-key/rotate', ['current_password' => 'password'])->assertStatus(419);
        $this->app->instance('env', 'testing');
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/api-key/rotate', ['current_password' => 'wrong'])->assertSessionHasErrors('current_password');
        }
        $this->post('/api-key/rotate', ['current_password' => 'wrong'])->assertStatus(429);
        $this->assertSame($user->api_key, $user->fresh()->api_key);
    }
}
