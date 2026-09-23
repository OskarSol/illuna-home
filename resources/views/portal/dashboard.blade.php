@extends('layouts.portal')
@section('title', 'Overview')
@section('content')
    <div class="page-heading">
        <span class="eyebrow">A SPACE THAT’S YOURS</span>
        <h1>Hello, {{ auth()->user()->name }}<span class="accent">.</span></h1>
        <p>Here’s where your Illuna experience comes together.</p>
    </div>
    <section class="welcome-panel">
        <div><span class="badge light">Your account is ready</span><h2>Let’s make it personal.</h2><p>Explore the demos and prepare your first API integration.</p><a class="button primary" href="{{ route('api-key.show') }}">Your API access <span aria-hidden="true">↗</span></a></div>
        <svg class="welcome-mark" viewBox="0 0 140 140" aria-hidden="true"><path d="M30 102V61M70 118V25M110 86V46" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round"/></svg>
    </section>
    <x-usage :user="auth()->user()" />
    <section class="card account-summary">
        <div><span class="eyebrow">ACCOUNT</span><h2>All set on your side.</h2><p>{{ auth()->user()->email }}</p></div>
        <span class="badge verified">Email verified</span>
    </section>
    <dl class="account-dates"><div><dt>Registered</dt><dd>{{ auth()->user()->created_at?->format('d M Y, H:i') }} UTC</dd></div><div><dt>Last sign-in</dt><dd>{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d M Y, H:i').' UTC' : 'Not recorded yet' }}</dd></div></dl>
@endsection
