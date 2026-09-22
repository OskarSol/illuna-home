<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_and_guest_forms_render_with_original_demo_assets(): void
    {
        $this->get('/')->assertOk()->assertSee('Every App Should Feel')
            ->assertSee('assets/landing.js')->assertSee('assets/landing.css')
            ->assertSee('Sign in')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        foreach (['/login', '/register', '/forgot-password', '/reset-password/sample?email=user@example.com'] as $url) {
            $this->get($url)->assertOk()->assertSee('assets/portal.css');
        }
        $this->get('/robots.txt')->assertSee('Disallow: /');
        config(['illuna.noindex' => false]);
        $this->get('/robots.txt')->assertDontSee('Disallow: /');
    }

    public function test_portal_pages_require_login_and_verification(): void
    {
        foreach (['/dashboard', '/settings', '/billing'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->actingAs(User::factory()->unverified()->create());
        foreach (['/dashboard', '/settings', '/billing'] as $url) {
            $this->get($url)->assertRedirect('/email/verify');
        }
        $this->get('/email/verify')->assertOk();
    }

    public function test_verified_users_see_their_own_account_and_honest_empty_states(): void
    {
        $user = User::factory()->create(['name' => '<script>alert(1)</script>']);
        $other = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertOk()->assertSee($user->name)->assertDontSee($user->name, false)
            ->assertSee($user->email)->assertDontSee($other->email)->assertSee('Not connected yet');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->get('/settings')->assertOk()->assertSee('Save details');
        $this->get('/billing')->assertOk()->assertSee('Coming soon');
    }

    public function test_profile_updates_cannot_change_another_user_or_verification_state(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $this->actingAs($user)->from('/settings')->put('/user/profile-information', [
            'id' => $other->id, 'name' => 'Updated name', 'email' => $user->email,
            'email_verified_at' => null, 'password' => 'malicious-change',
        ])->assertRedirect('/settings')->assertSessionHas('status', 'profile-information-updated');
        $this->assertSame('Updated name', $user->fresh()->name);
        $this->assertSame($other->name, $other->fresh()->name);
        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertFalse(Hash::check('malicious-change', $user->fresh()->password));
    }

    public function test_changing_email_requires_current_password_and_reverification(): void
    {
        Notification::fake();
        $user = User::factory()->create(['password' => 'old-long-passphrase']);
        $this->actingAs($user)->put('/user/profile-information', [
            'name' => $user->name, 'email' => 'changed@example.com',
        ])->assertSessionHasErrorsIn('updateProfileInformation', 'current_password');
        $this->assertSame($user->email, $user->fresh()->email);
        $this->put('/user/profile-information', [
            'name' => $user->name, 'email' => 'changed@example.com', 'current_password' => 'old-long-passphrase',
        ])->assertSessionHasNoErrors();
        $this->assertSame('changed@example.com', $user->fresh()->email);
        $this->assertNull($user->fresh()->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);
        $this->get('/dashboard')->assertRedirect('/email/verify');
    }

    public function test_changing_password_requires_current_password_and_keeps_current_session(): void
    {
        $user = User::factory()->create(['password' => 'old-long-passphrase']);
        $this->actingAs($user)->put('/user/password', [
            'current_password' => 'wrong', 'password' => 'new-long-passphrase', 'password_confirmation' => 'new-long-passphrase',
        ])->assertSessionHasErrorsIn('updatePassword', 'current_password');
        $this->assertTrue(Hash::check('old-long-passphrase', $user->fresh()->password));
        $this->put('/user/password', [
            'current_password' => 'old-long-passphrase', 'password' => 'new-long-passphrase', 'password_confirmation' => 'new-long-passphrase',
        ])->assertSessionHas('status', 'password-updated');
        $this->assertTrue(Hash::check('new-long-passphrase', $user->fresh()->password));
        $this->get('/dashboard')->assertOk();
    }

    public function test_password_change_removes_other_database_sessions_and_remember_token(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['password' => 'old-long-passphrase']);
        $other = User::factory()->create();
        foreach (['old-device' => $user->id, 'other-account' => $other->id] as $id => $userId) {
            DB::table('sessions')->insert(['id' => $id, 'user_id' => $userId, 'payload' => '', 'last_activity' => time()]);
        }
        $oldRememberToken = $user->remember_token;
        $this->actingAs($user)->put('/user/password', [
            'current_password' => 'old-long-passphrase', 'password' => 'new-long-passphrase', 'password_confirmation' => 'new-long-passphrase',
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('sessions', ['id' => 'old-device']);
        $this->assertDatabaseHas('sessions', ['id' => 'other-account']);
        $this->assertNotSame($oldRememberToken, $user->fresh()->remember_token);
    }

    public function test_password_reset_removes_existing_database_sessions(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create();
        DB::table('sessions')->insert(['id' => 'old-device', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);
        $token = Password::broker()->createToken($user);
        $this->post('/reset-password', [
            'email' => $user->email, 'token' => $token,
            'password' => 'a-new-long-passphrase', 'password_confirmation' => 'a-new-long-passphrase',
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('sessions', ['id' => 'old-device']);
    }
}
