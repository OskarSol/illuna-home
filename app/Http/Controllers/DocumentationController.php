<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = trim($validated['q'] ?? '');
        $chapters = config('documentation.chapters');
        $results = array_filter($chapters, function (array $chapter) use ($query): bool {
            return $query === '' || mb_stripos(
                $chapter['title'].' '.$chapter['description'].' '.file_get_contents(resource_path('product-docs/'.$chapter['file'])),
                $query,
            ) !== false;
        });

        return view('documentation.index', compact('chapters', 'results', 'query'));
    }

    public function show(string $page): View
    {
        $chapters = config('documentation.chapters');
        // Only published chapters may select a file; never use a URL segment as a path.
        abort_unless(array_key_exists($page, $chapters), 404);
        $chapter = $chapters[$page];
        $markdown = file_get_contents(resource_path('product-docs/'.$chapter['file']));
        $markdown = preg_replace_callback('/!\[([^\]]*)\]\(assets\/([a-zA-Z0-9_.-]+)\)/',
            fn (array $match): string => '!['.$match[1].']('.asset('assets/docs/'.$match[2]).')', $markdown);
        $rendered = Str::markdown($markdown, ['html_input' => 'strip', 'allow_unsafe_links' => false]);

        $document = new DOMDocument;
        $previousErrors = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<?xml encoding="utf-8" ?><html><body>'.$rendered.'</body></html>', LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);
        }

        $xpath = new DOMXPath($document);
        $toc = [];
        $ids = [];
        $hasTitle = false;
        foreach ($xpath->query('//h1 | //h2 | //h3') as $heading) {
            $text = trim($heading->textContent);
            $base = Str::slug($text) ?: 'section';
            $ids[$base] = ($ids[$base] ?? 0) + 1;
            $id = $base.($ids[$base] > 1 ? '-'.$ids[$base] : '');
            $heading->setAttribute('id', $id);
            if ($heading->tagName !== 'h3') {
                $toc[] = ['id' => $id, 'title' => $text];
            }
            if ($heading->tagName === 'h1') {
                if ($hasTitle) {
                    $replacement = $document->createElement('h2');
                    $replacement->setAttribute('id', $id);
                    while ($heading->firstChild) {
                        $replacement->appendChild($heading->firstChild);
                    }
                    $heading->parentNode->replaceChild($replacement, $heading);
                }
                $hasTitle = true;
            }
        }
        foreach ($xpath->query('//img') as $image) {
            $image->setAttribute('loading', 'lazy');
            $image->setAttribute('decoding', 'async');
        }
        // The source uses inline filenames for cross-references. Link these locally.
        foreach ($xpath->query('//code[not(parent::pre)]') as $code) {
            foreach ($chapters as $slug => $target) {
                if ($code->textContent === $target['file']) {
                    $link = $document->createElement('a');
                    $link->setAttribute('href', route('docs.show', $slug));
                    $code->parentNode->replaceChild($link, $code);
                    $link->appendChild($code);
                    break;
                }
            }
        }
        $html = '';
        foreach ($document->getElementsByTagName('body')->item(0)->childNodes as $node) {
            $html .= $document->saveHTML($node);
        }
        $slugs = array_keys($chapters);
        $position = array_search($page, $slugs, true);
        $previous = $slugs[$position - 1] ?? null;
        $next = $slugs[$position + 1] ?? null;

        return view('documentation.show', compact('chapters', 'chapter', 'page', 'html', 'toc', 'previous', 'next'));
    }
}
