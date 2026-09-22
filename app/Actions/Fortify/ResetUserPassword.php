<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    public function reset(User $user, array $input): void
    {
        Validator::make($input, ['password' => $this->passwordRules()])->validate();
        $user->forceFill(['password' => $input['password']])->save();

        if (config('session.driver') === 'database') {
            DB::connection(config('session.connection'))->table(config('session.table'))
                ->where('user_id', $user->id)->delete();
        }
    }
}
