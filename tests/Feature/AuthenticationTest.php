<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_hashes_password_and_requires_email_verification(): void
    {
        Notification::fake();
        $this->post('/register', [
            'name' => 'Oskar', 'email' => 'OSKAR@example.com',
            'invitation_code' => 'testing-invite-only',
            'password' => 'a-long-test-passphrase', 'password_confirmation' => 'a-long-test-passphrase',
            'email_verified_at' => now(), 'id' => 9000,
        ])->assertRedirect('/dashboard');

        $user = User::firstOrFail();
        $this->assertSame('oskar@example.com', $user->email);
        $this->assertNotSame(9000, $user->id);
        $this->assertTrue(Hash::check('a-long-test-passphrase', $user->password));
        $this->assertNull($user->email_verified_at);
        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, VerifyEmail::class);
        $this->get('/dashboard')->assertRedirect('/email/verify');
    }

    public function test_registration_rejects_duplicate_email_and_short_passwords(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $this->post('/register', [
            'name' => 'Another person', 'email' => 'TAKEN@example.com',
            'invitation_code' => 'testing-invite-only',
            'password' => 'short', 'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['email', 'password']);
        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_registration_can_be_closed_including_when_routes_were_cached_open(): void
    {
        config(['illuna.registration_enabled' => false]);
        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Blocked', 'email' => 'blocked@example.com',
            'password' => 'a-long-test-passphrase', 'password_confirmation' => 'a-long-test-passphrase',
        ])->assertNotFound();
        $this->assertDatabaseCount('users', 0);
        $this->get('/login')->assertOk();
    }

    public function test_login_rejects_wrong_password_then_accepts_valid_credentials_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'a-long-test-passphrase']);
        $this->post('/login', ['email' => $user->email, 'password' => 'incorrect'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post('/login', ['email' => $user->email, 'password' => 'a-long-test-passphrase'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
        $this->get('/dashboard')->assertOk();
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_login_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'wrong']);
        }
        $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'wrong'])->assertStatus(429);
    }

    public function test_verification_requires_a_valid_signature_and_matching_user(): void
    {
        $user = User::factory()->unverified()->create();
        $other = User::factory()->unverified()->create();
        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(30), [
            'id' => $user->id, 'hash' => sha1($user->email),
        ]);

        $this->actingAs($other)->get($url)->assertForbidden();
        $this->actingAs($user)->get($url.'&tampered=yes')->assertForbidden();
        $expired = URL::temporarySignedRoute('verification.verify', now()->subMinute(), [
            'id' => $user->id, 'hash' => sha1($user->email),
        ]);
        $this->get($expired)->assertForbidden();
        $this->get($url)->assertRedirect('/dashboard?verified=1');
        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->get('/dashboard')->assertOk();
    }

    public function test_password_reset_uses_a_real_token_and_does_not_reveal_unknown_addresses(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $known = $this->from('/forgot-password')->post('/forgot-password', ['email' => $user->email]);
        $known->assertRedirect('/forgot-password')->assertSessionHas('status');
        $message = session('status');
        Notification::assertSentTo($user, ResetPassword::class);
        $this->post('/forgot-password', ['email' => 'unknown@example.com'])->assertSessionHas('status', $message);

        $this->post('/reset-password', [
            'email' => $user->email, 'token' => 'invalid-token',
            'password' => 'a-new-long-passphrase', 'password_confirmation' => 'a-new-long-passphrase',
        ])->assertSessionHasErrors('email');

        $token = Password::broker()->createToken($user);
        $this->post('/reset-password', [
            'email' => $user->email, 'token' => $token,
            'password' => 'a-new-long-passphrase', 'password_confirmation' => 'a-new-long-passphrase',
        ])->assertRedirect('/login');
        $this->assertTrue(Hash::check('a-new-long-passphrase', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_password_reset_requests_are_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/forgot-password', ['email' => "nobody{$i}@example.com"]);
        }
        $this->post('/forgot-password', ['email' => 'another@example.com'])->assertStatus(429);
    }

    public function test_csrf_protection_is_active_outside_the_testing_bypass(): void
    {
        $this->app->instance('env', 'production');
        $this->post('/login', ['email' => 'user@example.com', 'password' => 'anything'])->assertStatus(419);
    }
}
