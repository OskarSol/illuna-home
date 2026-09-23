<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApiKeyController extends Controller
{
    public function show(Request $request): View
    {
        return view('portal.api-key', ['user' => $request->user()]);
    }

    public function rotate(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password:web'],
        ]);

        $user = $request->user();
        $user->issueApiKey();
        $user->save();

        return to_route('api-key.show')->with('status', 'api-key-renewed');
    }
}
