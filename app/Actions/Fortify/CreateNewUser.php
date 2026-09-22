<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // Validate access before checking account details or creating a user.
        Validator::make($input, [
            'invitation_code' => [
                'bail', 'required', 'string', 'max:128',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $expected = config('illuna.beta_invite_code');

                    if (! is_string($expected) || trim($expected) === '' || ! hash_equals($expected, $value)) {
                        $fail('This invitation code is invalid or no longer active.');
                    }
                },
            ],
        ], [
            'invitation_code.required' => 'You need an invitation code to join the closed beta.',
        ])->validate();

        $input['email'] = Str::lower(trim((string) ($input['email'] ?? '')));
        $input['name'] = trim((string) ($input['name'] ?? ''));

        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:254', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
