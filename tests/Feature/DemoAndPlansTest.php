<?php

namespace Tests\Feature;

use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoAndPlansTest extends TestCase
{
    use RefreshDatabase;

    public function test_demos_live_on_a_separate_public_page_with_an_illustrative_rest_example(): void
    {
        $this->get('/')->assertOk()->assertSee(route('demo'))->assertDontSee('id="demo-shell"', false);
        $response = $this->get('/demo')->assertOk()->assertSee('id="demo-shell"', false)
            ->assertSee('id="layout-workspace"', false)->assertSee('A small REST example.')
            ->assertSee('https://api.example.com/v1/adapt')->assertSee('YOUR_API_KEY')
            ->assertSee('assets/demo.js')->assertSee('assets/layout-demo.js');

        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?>'.$response->getContent(), LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new DOMXPath($document);
        $this->assertSame(1, $xpath->query('//h1')->length);
        $ids = [];
        foreach ($xpath->query('//*[@id]') as $node) {
            $this->assertNotContains($node->getAttribute('id'), $ids);
            $ids[] = $node->getAttribute('id');
        }
        foreach ($xpath->query('//a[starts-with(@href, "#")]') as $link) {
            $this->assertNotNull($document->getElementById(substr($link->getAttribute('href'), 1)));
        }
        $example = json_decode($document->getElementById('rest-response')->textContent, true, flags: JSON_THROW_ON_ERROR);
        $result = $example[0]['output'][0]['content'][0]['text'];
        $this->assertNotEmpty($result['message']);
        $this->assertCount(5, $result['updates']);
        $request = $document->getElementById('rest-request')->textContent;
        $this->assertStringContainsString('x-api-key: YOUR_API_KEY', $request);
        $payload = json_decode(substr($request, strpos($request, '{'), strrpos($request, '}') - strpos($request, '{') + 1), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('demo-user', $payload['user_id']);
        $this->assertArrayNotHasKey('body', $payload);
        foreach ($result['updates'] as $update) {
            $this->assertSame('Value', $update['field']);
            $this->assertArrayHasKey($update['id'], $payload['ui_elements']);
            $this->assertIsString($update['new_value']);
        }
        $this->assertSame('false', $result['updates'][4]['new_value']);
    }

    public function test_pricing_is_consistent_and_paid_bookings_are_unavailable(): void
    {
        $this->get('/')->assertOk()->assertSee('id="pricing"', false)
            ->assertSee('1,000 Label Adaptions / month')->assertSee('500 Full Adaptions / month')
            ->assertSee('€9.90')->assertSee('+1,000 Full Adaptions')->assertSee('€10 per bundle')
            ->assertDontSee('Up to 1,000 free requests per month.');

        $user = User::factory()->create(['tokens_used' => 250000]);
        $this->assertSame('free', $user->plan);
        foreach (['/dashboard', '/billing'] as $url) {
            $this->actingAs($user)->get($url)->assertOk()->assertSee('Current plan')
                ->assertSee('€9.90')->assertSee('€10 per bundle')->assertSee('Not connected yet')
                ->assertDontSee('Available tokens')->assertDontSee('Usage-based')
                ->assertDontSee('250,000')->assertDontSee('750,000');
        }
        $this->post('/billing', ['plan' => 'beta'])->assertStatus(405);
        $this->assertSame('free', $user->fresh()->plan);
        $this->assertSame(250000, $user->fresh()->tokens_used);
    }

    public function test_existing_beta_and_legacy_accounts_render_without_reassignment(): void
    {
        $user = User::factory()->create(['plan' => 'beta', 'tokens_used' => 1250000]);
        $this->actingAs($user)->get('/billing')->assertOk()->assertSee('500 Full Adaptions / month')
            ->assertSee('Existing Beta access does not become a paid subscription automatically.');
        $this->assertSame('beta', $user->fresh()->plan);
        $this->assertSame(1250000, $user->fresh()->tokens_used);
        $user->forceFill(['plan' => 'usage'])->save();
        $this->get('/dashboard')->assertOk()->assertSee('Legacy plan');
        $this->assertSame('usage', $user->fresh()->plan);
    }
}
