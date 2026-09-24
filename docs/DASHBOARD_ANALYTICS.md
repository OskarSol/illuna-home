# Dashboard analytics

The dashboard reads Application Insights `traces` through Laravel. This endpoint
also works for workspace-backed Application Insights; no second integration with
the underlying Log Analytics workspace is needed. The browser receives only the
account's aggregate statistics, never Azure credentials or raw logs.

## Server configuration

Set these values in the hosting `.env` (never commit credentials):

```dotenv
ILLUNA_ANALYTICS_APP_ID=your-application-insights-application-id
ILLUNA_ANALYTICS_WEBHOOK_URL=https://your-workflow-host/webhook/your-workflow
ILLUNA_ANALYTICS_TENANT_ID=your-entra-tenant-id
ILLUNA_ANALYTICS_CLIENT_ID=your-entra-app-client-id
ILLUNA_ANALYTICS_CLIENT_SECRET=your-entra-app-client-secret
```

Use the **Application Insights Application ID**, not the workspace ID,
instrumentation key, or Entra app ID. The webhook value must exactly match the
logged `webhookUrl`; it is only a query filter and is never called by this service.

Register an Entra application and grant it read access to the Application Insights
resource following [Microsoft's query authentication instructions](https://learn.microsoft.com/en-us/azure/azure-monitor/app/azure-ad-authentication#query-application-insights-by-using-microsoft-entra-authentication).
The service uses the documented client credentials flow and the resource
`https://api.applicationinsights.io`. There is no anonymous fallback. Both Entra
and the Application Insights API must be reachable from the hosting server.

After changing the server configuration, run with the hosting's PHP 8.3+ binary:

```sh
php artisan config:cache
```

No migration or scheduled job is needed beyond the existing Laravel cache table.
The existing `CACHE_STORE=database` works on shared hosting.

## Log contract

Every relevant trace must include these `customDimensions`:

```json
{
  "webhookUrl": "https://your-workflow-host/webhook/your-workflow",
  "userId": "portal-account@example.com",
  "request-id": "a-unique-id-for-this-request"
}
```

`userId` is the portal account's email, compared exactly (including case), not
an application's end-user identifier. The trusted backend must derive/validate
the account from its authentication, rather than trusting a caller-supplied email.
The dashboard always uses the authenticated, verified portal user's email;
URL parameters cannot change the scope. Traces missing that email are excluded.

The existing message formats are supported:

```text
Tokensused: 1234
Duration: 1.25
```

Duration is measured in seconds. Emit one token total and one duration per request;
duplicate token/duration traces inflate those metrics. Request count deduplicates
nonempty `request-id` values exactly. Logging more than one trace per request does
not increase the request count. Logging must include the dimensions on each trace.

## Display and limits

- Calendar month from 00:00 UTC on the first day through now, for all three metrics.
- Requests, total tokens and average response time; no user count because the
  account filter would make it 0 or 1.
- Results and failures are cached for five minutes per account, email, month and
  connection. Page reloads reuse the cache; there is no automatic browser polling.
- Missing configuration, timeouts, HTTP errors, partial results or malformed
  responses show “Usage data is currently unavailable”, never fabricated zeros.
- A valid empty result shows zero requests/tokens and no average duration.
  Missing measurements in existing traces display a dash.
- Azure ingestion delay, telemetry sampling and retention can affect completeness.
  These are informational statistics, not a billing ledger or remaining allowance.
- Label/Full Adaptions are not separated; plan limits remain enforced by the
  backend. Existing plan allowances and the legacy `tokens_used` field are unchanged.
- Changing a portal email also changes the log filter: activity under the old
  email is no longer included. Before paid billing, use a stable account ID.

## Verification

`tests/Feature/AccountUsageTest.php` covers authenticated scoping, KQL escaping,
credential isolation, cache separation/expiry/month rollover, valid empty results,
missing measurements and unavailable/partial/malformed Azure responses using HTTP
fakes. A real end-to-end check still requires the server credentials and matching
telemetry. Compare one test account's UTC month figures with Application Insights
after setup, then check a second account for isolation.
