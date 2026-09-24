<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class AccountUsage
{
    public function forUser(User $user): array
    {
        $month = now('UTC')->startOfMonth();
        $unavailable = ['available' => false, 'month' => $month->format('F Y')];
        $settings = config('analytics');

        foreach (['app_id', 'webhook_url', 'tenant_id', 'client_id', 'client_secret'] as $field) {
            if (! is_string($settings[$field] ?? null) || trim($settings[$field]) === '') {
                return $unavailable;
            }
        }

        if (trim($user->email) === '') {
            return $unavailable;
        }

        // Include the account, email, month and connection; never share a customer's result.
        $key = 'account-usage:v1:'.hash('sha256', json_encode([
            $user->getKey(), $user->email, $month->format('Y-m'), $settings,
        ], JSON_THROW_ON_ERROR));

        try {
            return Cache::remember($key, 300, function () use ($user, $month, $settings, $unavailable): array {
                try {
                    $token = Http::asForm()->acceptJson()->connectTimeout(3)->timeout(8)
                        ->withoutRedirecting()
                        ->post('https://login.microsoftonline.com/'.rawurlencode($settings['tenant_id']).'/oauth2/token', [
                            'grant_type' => 'client_credentials',
                            'client_id' => $settings['client_id'],
                            'client_secret' => $settings['client_secret'],
                            'resource' => 'https://api.applicationinsights.io',
                        ])->throw()->json('access_token');

                    if (! is_string($token) || $token === '') {
                        throw new RuntimeException('Missing analytics access token.');
                    }

                    $response = Http::withToken($token)->acceptJson()->connectTimeout(3)->timeout(8)
                        ->withoutRedirecting()
                        ->post('https://api.applicationinsights.io/v1/apps/'.rawurlencode($settings['app_id']).'/query', [
                            'query' => $this->query($user->email, $settings['webhook_url'], $month->toIso8601String()),
                        ])->throw()->json();

                    return [
                        'available' => true,
                        'month' => $month->format('F Y'),
                        'updated_at' => now('UTC')->format('d M Y, H:i'),
                        ...$this->metrics($response),
                    ];
                } catch (Throwable $exception) {
                    // Do not log Azure response bodies, queries, emails or credentials.
                    Log::warning('Account analytics unavailable.', ['exception_type' => $exception::class]);

                    return $unavailable;
                }
            });
        } catch (Throwable $exception) {
            Log::warning('Account analytics cache unavailable.', ['exception_type' => $exception::class]);

            return $unavailable;
        }
    }

    private function query(string $email, string $webhook, string $month): string
    {
        // JSON double-quoted strings are escaped KQL string literals, never query fragments.
        $email = json_encode($email, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $webhook = json_encode($webhook, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        return <<<KQL
            let scoped = materialize(traces
            | where timestamp >= datetime({$month}) and timestamp <= now()
            | where tostring(customDimensions["webhookUrl"]) == {$webhook}
            | where tostring(customDimensions["userId"]) == {$email});
            let request_count = toscalar(scoped
                | extend request_id = tostring(customDimensions["request-id"])
                | where isnotempty(request_id)
                | summarize by request_id
                | count);
            scoped
            | extend request_id = tostring(customDimensions["request-id"]),
                tokens = tolong(extract(@"^Tokensused:\s*([0-9]+)\s*$", 1, message)),
                duration_s = todouble(extract(@"^Duration:\s*([0-9]+(?:\.[0-9]+)?)\s*$", 1, message))
            | summarize trace_events = count(),
                request_events = countif(isnotempty(request_id)),
                total_tokens = sum(tokens), token_events = countif(isnotnull(tokens)),
                avg_seconds = avg(duration_s), duration_samples = countif(isnotnull(duration_s))
            | extend requests = request_count
            KQL;
    }

    private function metrics(mixed $response): array
    {
        if (! is_array($response) || isset($response['error'])) {
            throw new RuntimeException('Invalid or partial analytics response.');
        }

        $table = collect($response['tables'] ?? [])->firstWhere('name', 'PrimaryResult');
        $columns = array_column($table['columns'] ?? [], 'name');
        $rows = $table['rows'] ?? [];
        if (count($rows) !== 1 || count($columns) !== count($rows[0])) {
            throw new RuntimeException('Invalid analytics table.');
        }

        $values = array_combine($columns, $rows[0]);
        foreach (['trace_events', 'requests', 'request_events', 'total_tokens', 'token_events', 'duration_samples'] as $field) {
            if (! isset($values[$field]) || ! is_numeric($values[$field]) || ! is_finite((float) $values[$field]) || $values[$field] < 0) {
                throw new RuntimeException('Invalid analytics metric.');
            }
        }

        if (! array_key_exists('avg_seconds', $values) || ($values['duration_samples'] > 0
            && (! is_numeric($values['avg_seconds']) || ! is_finite((float) $values['avg_seconds']) || $values['avg_seconds'] < 0))) {
            throw new RuntimeException('Invalid analytics duration.');
        }

        // No matching traces is a valid zero. Missing fields in existing traces are unknown.
        return [
            'requests' => $values['trace_events'] > 0 && $values['request_events'] == 0 ? null : (int) $values['requests'],
            'tokens' => $values['trace_events'] > 0 && $values['token_events'] == 0 ? null : (int) $values['total_tokens'],
            'avg_seconds' => $values['duration_samples'] > 0 ? (float) $values['avg_seconds'] : null,
        ];
    }
}
