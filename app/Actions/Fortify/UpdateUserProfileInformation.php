<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        $input['email'] = Str::lower(trim((string) ($input['email'] ?? '')));
        $input['name'] = trim((string) ($input['name'] ?? ''));
        $emailChanged = $input['email'] !== $user->email;

        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:254', Rule::unique(User::class)->ignore($user->id)],
            'current_password' => $emailChanged ? ['required', 'current_password:web'] : ['nullable'],
        ])->validateWithBag('updateProfileInformation');

        $user->forceFill(['name' => $input['name'], 'email' => $input['email']]);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }
    }
}
