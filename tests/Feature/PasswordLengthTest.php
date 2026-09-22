<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordLengthTest extends TestCase
{
    use RefreshDatabase;

    public function test_unicode_passwords_cannot_exceed_the_bcrypt_byte_limit(): void
    {
        $password = str_repeat('🔒', 20);
        $this->post('/register', [
            'name' => 'Test', 'email' => 'unicode@example.com',
            'invitation_code' => 'testing-invite-only',
            'password' => $password, 'password_confirmation' => $password,
        ])->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }
}
