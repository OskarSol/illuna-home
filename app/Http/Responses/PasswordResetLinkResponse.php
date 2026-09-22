<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;

class PasswordResetLinkResponse implements FailedPasswordResetLinkRequestResponse, SuccessfulPasswordResetLinkRequestResponse
{
    public function toResponse($request)
    {
        $message = 'If an account exists for this address, a password reset link will be sent. Please check your inbox.';

        return $request->wantsJson()
            ? response()->json(['message' => $message])
            : back()->with('status', $message);
    }
}
