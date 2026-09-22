<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BetaInvitationTest extends TestCase
{
    use RefreshDatabase;

    private function registration(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Beta tester',
            'email' => 'beta@example.com',
            'password' => 'a-long-beta-passphrase',
            'password_confirmation' => 'a-long-beta-passphrase',
            'invitation_code' => 'testing-invite-only',
        ], $overrides);
    }

    public function test_missing_wrong_and_malformed_codes_cannot_create_accounts(): void
    {
        Notification::fake();

        foreach ([null, '', 'wrong-code', 'TESTING-INVITE-ONLY', ['testing-invite-only']] as $code) {
            $this->from('/register')->post('/register', $this->registration(['invitation_code' => $code]))
                ->assertRedirect('/register')->assertSessionHasErrors('invitation_code');
            $this->assertGuest();
            $this->assertDatabaseCount('users', 0);
        }

        Notification::assertNothingSent();
    }

    public function test_empty_server_configuration_fails_closed(): void
    {
        foreach ([null, '', '   '] as $configuredCode) {
            config(['illuna.beta_invite_code' => $configuredCode]);
            $this->post('/register', $this->registration())->assertSessionHasErrors('invitation_code');
            $this->assertDatabaseCount('users', 0);
        }
    }

    public function test_code_is_not_exposed_in_html_or_flashed_after_validation_errors(): void
    {
        $this->get('/register')->assertOk()->assertSee('Invitation code')->assertDontSee('testing-invite-only');
        $this->from('/register')->post('/register', $this->registration(['name' => '']))
            ->assertSessionHasErrors('name')->assertSessionMissing('_old_input.invitation_code');
        $this->get('/register')->assertDontSee('testing-invite-only');
        $this->from('/register')->post('/register', $this->registration(['invitation_code' => 'a-wrong-private-code']))
            ->assertSessionHasErrors('invitation_code')->assertSessionMissing('_old_input.invitation_code');
        $this->get('/register')->assertDontSee('a-wrong-private-code');
    }

    public function test_rotating_the_code_rejects_the_old_one_and_accepts_the_new_one(): void
    {
        Notification::fake();
        config(['illuna.beta_invite_code' => 'rotated-invite-for-testers']);
        $this->post('/register', $this->registration())->assertSessionHasErrors('invitation_code');
        $this->assertDatabaseCount('users', 0);
        $this->post('/register', $this->registration(['invitation_code' => 'rotated-invite-for-testers']))
            ->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $user = User::firstOrFail();
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_direct_json_registration_requests_require_the_code(): void
    {
        $this->postJson('/register', $this->registration(['invitation_code' => null]))
            ->assertUnprocessable()->assertJsonValidationErrors('invitation_code');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_code_guessing_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/register', $this->registration(['invitation_code' => 'wrong']))
                ->assertSessionHasErrors('invitation_code');
        }

        $this->post('/register', $this->registration())->assertStatus(429);
        $this->assertDatabaseCount('users', 0);
    }
}
