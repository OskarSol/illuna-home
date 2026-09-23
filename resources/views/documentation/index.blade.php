@extends('layouts.documentation')
@section('content')
    <div class="docs-intro"><span class="eyebrow">THE ILLUNA KNOWLEDGE BASE</span><h1>Personal software.<br><span>Understand what’s inside.</span></h1><p>Explore the ideas behind Illuna, from understanding a request to adapting an experience within clear product boundaries.</p></div>
    @if ($query !== '')
        <div class="docs-results"><h2>Results for “{{ $query }}”</h2><p>{{ count($results) }} {{ count($results) === 1 ? 'chapter' : 'chapters' }} found. <a href="{{ route('docs.index') }}">Clear search</a></p></div>
    @else
        <div class="docs-start"><span class="badge">Start here</span><h2>New to Illuna?</h2><p>Start with the vision, then follow the adaptive loop through the core concepts. The architecture connects the pieces.</p><a href="{{ route('docs.show', 'vision') }}">Read the vision <span aria-hidden="true">→</span></a></div>
        <h2 class="docs-section-title">Explore the chapters</h2>
    @endif
    <div class="docs-cards">
        @forelse ($results as $slug => $item)
            <a class="docs-card" href="{{ route('docs.show', $slug) }}"><span class="eyebrow">{{ str_pad(array_search($slug, array_keys($chapters), true) + 1, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $item['title'] }} <span aria-hidden="true">↗</span></h2><p>{{ $item['description'] }}</p></a>
        @empty
            <div class="docs-empty"><h2>No chapters found.</h2><p>Try a broader term such as “intent”, “preferences” or “adaptation”.</p></div>
        @endforelse
    </div>
@endsection
