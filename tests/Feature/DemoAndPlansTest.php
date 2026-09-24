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

    public function test_usage_comes_from_the_account_and_paid_bookings_are_unavailable(): void
    {
        $user = User::factory()->create(['tokens_used' => 250000]);
        $this->actingAs($user)->get('/dashboard')->assertOk()->assertSee('250,000')->assertSee('750,000')
            ->assertSee('Beta')->assertSee('25.0%')->assertSee('Not connected yet');
        $this->get('/billing')->assertOk()->assertSee('1,000,000')->assertSee('€10')
            ->assertSee('Coming soon')->assertSee('No payments are collected')->assertSee('Current plan');
        $this->get('/demo')->assertOk();
        $this->assertSame(250000, $user->fresh()->tokens_used);
        $this->post('/billing', ['plan' => 'usage'])->assertStatus(405);
        $this->assertSame('beta', $user->fresh()->plan);
    }

    public function test_usage_display_handles_exhausted_and_unlimited_plans(): void
    {
        $user = User::factory()->create(['tokens_used' => 1250000]);
        $this->assertSame(0, $user->remainingTokens());
        $this->actingAs($user)->get('/billing')->assertOk()->assertSee('100.0%')->assertDontSee('125.0%');
        $user->forceFill(['plan' => 'usage'])->save();
        $this->assertNull($user->remainingTokens());
        $this->get('/dashboard')->assertOk()->assertSee('Usage-based')->assertSee('No fixed allowance');
    }
}
