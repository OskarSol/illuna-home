# Illuna website & customer portal

Laravel 13 + Blade + Laravel Fortify, designed for PHP 8.3 and MySQL 8.4 on shared hosting. No Node.js build, Redis or persistent queue worker is required.

**Deployment to `playground.illunaai.de`: [Netcup/Plesk setup guide](docs/DEPLOYMENT_PLAYGROUND.md).** The entire project goes in the private project directory; the domain serves **only `public/`**.

**Closed beta setup and 404 page: [Update instructions](docs/CLOSED_BETA.md).** Add the invitation code to the existing server configuration after uploading this update.

## Included

- Existing investor landing page and interactive demos, moved into `resources/views/landing.blade.php` and `public/assets/landing.*`.
- Registration, login/logout, signed email verification, password reset and login/account-action rate limits through Laravel Fortify.
- Closed beta registration with a server-side invitation code check; missing configuration blocks new sign-ups.
- Custom Illuna 404 page with links back to the website and dashboard.
- Dashboard protected by login and verified email.
- Profile/name/email editing, with current-password confirmation and reverification for email changes.
- Password changes, invalidation of other database sessions and remember tokens.
- Account-specific pages, escaped user content, CSRF protection and non-cacheable responses.
- Usage and billing pages with explicit empty/preview states. **No invented usage, invoices or payment processing.**

The Laravel application renders the Blade landing page. Make future landing-page changes in `resources/views/landing.blade.php`. Do not point a Laravel deployment at the repository root.

## Local development

Prerequisites: PHP 8.3+, Composer 2, the Laravel-required extensions, and PDO SQLite for local development/tests. Hosting uses PDO MySQL instead. Composer's platform is fixed to PHP 8.3.0 so dependency updates stay compatible with the hosting.

```sh
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Open `http://localhost:8000`. Local email uses the log transport: the verification/reset link appears in the **private** `storage/logs/laravel.log`. For the playground configure real SMTP instead. Verification is never bypassed.

Set `ILLUNA_BETA_INVITE_CODE` in your local `.env` before testing registration. No working invitation code is shipped with the application.

```sh
composer test
vendor/bin/pint --test
composer validate --strict
```

The test suite uses an isolated in-memory SQLite database by default. GitHub Actions also exercises the same suite against MySQL 8.4. The test-only application key in `phpunit.xml` must never be used on a server.

## Routes

| URL | Access / purpose |
| --- | --- |
| `/` | Public landing page |
| `/register` | Registration, when enabled |
| `/login` | Login |
| `/forgot-password` | Request a reset link |
| `/email/verify` | Signed-in account awaiting verification |
| `/dashboard` | Verified account; usage placeholder |
| `/settings` | Verified account; profile and password forms |
| `/billing` | Verified account; billing preview |
| `/up` | Framework health check; not a complete database/SMTP readiness check |

## Configuration

- `.env.example`: local development.
- `.env.playground.example`: playground template with database host/name and placeholders for credentials.
- `ILLUNA_REGISTRATION_ENABLED`: set to `true` only after email delivery is working. Run `php artisan optimize:clear` and `php artisan optimize` after changing this flag, because routes and configuration can be cached.
- `ILLUNA_BETA_INVITE_CODE`: a private, case-sensitive shared code (up to 128 characters, no surrounding whitespace). An empty value blocks new accounts even when registration is enabled. Use a randomly generated value of at least 20 characters; share it only with beta testers. Never commit it. Change it and rebuild the configuration cache to revoke the old code. This is a reusable group invitation, not a per-person allowlist or a one-time token; recipients can forward it. Existing accounts and email verification are unaffected. The code is not included in HTML, user records or flashed form input. Registration attempts are limited to five per minute per IP.
- `ILLUNA_NOINDEX=true`: adds a noindex response header and a disallow-all robots response. This discourages indexing; it is **not** access control. Add Plesk directory/password protection if the entire playground should be private.
- Sessions and cache use MySQL; mail is synchronous. No recurring cron task is needed at this stage.
- `APP_KEY`, database/mail credentials and future API secrets belong only in the server's `.env`. Never commit `.env`, `vendor/`, generated logs or real database files.

## Next integrations

Before connecting usage, define the backend API contract and map the signed-in portal user to an immutable backend customer ID. Enforce that mapping on the server; do not accept a browser-provided customer ID as authority. The backend remains the source of truth for limits and usage.

Select the billing provider and its customer mapping before implementing invoice/payment endpoints. Provider credentials and sensitive payment details stay server-side/with the provider. No backend or payment-provider requests are made by this scaffold.

Project license: existing [Apache 2.0](LICENSE). Laravel-derived scaffold notices: [THIRD_PARTY_NOTICES.md](THIRD_PARTY_NOTICES.md). Illuna branding remains excluded as stated on the existing landing page.
