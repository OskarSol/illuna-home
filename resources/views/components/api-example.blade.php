@props(['apiKey' => 'YOUR_API_KEY', 'idPrefix' => 'rest'])
@php
    $payload = json_encode([
        'app_id' => 'gardenmate',
        'intent' => 'Show me one garden task at a time.',
        'context' => [
            'screen' => 'garden_tasks',
            'allowed_layouts' => ['cards', 'table', 'guided'],
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = json_encode([
        'adaptation' => [
            'layout' => 'guided',
            'visible_tasks' => 1,
            'show_step_navigation' => true,
            'reason' => 'The user asked to focus on one task at a time.',
        ],
        'usage' => ['input_tokens' => 160, 'output_tokens' => 80, 'total_tokens' => 240],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $curl = 'curl --request POST '.escapeshellarg(config('illuna.api_url'))." \\\n"
        .'  --header '.escapeshellarg('Authorization: Bearer '.$apiKey)." \\\n"
        ."  --header 'Content-Type: application/json' \\\n"
        ."  --header 'Accept: application/json' \\\n"
        .'  --data '.escapeshellarg($payload);
@endphp
<div class="api-preview-note"><strong>API contract preview.</strong> This illustrates a proposed request and response, including sample token counts. The endpoint and payload still need to be connected to the Illuna backend. No request is sent from this page.</div>
<div class="code-example-grid">
    <section class="code-example" aria-labelledby="{{ $idPrefix }}-request-title">
        <div class="code-heading"><h3 id="{{ $idPrefix }}-request-title">Request <span>cURL · REST</span></h3><button type="button" class="code-copy" data-copy-target="{{ $idPrefix }}-request" data-js-control hidden>Copy request</button></div>
        <pre tabindex="0" aria-label="REST request"><code id="{{ $idPrefix }}-request">{{ $curl }}</code></pre>
    </section>
    <section class="code-example" aria-labelledby="{{ $idPrefix }}-response-title">
        <div class="code-heading"><h3 id="{{ $idPrefix }}-response-title">Response <span>Illustrative JSON</span></h3><button type="button" class="code-copy" data-copy-target="{{ $idPrefix }}-response" data-js-control hidden>Copy JSON</button></div>
        <pre tabindex="0" aria-label="Illustrative JSON response"><code id="{{ $idPrefix }}-response">{{ $result }}</code></pre>
    </section>
</div>
<p class="code-note">Call Illuna from your server. Keep your API key out of public frontend code. Your app validates the returned adaptation against its allowed layouts before applying it.</p>
<p class="code-copy-status" role="status" aria-live="polite"></p>
