@extends('layouts.site')
@section('title', 'Interactive demos · Illuna')
@section('description', 'Explore how Illuna adapts an app’s appearance, language and layout, then see an illustrative REST integration.')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/code-examples.css') }}">
@endpush
@section('content')
    <section class="demo-intro wrap">
        <p class="eyebrow">THE ILLUNA PLAYGROUND</p>
        <h1>One app.<br><span>Many ways to make it yours.</span></h1>
        <p class="lead">Change the feel. Rethink the layout. See how a personal experience could come together.</p>
        <nav class="demo-jumps" aria-label="Demo sections">
            <a href="#demo">01 · Make it personal</a>
            <a href="#layout-demo">02 · Change the layout</a>
            <a href="#rest-example">03 · See the API concept</a>
        </nav>
        <p class="small">Prepared, interactive examples. No live AI calls or tokens used.</p>
    </section>
    @include('partials.personalization-demo')
    @include('partials.layout-demo')
    <section class="section api-demo" id="rest-example" aria-labelledby="rest-title">
        <div class="wrap">
            <div class="section-head"><div><p class="eyebrow">03 / FROM INTENT TO INTERFACE</p><h2 id="rest-title">A request in.<br>An adaptation back.</h2></div><p>Your backend sends intent and context. Your app applies the returned changes within its own rules.</p></div>
            <x-api-example />
            <div class="actions"><a class="button primary" href="{{ route('api-key.show') }}">Get your personal REST example <svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a><a class="text-link" href="{{ route('docs.show', 'adaptive-ui-patterns') }}">Explore the UI patterns →</a></div>
        </div>
    </section>
    <noscript><p class="wrap small">Enable JavaScript to switch demo settings and layouts. The default previews and REST examples remain available.</p></noscript>
@endsection
@push('scripts')
    <script src="{{ asset('assets/demo.js') }}" defer></script>
    <script src="{{ asset('assets/layout-demo.js') }}" defer></script>
    <script src="{{ asset('assets/code-examples.js') }}" defer></script>
@endpush
