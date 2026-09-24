@extends('layouts.portal')
@section('title', 'Plans & billing')
@section('content')
    <div class="page-heading"><span class="eyebrow">ROOM TO BUILD</span><h1>A plan for your ideas<span class="accent">.</span></h1><p>Start in Beta. Explore what comes next.</p></div>
    <section class="card billing-note" aria-labelledby="free-text-title">
        <h2 id="free-text-title">Up to 1,000 free requests per month</h2>
        <p>Translations and language or tone adjustments are free for up to 1,000 requests per month. This applies to text-label changes only.</p>
    </section>
    <div class="plan-grid">
        @foreach (config('illuna.plans') as $id => $plan)
            <section class="card plan-card {{ auth()->user()->plan === $id ? 'current-plan' : '' }}" aria-labelledby="plan-{{ $id }}">
                <div class="plan-top"><h2 id="plan-{{ $id }}">{{ $plan['name'] }}</h2><span class="badge">{{ auth()->user()->plan === $id ? 'Current plan' : ($plan['available'] ? 'Closed beta' : 'Coming soon') }}</span></div>
                <p class="plan-price">€{{ number_format($plan['price_per_million_cents'] / 100, 0) }}<span>{{ $id === 'beta' ? 'during Beta' : 'per 1 million tokens' }}</span></p>
                <p>{{ $id === 'beta' ? 'A place to try, learn and build your first integration.' : 'Usage-based billing for what your application actually uses.' }}</p>
                <ul class="plan-features">
                    @if ($id === 'beta')
                        <li>{{ number_format($plan['token_limit']) }} tokens total allowance</li><li>Your own API key</li><li>No automatic paid overage</li>
                    @else
                        <li>€{{ number_format($plan['price_per_million_cents'] / 100, 0) }} per 1,000,000 tokens</li><li>No fixed token bundle</li><li>Payment and invoices planned</li>
                    @endif
                </ul>
                <button class="button {{ auth()->user()->plan === $id ? 'primary' : '' }}" type="button" disabled>{{ auth()->user()->plan === $id ? 'Your current plan' : 'Not available yet' }}</button>
            </section>
        @endforeach
    </div>
    <x-usage :user="auth()->user()" />
    <section class="card billing-note"><h2>Payments &amp; invoices</h2><p>Paid bookings, payment details and invoices will become available when billing launches. No payments are collected in this Beta.</p></section>
@endsection
