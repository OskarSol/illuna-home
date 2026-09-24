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
| `plan` | Internal plan ID; new Eloquent accounts start with `free`, existing assignments are preserved |
| `tokens_used` | Recorded token usage for the current plan, initially zero |

All new accounts receive a cryptographically random `illuna_` key with 256 bits of entropy. The migration backfills a distinct key for every existing account, assigns Beta and preserves the original account timestamps. `api_key` and `api_key_hash` are hidden from model JSON. Account forms cannot set keys, plans, timestamps or usage counters.

The API page requires a signed-in, email-verified account. It shows only that account's key and a matching cURL example. Rotation requires the current account password, CSRF protection and a limit of five attempts per minute. It replaces both the encrypted key and its digest; the old digest is no longer stored. The integration backend will need to use the current digest and account status when authenticating API calls. The portal does not yet serve or authenticate an adaptation API.

## Demo and API examples

The first interactive demo moved from the landing page to `/demo`. Links from the product page can open a specific editor dimension, for example `/demo?view=language#demo`. The landing page retains a static product preview.

The second demo changes the same garden tasks between cards with a sidebar, a compact full-width table and a guided single-task flow. Mode switching, previous/next, undo and reset are local to the page. No model calls are made and no tokens are counted.

Public demo, documentation and personal examples share `resources/views/components/api-example.blade.php`. Public examples always contain `https://api.example.com/v1/adapt` and `YOUR_API_KEY`, even for signed-in visitors and when a real endpoint is configured. Only the protected API access page passes the configured endpoint and the signed-in account's key to the component.

The request sends `x-api-key` and a JSON body containing `message`, `chat_history`, five `ui_elements`, minimal `system_context` and dummy identifiers. Do not send the n8n input wrapper (`headers`, `body`, `webhookUrl`, etc.). The example response preserves the supplied array / `output` / `content` / `text` structure, with a `message` and `updates` (`id`, `field: "Value"`, `new_value`). Nonessential metadata is omitted; there are no invented token counts. Visibility remains a string, matching the current prototype.

`ILLUNA_API_URL` supplies the **full HTTPS endpoint URL** shown only in the account area. Set this value in the server `.env`; the real URL is intentionally absent from source control. Until it is set, the personal request is hidden. For a `/webhook-test/` URL, n8n must be listening for a test request; the account page shows a short reminder. Use the active workflow's endpoint for a live integration. If an existing `.env` explicitly sets the old placeholder URL, replace that value. Clear and rebuild configuration caches after changing it. These pages only display examples and never send requests or change backend authentication.

## Plans and usage

Plan definitions live in `config/illuna.php` and are shared by the landing page, dashboard and billing page:

- **Free:** €0/month, 1,000 Label Adaptions/month for translations, language and tone (text labels only).
- **Beta:** €9.90/month, 500 Full Adaptions/month plus the 1,000 Label Adaptions from Free. Full Adaptions cover design, layout, accessibility, labels, themes, icons and visibility.
- **Additional Adaptions:** €10 per bundle of 1,000 Full Adaptions for Beta, not a separate subscription.

One Adaption is one UI adaptation request, potentially changing multiple elements. These are displayed prices and allowances, not an enabled billing or metering system. Paid bookings and additional bundles remain unavailable. No payments or automatic overage charges are collected. Registration still requires a closed-beta invitation.

**No new database migration is required for this pricing display.** The existing string `users.plan` supports the new IDs. New accounts created through the User model default to `free`. Existing `beta` accounts retain their assignment and are not enrolled in a paid subscription. The historical migration intentionally retains its original `beta` SQL default; direct database insertions must supply `plan` explicitly. Unknown or retired plan IDs render as Legacy plan without silently changing accounts.

`tokens_used` remains intact for later cost analysis. It is not converted to Adaptions or used as a monthly request balance. The portal displays included allowances and explicitly says live Adaption usage is not connected.

**Before enabling live allowances or payment:** the backend needs separate Label/Full usage per account and month, atomic limit checks, request-size/output limits, plan capability enforcement and explicit bundle purchase handling. No usage collector, monthly reset, automatic limit enforcement, plan switching, checkout or invoice generation is implemented in this portal. Pricing on its own does not cap model spend.

After deployment, rebuild cached config/views (`php artisan optimize:clear` then `php artisan config:cache` and `php artisan view:cache`). No additional migration is needed if the API/plan migration above is already applied.

## Verification

```sh
composer test
vendor/bin/pint --test
composer validate --strict
```

The existing GitHub workflow runs feature tests against SQLite and MySQL 8.4. Coverage includes migration of existing accounts, preserved registration dates, successful/failed login timestamps, encrypted unique keys, cross-account isolation, key rotation, CSRF, throttling, protected account fields, public demo output and allowance calculations.
