<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Responses\PasswordResetLinkResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            FailedPasswordResetLinkRequestResponse::class,
            PasswordResetLinkResponse::class,
        );
        $this->app->bind(
            SuccessfulPasswordResetLinkRequestResponse::class,
            PasswordResetLinkResponse::class,
        );
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn (Request $request) => view('auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn () => view('auth.verify-email'));
        Fortify::confirmPasswordView(fn () => view('auth.confirm-password'));

        RateLimiter::for('login', fn (Request $request) => [
            Limit::perMinute(5)->by('login:'.Str::lower((string) $request->input('email')).'|'.$request->ip()),
            Limit::perMinute(30)->by('login-ip:'.$request->ip()),
        ]);

        RateLimiter::for('account-actions', fn (Request $request) => Limit::perMinute(5)->by($request->route()->getName().'|'.$request->ip())
        );
    }
}
