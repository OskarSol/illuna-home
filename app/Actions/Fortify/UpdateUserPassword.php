<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => $input['password'],
            'remember_token' => Str::random(60),
        ])->save();

        if (config('session.driver') === 'database') {
            DB::connection(config('session.connection'))->table(config('session.table'))
                ->where('user_id', $user->id)
                ->where('id', '!=', request()->session()->getId())
                ->delete();
        }

        request()->session()->regenerate();
        request()->session()->put('password_hash_'.Auth::getDefaultDriver(), $user->getAuthPassword());
    }
}
