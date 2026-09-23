<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $chapter['description'] ?? 'Explore Illuna: concepts, reference architecture, personalization and adaptive UI patterns.' }}">
    <meta name="theme-color" content="#faf9fd">
    @if (config('illuna.noindex'))<meta name="robots" content="noindex, nofollow">@endif
    <title>{{ $chapter['title'] ?? 'Documentation' }} · Illuna Docs</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/portal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/documentation.css') }}">
</head>
<body class="docs-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="docs-header">
        <div class="docs-brand"><x-brand /><span class="docs-divider" aria-hidden="true">/</span><a href="{{ route('docs.index') }}">Documentation</a></div>
        <nav aria-label="Main navigation"><a href="{{ route('home') }}">Product</a><a class="button" href="{{ route('login') }}">Sign in <span aria-hidden="true">↗</span></a></nav>
    </header>
    <div class="docs-layout">
        <aside class="docs-sidebar" aria-label="Documentation navigation">
            <form action="{{ route('docs.index') }}" method="GET" role="search" class="docs-search">
                <label for="docs-query">Search documentation</label>
                <div><input id="docs-query" name="q" type="search" maxlength="100" value="{{ $query ?? '' }}" placeholder="Intent, context, memory…"><button type="submit" aria-label="Search documentation">→</button></div>
            </form>
            <details class="docs-menu" open>
                <summary>Explore the documentation</summary>
                <nav aria-label="Chapters">
                    <a href="{{ route('docs.index') }}" @if (!isset($page)) aria-current="page" @endif>Overview</a>
                    @foreach ($chapters as $slug => $item)
                        <a href="{{ route('docs.show', $slug) }}" @if (($page ?? '') === $slug) aria-current="page" @endif><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $item['title'] }}</a>
                    @endforeach
                </nav>
            </details>
            <div class="docs-status"><span class="badge">Prototyping</span><p>Concepts and patterns for adaptive applications. Capabilities described here are being explored and developed.</p></div>
        </aside>
        <main id="main" class="docs-main" tabindex="-1">@yield('content')</main>
        @isset($toc)
            <aside class="docs-toc" aria-label="On this page"><p>On this page</p><nav>@foreach ($toc as $heading)<a href="#{{ $heading['id'] }}">{{ $heading['title'] }}</a>@endforeach</nav><a class="docs-back-top" href="#main">Back to top ↑</a></aside>
        @endisset
    </div>
    <footer class="docs-footer">© {{ date('Y') }} Illuna <span>Software, more personal.</span></footer>
</body>
</html>
