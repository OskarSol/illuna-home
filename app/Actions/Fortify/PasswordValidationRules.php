<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    protected function passwordRules(): array
    {
        return [
            'required', 'string', 'max:72', Password::min(12), 'confirmed',
            function (string $attribute, mixed $value, \Closure $fail): void {
                if (is_string($value) && strlen($value) > 72) {
                    $fail('Please use a shorter password; accented characters and emoji may use extra space.');
                }
            },
        ];
    }
}
