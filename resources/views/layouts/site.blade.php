<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title', 'Illuna — Every App Should Feel Like It Was Made for You')</title>
    <meta name="description" content="@yield('description', 'Meet Illuna, an adaptive application framework for more personal software experiences.')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Illuna">
    <meta property="og:title" content="@yield('title', 'Illuna — Software, made personal.')">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/landing.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.site-icons')
    <a class="skip" href="#main">Skip to content</a>
  <header class="site-header" id="site-header">
    <nav class="wrap nav-row" aria-label="Main navigation">
      <a class="brand" href="{{ route('home') }}" aria-label="Illuna home"><svg class="brand-mark" aria-hidden="true"><use href="#i-mark"/></svg>illuna</a>
      <button class="menu-toggle" id="menu-toggle" type="button" aria-expanded="false" aria-controls="nav-links">Menu<svg class="icon" aria-hidden="true"><use href="#i-menu"/></svg></button>
      <div class="nav-links" id="nav-links">
        <a href="{{ route('home') }}#vision">Vision</a><a href="{{ route('home') }}#how-it-works">How it works</a><a href="{{ route('home') }}#pricing">Pricing</a><a href="{{ route('docs.index') }}">Documentation</a>
        <a href="{{ route('demo') }}" @if(request()->routeIs('demo')) aria-current="page" @endif>Try the demos</a>
        @auth
          <a class="nav-cta" href="{{ route('dashboard') }}">My account</a>
        @else
          <a class="nav-cta" href="{{ route('login') }}">Sign in</a>
        @endauth
      </div>
    </nav>
  </header>
    <main id="main">@yield('content')</main>
  <footer class="site-footer"><div class="wrap"><div class="footer-row"><a class="brand" href="{{ route('home') }}" aria-label="Illuna home"><svg class="brand-mark" aria-hidden="true"><use href="#i-mark"/></svg>illuna</a><p class="small">Software, more personal.</p><div class="footer-links"><a href="{{ route('home') }}#vision">Vision</a><a href="{{ route('home') }}#pricing">Pricing</a><a href="{{ route('docs.index') }}">Documentation</a></div></div><p class="footer-note">Illuna is in the prototyping phase. Explore the product vision, try the interactive examples and learn how controlled adaptation works.</p></div></footer>
    <script src="{{ asset('assets/landing.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
