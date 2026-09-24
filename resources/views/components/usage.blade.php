@props(['user'])
@php($plan = $user->planDetails())
<div class="section-heading"><h2>Your plan &amp; allowances</h2><span class="muted small">Not connected yet</span></div>
<section class="metric-grid" aria-label="Plan allowances">
    <article class="card metric"><span>Your plan</span><strong class="metric-text">{{ $plan['name'] }}</strong><p><a href="{{ route('billing') }}">Explore plans &amp; pricing</a></p></article>
    <article class="card metric"><span>Label Adaptions / month</span><strong>{{ $plan['label_adaptions'] === null ? '—' : number_format($plan['label_adaptions']) }}</strong><p>Included allowance · text changes only</p></article>
    <article class="card metric"><span>Full Adaptions / month</span><strong>{{ $plan['full_adaptions'] === null ? '—' : number_format($plan['full_adaptions']) }}</strong><p>{{ $user->plan === 'free' ? 'Available with Beta' : 'Included allowance · all UI changes' }}</p></article>
</section>
<p class="data-note">These are plan allowances, not remaining balances. Live Adaption usage is not connected yet. Demo interactions do not use your allowance.</p>
