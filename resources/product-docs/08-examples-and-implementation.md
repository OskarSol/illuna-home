# 08 · Examples and Implementation Patterns

## Example Scenarios (expanded)

To make the Illuna value clearer for product teams, we treat adaptive behavior as a cross-domain pattern, not a single app feature.

Representative scenarios include:

* **Garden planning assistant** (GardenMate): adapts guidance depth for beginners vs. advanced users.
* **Learning companion**: adjusts explanation pace, visual density, and quiz difficulty based on learner signals.
* **Health routine app**: changes tone and reminder strictness depending on motivation and stress context.
* **Finance dashboard**: can switch between concise “just decisions” mode and detailed “audit trail” mode.
* **Team productivity workspace**: adapts workflow guidance, summaries, and notification intensity by role and workload.

Across all examples, the core principle stays the same: users can describe *how* the app should behave, and the app translates this into bounded, reversible product changes.

---

## Implementation Example (product-level)

A practical implementation pattern is:

1. Start with a stable base UI and explicit adaptation targets.
2. Classify user messages into intent + preference signals.
3. Resolve context from app state, workflow state, and preference memory.
4. Generate a structured adaptation plan (not free-form UI mutation).
5. Apply only allowed changes, with undo and transparency events.
6. Persist accepted preferences and learn over repeated interactions.

This keeps Illuna implementation testable for engineering teams and understandable for users.


---

## REST API example

The compact example below follows the current prototype request and response format. Send a `message`, the current `ui_elements`, and dummy app, user and session IDs. `chat_history` is empty for a first message; `system_context` provides instructions and an empty list of app actions for this UI-only example.

The five UI values cover a heading, background color, text color, font style and widget visibility. The reply contains `message` and `updates`, with each change identified by `id`, `field: "Value"` and `new_value`. The surrounding `output` / `content` structure is retained; nonessential response metadata is omitted. These are example values, not a live API response.

This public example uses a placeholder URL and API key. Your [API access page](/api-key) contains the configured endpoint and your personal key. The other architecture chapters describe broader product concepts; this example documents the current REST payload.
