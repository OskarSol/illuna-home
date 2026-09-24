@props(['account' => null])
<div class="illuna-pricing">
    <div class="pricing-grid">
        @foreach (config('illuna.plans') as $id => $plan)
            <article class="pricing-card {{ $id === 'beta' ? 'pricing-featured' : '' }}">
                <div class="pricing-top"><h3>{{ $plan['name'] }}</h3>
                    <span class="pricing-badge">{{ $account?->plan === $id ? 'Current plan' : ($id === 'free' ? 'Start here' : 'Full experience') }}</span>
                </div>
                <p class="pricing-price">€{{ number_format($plan['monthly_price_cents'] / 100, $plan['monthly_price_cents'] % 100 ? 2 : 0) }}<span>/ month</span></p>
                <p>{{ $plan['description'] }}</p>
                <ul class="pricing-features">
                    @if ($plan['full_adaptions'])
                        <li><strong>{{ number_format($plan['full_adaptions']) }} Full Adaptions / month</strong></li>
                        <li>Plus {{ number_format($plan['label_adaptions']) }} Label Adaptions / month</li>
                    @else
                        <li><strong>{{ number_format($plan['label_adaptions']) }} Label Adaptions / month</strong></li>
                    @endif
                    @foreach ($plan['features'] as $feature)<li>{{ $feature }}</li>@endforeach
                </ul>
                @if ($account)
                    <button class="button {{ $account->plan === $id ? 'primary' : '' }}" type="button" disabled>{{ $account->plan === $id ? 'Your current plan' : 'Coming soon' }}</button>
                @elseif ($id === 'free')
                    <a class="button" href="{{ auth()->check() ? route('billing') : route('register') }}">{{ auth()->check() ? 'View your plan' : 'Get started free' }}</a>
                @else
                    <button class="button primary" type="button" disabled>Paid bookings coming soon</button>
                @endif
            </article>
        @endforeach
    </div>
    @php($additional = config('illuna.additional_adaptions'))
    <div class="pricing-additional">
        <div><span class="pricing-badge">Beta add-on · Coming soon</span><h3>Need a little more?</h3><p>Additional Adaptions for your Beta plan. No separate subscription.</p></div>
        <p><strong>+{{ number_format($additional['full_adaptions']) }} Full Adaptions</strong><span>€{{ number_format($additional['price_cents'] / 100, 0) }} per bundle</span></p>
    </div>
    <p class="pricing-note">One Adaption is one request to adapt your UI, which can update multiple elements. Label Adaptions change text only; Full Adaptions can also change design and layout.</p>
    <p class="pricing-note">Closed beta: an invitation code is required to register. Paid plans and additional bundles are coming soon. No payments or automatic overage charges are collected.</p>
</div>
