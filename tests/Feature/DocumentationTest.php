<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_links_to_docs_without_investor_or_repository_calls_to_action(): void
    {
        $response = $this->get('/')->assertOk()->assertSee(route('docs.index'))
            ->assertDontSee('github.com')->assertDontSee('Investor')
            ->assertDontSee('Potential revenue streams')->assertDontSee('contact-dialog');
        $dom = $this->document($response->getContent());
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//a[starts-with(@href, "#")]') as $link) {
            $id = substr($link->getAttribute('href'), 1);
            $this->assertNotNull($dom->getElementById($id), 'Missing landing anchor '.$id);
        }
    }

    public function test_all_documentation_chapters_are_public_with_working_toc_and_local_images(): void
    {
        $this->get('/docs')->assertOk()->assertSee('Search documentation')->assertSee('Explore the chapters');
        foreach (config('documentation.chapters') as $slug => $chapter) {
            $response = $this->get('/docs/'.$slug)->assertOk()->assertSee($chapter['title'])
                ->assertDontSee('github.com')->assertSee('On this page');
            $dom = $this->document($response->getContent());
            $xpath = new DOMXPath($dom);
            $this->assertSame(1, $xpath->query('//h1')->length, $slug);
            $ids = [];
            foreach ($xpath->query('//*[@id]') as $node) {
                $id = $node->getAttribute('id');
                $this->assertNotContains($id, $ids, 'Duplicate ID '.$id.' in '.$slug);
                $ids[] = $id;
            }
            foreach ($xpath->query('//a[starts-with(@href, "#")]') as $link) {
                $this->assertNotNull($dom->getElementById(substr($link->getAttribute('href'), 1)));
            }
            foreach ($xpath->query('//article//img') as $image) {
                $path = parse_url($image->getAttribute('src'), PHP_URL_PATH);
                $this->assertStringStartsWith('/assets/docs/', $path);
                $this->assertFileExists(public_path(ltrim($path, '/')));
            }
        }
        $this->get('/docs/vision')->assertSee(route('docs.show', 'examples-and-implementation'));
        $this->get('/docs/roadmap')->assertSee('Current status: prototyping.');
    }

    public function test_search_matches_chapter_body_and_handles_no_results_and_escaped_input(): void
    {
        $response = $this->get('/docs?q='.urlencode('wet spaghetti'))->assertOk();
        $response->assertSee('1 chapter found.')->assertSee('Personalization engine');
        $this->get('/docs?q=nonexistent-phrase-48762')->assertOk()->assertSee('No chapters found.');
        $this->get('/docs?q='.urlencode('<script>alert(1)</script>'))->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_only_allowlisted_product_documents_can_be_requested(): void
    {
        $this->get('/docs/investor-narrativ')->assertNotFound();
        $this->get('/docs/09-investor-narrativ')->assertNotFound();
        $this->get('/docs/not-a-chapter')->assertNotFound();
        $this->get('/docs/.env')->assertNotFound();
        $this->get('/docs/01-vision.md')->assertNotFound();
    }

    private function document(string $html): DOMDocument
    {
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        return $document;
    }
}
