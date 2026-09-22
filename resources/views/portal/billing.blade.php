@extends('layouts.portal')
@section('title', 'Billing')
@section('content')
    <div class="page-heading"><span class="eyebrow">EVERYTHING IN ONE PLACE</span><h1>Billing<span class="accent">.</span></h1><p>Your plan, payment details and invoices.</p></div>
    <section class="card empty-state">
        <div class="empty-icon" aria-hidden="true">▤</div>
        <span class="badge">Coming soon</span>
        <h2>A home for your invoices.</h2>
        <p>Billing isn’t available in this preview. Once it’s enabled, you’ll be able to view your invoices and manage your payment details here.</p>
        <a href="{{ route('dashboard') }}" class="button">Back to overview</a>
    </section>
@endsection
