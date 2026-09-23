@props(['user'])
@php
    $plan = $user->planDetails();
    $limit = $plan['token_limit'];
    $percent = $limit ? min(100, max(0, $user->tokens_used / $limit * 100)) : 0;
@endphp
<div class="section-heading"><h2>Your usage</h2><span class="muted small">Not connected yet</span></div>
<section class="metric-grid" aria-label="Usage overview">
    <article class="card metric"><span>Tokens recorded</span><strong>{{ number_format($user->tokens_used) }}</strong><p>Recorded for your current plan</p></article>
    <article class="card metric"><span>Available tokens</span><strong>{{ $user->remainingTokens() === null ? '—' : number_format($user->remainingTokens()) }}</strong><p>{{ $limit === null ? 'No fixed allowance' : 'Remaining in your total allowance' }}</p></article>
    <article class="card metric"><span>Your plan</span><strong class="metric-text">{{ $plan['name'] }}</strong><p>{{ $limit === null ? 'Billed by usage' : number_format($limit).' tokens included' }}</p></article>
</section>
@if ($limit)
    <div class="usage-progress"><div><span>{{ number_format($user->tokens_used) }} / {{ number_format($limit) }} tokens</span><strong>{{ number_format($percent, 1) }}%</strong></div><progress value="{{ min($user->tokens_used, $limit) }}" max="{{ $limit }}" aria-label="Tokens used from your plan allowance">{{ number_format($percent, 1) }}%</progress></div>
@endif
<p class="data-note">Live usage reporting is not connected yet. This shows the usage currently recorded for your account. Demo interactions use no tokens.@if ($user->plan === 'beta') Your Beta allowance is a total of 1 million tokens, with no automatic paid overage.@endif</p>
