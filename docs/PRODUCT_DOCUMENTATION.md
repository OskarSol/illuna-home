# Product website and documentation

The public product knowledge base is available at `/docs`, with chapter pages under `/docs/{slug}`. It includes navigation, a chapter-body search, a table of contents, previous/next links, and the source illustrations. It requires neither an account nor a client-side build.

## Source snapshot

The eight Markdown chapters in `resources/product-docs` are copied verbatim from `OskarSol/illuna`, `docs/01` through `docs/08`, commit `9df9cd186b64b70bc029bf233efd8b20fbf6e78c`. Source: https://github.com/OskarSol/illuna/tree/9df9cd186b64b70bc029bf233efd8b20fbf6e78c/docs

The separate investor narrative is intentionally excluded from this product site. PNG illustrations in `public/assets/docs` are byte-identical copies of the referenced source assets. The source attribution and existing repository license apply; see `LICENSE` and `THIRD_PARTY_NOTICES.md`.

The old roadmap chapter still marks the concept phase as current. A visible note on the chapter explains that Illuna is now prototyping, while preserving the original chapter text.

## Implementation and updates

- `config/documentation.php` is the explicit chapter allowlist, title and navigation order.
- `DocumentationController` renders the local Markdown using Laravel's existing CommonMark dependency. Raw HTML and unsafe links are disabled.
- Image URLs and inline filename references are adapted to local website URLs. Heading IDs are unique and the page table of contents is generated from the rendered headings. Additional level-one headings are displayed as level two for a single page title.
- Search covers chapter titles, descriptions and full Markdown content. It performs no external requests.
- This is a pinned snapshot, not an automatic GitHub sync. To update, replace the intended source files/assets, review them, record the new source commit here and run the documentation tests.

## Deployment

Upload the updated application, including `resources/product-docs` and `public/assets/docs`. Keep the existing server `.env`. No new Composer package, Node.js build or database migration is required.

With the configured PHP 8.3 task, run `artisan` once with `optimize:clear`, then with `optimize`. Check `/`, `/docs`, one chapter and a search. This refreshes the new routes and views.
