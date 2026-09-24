@extends('layouts.portal')
@section('title', 'API access')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/code-examples.css') }}">
@endpush
@section('content')
    <div class="page-heading"><span class="eyebrow">CONNECT YOUR IDEAS</span><h1>Your API access<span class="accent">.</span></h1><p>One personal key. A starting point for your integration.</p></div>
    <section class="card api-key-card" aria-labelledby="key-title">
        <div class="section-heading"><h2 id="key-title">Your secret API key</h2><span class="badge">{{ $user->planDetails()['name'] }}</span></div>
        <p>Created for your account. Keep it private and use it only from your server.</p>
        <div class="field key-field"><label for="personal-api-key">API key</label><input id="personal-api-key" type="password" value="{{ $user->api_key }}" readonly autocomplete="off" spellcheck="false"><div class="key-actions"><button type="button" class="button" data-toggle-key="personal-api-key" aria-pressed="false" data-js-control hidden>Show key</button><button type="button" class="button" data-copy-target="personal-api-key" data-js-control hidden>Copy key</button></div></div>
        <p class="small">Issued {{ $user->api_key_created_at?->format('d M Y, H:i') }} UTC. Only the most recently issued key is stored for your account.</p>
        <p class="code-copy-status" role="status" aria-live="polite"></p>
    </section>
    <section class="card api-key-card" aria-labelledby="personal-example-title">
        <h2 id="personal-example-title">Your REST example</h2>
        @if (config('illuna.api_url'))
            <p>The request includes your current key and the configured API URL. The payload uses dummy values; replace the app, user and session IDs for your integration. After renewing your key, copy the updated example here.</p>
            @if (str_contains(config('illuna.api_url'), '/webhook-test/'))
                <p class="small">This is a test webhook. Start the test listener in n8n before sending a request.</p>
            @endif
            <details class="personal-example"><summary>Show request with my API key and example response</summary><x-api-example :api-key="$user->api_key" :endpoint="config('illuna.api_url')" id-prefix="personal" /></details>
        @else
            <p>Your API endpoint is being prepared. Your personal REST example will appear here once it is available.</p>
        @endif
    </section>
    <section class="card settings-card" aria-labelledby="rotate-title">
        <div class="settings-description"><h2 id="rotate-title">Renew API key</h2><p>This replaces your current key immediately. Update your integrations with the new key. Confirm with your account password.</p></div>
        <form method="POST" action="{{ route('api-key.rotate') }}" class="form-stack">
            @csrf
            <x-input name="current_password" label="Current password" type="password" autocomplete="current-password" required />
            <button type="submit" class="button primary">Renew API key</button>
        </form>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/code-examples.js') }}" defer></script>
@endpush
