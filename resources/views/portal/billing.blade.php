@extends('layouts.portal')
@section('title', 'Plans & billing')
@section('content')
    <div class="page-heading"><span class="eyebrow">ROOM TO BUILD</span><h1>A plan for your ideas<span class="accent">.</span></h1><p>Start with Free. Make it personal with Beta.</p></div>
    <x-pricing :account="auth()->user()" />
    <x-usage :user="auth()->user()" />
    <section class="card billing-note"><h2>Payments &amp; invoices</h2><p>Paid bookings, additional bundles, payment details and invoices will become available when billing launches. Existing Beta access does not become a paid subscription automatically.</p></section>
@endsection
