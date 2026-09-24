@extends('layouts.documentation')
@if ($page === 'examples-and-implementation')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/code-examples.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/code-examples.js') }}" defer></script>
    @endpush
@endif
@section('content')
    <nav class="docs-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('docs.index') }}">Documentation</a><span aria-hidden="true">/</span><span aria-current="page">{{ $chapter['title'] }}</span></nav>
    @if ($page === 'roadmap')
        <div class="docs-note"><strong>Current status: prototyping.</strong><p>The source chapter below is preserved as written. Its “Concept (current)” label reflects an earlier planning stage.</p></div>
    @endif
    <details class="docs-mobile-toc"><summary>On this page</summary><nav>@foreach ($toc as $heading)<a href="#{{ $heading['id'] }}">{{ $heading['title'] }}</a>@endforeach</nav></details>
    <article class="docs-article">{!! $html !!}</article>
    @if ($page === 'examples-and-implementation')
        <x-api-example id-prefix="docs" />
    @endif
    <nav class="docs-pagination" aria-label="Previous and next chapters">
        @if ($previous)<a href="{{ route('docs.show', $previous) }}"><small>← Previous</small><strong>{{ $chapters[$previous]['title'] }}</strong></a>@else<span></span>@endif
        @if ($next)<a href="{{ route('docs.show', $next) }}"><small>Next →</small><strong>{{ $chapters[$next]['title'] }}</strong></a>@endif
    </nav>
@endsection
