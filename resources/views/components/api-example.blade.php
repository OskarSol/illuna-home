@props(['apiKey' => 'YOUR_API_KEY', 'endpoint' => 'https://api.example.com/v1/adapt', 'idPrefix' => 'rest'])
@php
    $payload = json_encode([
        'message' => 'Rename the title to My garden, use dark cards with light text, make the font italic and hide the weather widget.',
        'chat_history' => [],
        'ui_elements' => [
            'text.header.title' => 'Demo app',
            'color.card.bg' => '#ffffff',
            'color.text.base' => '#14532d',
            'font.style.base' => 'normal',
            'visibility.widget.weather' => 'true',
        ],
        'system_context' => [
            'instructions' => 'Adapt only the supplied UI elements to the user request.',
            'available_actions' => [],
        ],
        'user_id' => 'demo-user',
        'app_id' => 'demo-app',
        'session_id' => 'demo-session',
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = json_encode([[
        'output' => [[
            'type' => 'message',
            'role' => 'assistant',
            'content' => [[
                'type' => 'output_text',
                'text' => [
                    'message' => 'Updated the title, colors and font style, and hidden the weather widget.',
                    'updates' => [
                        ['id' => 'text.header.title', 'field' => 'Value', 'new_value' => 'My garden'],
                        ['id' => 'color.card.bg', 'field' => 'Value', 'new_value' => '#0f172a'],
                        ['id' => 'color.text.base', 'field' => 'Value', 'new_value' => '#f8fafc'],
                        ['id' => 'font.style.base', 'field' => 'Value', 'new_value' => 'italic'],
                        ['id' => 'visibility.widget.weather', 'field' => 'Value', 'new_value' => 'false'],
                    ],
                ],
            ]],
        ]],
    ]], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $curl = 'curl --request POST '.escapeshellarg($endpoint)." \\\n"
        .'  --header '.escapeshellarg('x-api-key: '.$apiKey)." \\\n"
        ."  --header 'Content-Type: application/json' \\\n"
        ."  --header 'Accept: application/json' \\\n"
        .'  --data '.escapeshellarg($payload);
@endphp
<div class="api-preview-note"><strong>A small REST example.</strong> Five UI values show text, colors, font style and visibility. App, user and session IDs are dummy values. No request is sent from this page.</div>
<p class="code-note">Send the JSON body directly. The webhook's headers, body wrapper and execution metadata are not part of the request payload.</p>
<div class="code-example-grid">
    <section class="code-example" aria-labelledby="{{ $idPrefix }}-request-title">
        <div class="code-heading"><h3 id="{{ $idPrefix }}-request-title">Request <span>cURL · REST</span></h3><button type="button" class="code-copy" data-copy-target="{{ $idPrefix }}-request" data-js-control hidden>Copy request</button></div>
        <pre tabindex="0" aria-label="REST request"><code id="{{ $idPrefix }}-request">{{ $curl }}</code></pre>
    </section>
    <section class="code-example" aria-labelledby="{{ $idPrefix }}-response-title">
        <div class="code-heading"><h3 id="{{ $idPrefix }}-response-title">Response <span>Sample JSON · metadata omitted</span></h3><button type="button" class="code-copy" data-copy-target="{{ $idPrefix }}-response" data-js-control hidden>Copy JSON</button></div>
        <pre tabindex="0" aria-label="Sample JSON response"><code id="{{ $idPrefix }}-response">{{ $result }}</code></pre>
    </section>
</div>
<p class="code-note">Read the result at <code>response[0].output[0].content[0].text</code>: <code>message</code> is the reply; <code>updates</code> contains each UI <code>id</code>, <code>field: "Value"</code> and <code>new_value</code>. The sample omits message IDs, status and other metadata. Visibility values are strings (<code>"true"</code> / <code>"false"</code>), matching the current format.</p>
<p class="code-note">Call Illuna from your server and keep your API key private. Your app validates the returned IDs and values against its allowed UI settings before applying them.</p>
<p class="code-copy-status" role="status" aria-live="polite"></p>
