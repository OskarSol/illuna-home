@props(['usage'])
<div class="section-heading"><h2 id="activity-title">Your activity</h2><span class="muted small">{{ $usage['month'] }} · UTC</span></div>
@if ($usage['available'])
    <section class="metric-grid" aria-labelledby="activity-title">
        <article class="card metric"><span>Requests</span><strong>{{ $usage['requests'] === null ? '—' : number_format($usage['requests']) }}</strong><p>Unique logged request IDs</p></article>
        <article class="card metric"><span>Tokens used</span><strong>{{ $usage['tokens'] === null ? '—' : number_format($usage['tokens']) }}</strong><p>Total logged token consumption</p></article>
        <article class="card metric"><span>Average response time</span><strong>{{ $usage['avg_seconds'] === null ? '—' : number_format($usage['avg_seconds'], 2).' s' }}</strong><p>Based on logged request durations</p></article>
    </section>
    <p class="data-note">Updated {{ $usage['updated_at'] }} UTC. Refreshing the page fetches new data at most every five minutes; recent activity may take longer to appear. A dash means no measurement is available. These statistics do not represent your remaining plan allowance.</p>
@else
    <section class="card billing-note" aria-labelledby="activity-title"><p role="status">Usage data is currently unavailable. Please try again later.</p></section>
@endif
