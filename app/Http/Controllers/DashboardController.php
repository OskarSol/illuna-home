<?php

namespace App\Http\Controllers;

use App\Services\AccountUsage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, AccountUsage $usage): View
    {
        return view('portal.dashboard', ['usage' => $usage->forUser($request->user())]);
    }
}
