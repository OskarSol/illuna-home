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
<body class="auth-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="auth-header">
        <x-brand />
        <a class="quiet-link" href="{{ route('home') }}">Back to website <span aria-hidden="true">↗</span></a>
    </header>
    <main id="main" class="auth-grid">
        <section class="auth-story" aria-label="About your Illuna account">
            <span class="eyebrow">SOFTWARE, MADE PERSONAL.</span>
            <h1>A little more<br>you. <span>Everywhere.</span></h1>
            <p>Your account, your preferences, your space. Bring your Illuna experience together in one place.</p>
            <div class="identity-art" aria-hidden="true">
                <span class="art-line line-one"></span><span class="art-line line-two"></span><span class="art-line line-three"></span>
            </div>
            <span class="story-foot">Familiar by design. Personal by nature.</span>
        </section>
        <section class="auth-card" aria-labelledby="form-title">
            @if (! app()->environment('production'))<span class="badge">Playground</span>@endif
            <h2 id="form-title">@yield('title')</h2>
            <p class="intro">@yield('intro')</p>
            <x-feedback />
            @yield('content')
        </section>
    </main>
    <footer class="auth-footer">© {{ date('Y') }} Illuna <span>Software, more personal.</span></footer>
</body>
</html>
