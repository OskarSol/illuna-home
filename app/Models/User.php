<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token', 'api_key', 'api_key_hash'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $attributes = ['plan' => 'free', 'tokens_used' => 0];

    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            $user->issueApiKey();
        });
    }

    /** Assign a fresh key; the caller persists it together with the user. */
    public function issueApiKey(): void
    {
        $key = 'illuna_'.bin2hex(random_bytes(32));

        $this->forceFill([
            'api_key' => $key,
            'api_key_hash' => hash('sha256', $key),
            'api_key_created_at' => now(),
        ]);
    }

    public function planDetails(): array
    {
        return config('illuna.plans.'.$this->plan, [
            'name' => 'Legacy plan', 'label_adaptions' => null, 'full_adaptions' => null,
        ]);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'api_key' => 'encrypted',
            'api_key_created_at' => 'datetime',
            'tokens_used' => 'integer',
        ];
    }
}
