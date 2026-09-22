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
