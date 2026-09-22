@extends('layouts.portal')
@section('title', 'Overview')
@section('content')
    <div class="page-heading">
        <span class="eyebrow">A SPACE THAT’S YOURS</span>
        <h1>Hello, {{ auth()->user()->name }}<span class="accent">.</span></h1>
        <p>Here’s where your Illuna experience comes together.</p>
    </div>
    <section class="welcome-panel">
        <div><span class="badge light">Your account is ready</span><h2>Let’s make it personal.</h2><p>Keep your details up to date and make yourself at home.</p><a class="button primary" href="{{ route('settings') }}">Account settings <span aria-hidden="true">↗</span></a></div>
        <svg class="welcome-mark" viewBox="0 0 140 140" aria-hidden="true"><path d="M30 102V61M70 118V25M110 86V46" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round"/></svg>
    </section>
    <div class="section-heading"><h2>Your usage</h2><span class="muted small">Not connected yet</span></div>
    <section class="metric-grid" aria-label="Usage overview">
        <article class="card metric"><span>Tokens used</span><strong aria-label="Not available">—</strong><p>Current billing period</p></article>
        <article class="card metric"><span>Available tokens</span><strong aria-label="Not available">—</strong><p>Your remaining allowance</p></article>
        <article class="card metric"><span>Your plan</span><strong class="metric-text">Not assigned</strong><p>Plan details will appear here</p></article>
    </section>
    <p class="data-note">Usage and allowance will appear once your account is connected. No usage data is available yet.</p>
    <section class="card account-summary">
        <div><span class="eyebrow">ACCOUNT</span><h2>All set on your side.</h2><p>{{ auth()->user()->email }}</p></div>
        <span class="badge verified">Email verified</span>
    </section>
@endsection
