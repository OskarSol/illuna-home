# Demo, API access and plans

## Update an existing installation

The update adds `/demo`, `/api-key` and an account plan overview. It needs one database migration. Keep the existing server `.env`, `APP_KEY` and account data. Take the usual database backup before updating.

After deploying the code, run with the same PHP 8.3+ interpreter used by the site:

```sh
php artisan optimize:clear
php artisan migrate --force
php artisan optimize
```

In Plesk's **Run a PHP script** task, select the existing `artisan` file and enter only the arguments for each line (`optimize:clear`, `migrate --force`, `optimize`). These are one-time update steps, not recurring tasks. There are no new Composer packages or Node build steps.

Do not run `key:generate` again: the existing `APP_KEY` now also decrypts account API keys. Normal deployments must preserve it. Back up `.env` securely along with the database. Rolling back this migration deletes the new keys, plan and recorded usage; prefer rolling back application code while retaining the additive columns if a rollback is needed.

## Account fields

| Field | Purpose |
| --- | --- |
| `created_at` | Existing registration timestamp, preserved |
| `last_login_at` | Last successful sign-in, including registration auto-login and remembered sign-ins; initially null for existing accounts |
| `api_key` | Laravel-encrypted personal key, readable only with the application's `APP_KEY` |
| `api_key_hash` | Unique SHA-256 digest for future backend lookup; hidden from serialized users |
| `api_key_created_at` | Time the current key was issued |
| `plan` | Internal plan ID, initially `beta` |
| `tokens_used` | Recorded token usage for the current plan, initially zero |

All new accounts receive a cryptographically random `illuna_` key with 256 bits of entropy. The migration backfills a distinct key for every existing account, assigns Beta and preserves the original account timestamps. `api_key` and `api_key_hash` are hidden from model JSON. Account forms cannot set keys, plans, timestamps or usage counters.

The API page requires a signed-in, email-verified account. It shows only that account's key and a matching cURL example. Rotation requires the current account password, CSRF protection and a limit of five attempts per minute. It replaces both the encrypted key and its digest; the old digest is no longer stored. The integration backend will need to use the current digest and account status when authenticating API calls. The portal does not yet serve or authenticate an adaptation API.

## Demo and API examples

The first interactive demo moved from the landing page to `/demo`. Links from the product page can open a specific editor dimension, for example `/demo?view=language#demo`. The landing page retains a static product preview.

The second demo changes the same garden tasks between cards with a sidebar, a compact full-width table and a guided single-task flow. Mode switching, previous/next, undo and reset are local to the page. No model calls are made and no tokens are counted.

Public and personal examples share `resources/views/components/api-example.blade.php`. The public example always contains `YOUR_API_KEY`; the private example uses the signed-in account's current key. Both explicitly label the endpoint, request, response and token counts as illustrative. The proposed `/v1/adapt` contract is not an existing backend endpoint.

`ILLUNA_API_URL` optionally supplies the **full HTTPS endpoint URL** shown in examples. Until the actual integration contract is agreed, the example defaults to the reserved placeholder `https://api.example.com/v1/adapt`. Setting this variable only changes the displayed endpoint. Align the request/response example with the real API when it is connected, then clear and rebuild configuration caches. Never send real keys to the placeholder endpoint.

## Plans and usage

Plan definitions live in `config/illuna.php`:

- **Beta:** free during Beta, 1,000,000 tokens total allowance. No monthly reset and no automatic paid overage are implemented.
- **Usage-based:** €10 per 1,000,000 tokens, displayed as **Coming soon**. It cannot be booked and does not trigger a payment.

Dashboard and billing share the same usage component and account counter. Remaining allowance is floored at zero; the progress bar stops at 100% while the actual recorded count stays visible. There is no usage collector, automatic limit enforcement, plan switching, checkout, payment collection or invoice generation yet. These stay with the future backend/billing integration. The UI explicitly says live reporting is not connected.

## Verification

```sh
composer test
vendor/bin/pint --test
composer validate --strict
```

The existing GitHub workflow runs feature tests against SQLite and MySQL 8.4. Coverage includes migration of existing accounts, preserved registration dates, successful/failed login timestamps, encrypted unique keys, cross-account isolation, key rotation, CSRF, throttling, protected account fields, public demo output and allowance calculations.
