<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#faf9fd">
    <title>@yield('title') · Illuna</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/portal.css') }}">
</head>
<body class="portal-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <aside class="sidebar">
        <x-brand />
        <span class="sidebar-label">YOUR WORKSPACE</span>
        <nav aria-label="Account navigation" class="portal-nav">
            <a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif><span aria-hidden="true">◫</span> Overview</a>
            <a href="{{ route('settings') }}" @if(request()->routeIs('settings')) aria-current="page" @endif><span aria-hidden="true">⚙</span> Account settings</a>
            <a href="{{ route('billing') }}" @if(request()->routeIs('billing')) aria-current="page" @endif><span aria-hidden="true">▤</span> Billing</a>
        </nav>
        <div class="sidebar-bottom">
            <p>Software,<br><strong>more personal.</strong></p>
            <a href="{{ route('home') }}" class="quiet-link">Visit website <span aria-hidden="true">↗</span></a>
        </div>
    </aside>
    <div class="portal-content">
        <header class="portal-topbar">
            <span class="breadcrumb">My account <span aria-hidden="true">/</span> <strong>@yield('title')</strong></span>
            <div class="account-actions">
                @if (! app()->environment('production'))<span class="badge">Playground</span>@endif
                <span class="avatar" aria-hidden="true">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="text-button">Sign out</button></form>
            </div>
        </header>
        <main id="main" class="portal-main">
            <x-feedback />
            @yield('content')
        </main>
        <footer class="portal-footer">© {{ date('Y') }} Illuna <span>Your space to make it yours.</span></footer>
    </div>
</body>
</html>
