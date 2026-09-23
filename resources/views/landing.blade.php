<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#ffffff">
  <title>Illuna — Every App Should Feel Like It Was Made for You</title>
  <meta name="description" content="Every app should feel like it was made for you. Meet Illuna, an adaptive application framework for more personal software experiences.">
  <link rel="icon" href="/favicon.svg" type="image/svg+xml">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Illuna">
  <meta property="og:title" content="Every App Should Feel Like It Was Made for You">
  <meta property="og:description" content="Software, made personal. Discover Illuna’s vision for applications that understand your needs and adapt with care.">
  <!-- Before publishing, set verified canonical and social preview URLs:
  <link rel="canonical" href="https://YOUR_VERIFIED_DOMAIN/">
  <meta property="og:url" content="https://YOUR_VERIFIED_DOMAIN/">
  <meta property="og:image" content="https://YOUR_VERIFIED_DOMAIN/illuna-social.png">
  -->
  <link rel="stylesheet" href="{{ asset('assets/landing.css') }}">
</head>
<body>
  <!-- Source: OskarSol/illuna, inspected at 9df9cd186b64b70bc029bf233efd8b20fbf6e78c.
       Content follows the product concepts and documentation.
       Demo fixtures illustrate the documented model; they do not call an Illuna service. -->
  <svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4 12h15m-6-6 6 6-6 6"/></symbol>
    <symbol id="i-up" viewBox="0 0 24 24"><path d="M6 18 18 6M6 6h12v12"/></symbol>
    <symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V6a4 4 0 0 1 8 0v4m-4 5v2"/></symbol>
    <symbol id="i-leaf" viewBox="0 0 24 24"><path d="M19 4c-8-2-15 2-14 9 1 5 7 7 11 3 3-3 3-8 3-12ZM4 21l10-11"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="m3 7 9-4 9 4-9 4-9-4Zm0 5 9 4 9-4M3 17l9 4 9-4"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></symbol>
    <symbol id="i-mark" viewBox="0 0 30 34"><path d="M5 25V14M15 29V5M25 21V10" stroke="currentColor" stroke-width="5" stroke-linecap="round"/></symbol>

    <symbol id="i-sprout" viewBox="0 0 24 24"><path d="M12 21v-9M12 15C6 15 3 11 3 6c6 0 9 3 9 9Zm0-3c0-5 3-8 9-8 0 5-3 8-9 8Z"/></symbol>
    <symbol id="i-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></symbol>
    <symbol id="i-pumpkin" viewBox="0 0 24 24"><path d="M12 6V4c0-1.5 1-2 3-2M12 7C7 3 2 7 2 13c0 5 4 9 10 7 6 2 10-2 10-7 0-6-5-10-10-6Z"/><path d="M10 7c-3 4-3 9 0 13m4-13c3 4 3 9 0 13"/></symbol>
    <symbol id="i-moon" viewBox="0 0 24 24"><path d="M20.9 13.2A9 9 0 0 1 10.8 3.1 9 9 0 1 0 20.9 13.2Z"/></symbol>
    <symbol id="i-tree" viewBox="0 0 24 24"><path d="m12 2-5 6h3l-5 6h4l-5 5h16l-5-5h4l-5-6h3L12 2Zm0 17v3"/></symbol>
    <symbol id="i-snowflake" viewBox="0 0 24 24"><path d="M12 2v20M3.34 7l17.32 10M3.34 17 20.66 7M9 4l3 3 3-3M9 20l3-3 3 3M3.6 10.6l4.1-1.1-1.1-4.1m10.8 13.2-1.1-4.1 4.1-1.1M6.6 18.6l1.1-4.1-4.1-1.1M20.4 10.6l-4.1-1.1 1.1-4.1"/></symbol>
  </defs></svg>
  <a class="skip" href="#main">Skip to content</a>
  <header class="site-header" id="site-header">
    <nav class="wrap nav-row" aria-label="Main navigation">
      <a class="brand" href="#top" aria-label="Illuna home"><svg class="brand-mark" aria-hidden="true"><use href="#i-mark"/></svg>illuna</a>
      <button class="menu-toggle" id="menu-toggle" type="button" aria-expanded="false" aria-controls="nav-links">Menu<svg class="icon" aria-hidden="true"><use href="#i-menu"/></svg></button>
      <div class="nav-links" id="nav-links">
        <a href="#vision">Vision</a><a href="#how-it-works">How it works</a><a href="#platform">Platform</a><a href="{{ route('docs.index') }}">Documentation</a>
        <a href="#demo">Try the demo</a>
        @auth
          <a class="nav-cta" href="{{ route('dashboard') }}">My account</a>
        @else
          <a class="nav-cta" href="{{ route('login') }}">Sign in</a>
        @endauth
      </div>
    </nav>
  </header>
  <main id="main">
    <section class="hero" id="top" aria-labelledby="hero-title">
      <div class="wrap">
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="eyebrow">Software, made personal.</p>
            <h1 id="hero-title">Every App Should Feel<br>Like It Was <span>Made for You</span></h1>
            <p class="lead">Your style. Your language. Your way of moving through the world. Illuna imagines software that adapts to all of it.</p>
            <div class="actions"><a class="button primary" href="#demo">Explore Illuna<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a><a class="button" href="{{ route('docs.index') }}">Read the documentation<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a></div>
            <p class="stage-note">Now prototyping. Turning the vision into working experiences.</p>
          </div>
          <figure class="hero-visual" id="hero-visual">
            <div class="visual-label"><span>One app. So many ways to be you.</span><span class="index">Explore the possibilities</span></div>
            <div class="facet-switcher js-only" role="group" aria-label="Explore ways an app can adapt">
              <button type="button" data-hero-scene="look" aria-pressed="true" aria-controls="hero-shell">Your look</button>
              <button type="button" data-hero-scene="voice" aria-pressed="false" aria-controls="hero-shell">Your voice</button>
              <button type="button" data-hero-scene="language" aria-pressed="false" aria-controls="hero-shell">Your language</button>
              <button type="button" data-hero-scene="comfort" aria-pressed="false" aria-controls="hero-shell">Your comfort</button>
              <button type="button" data-hero-scene="personality" aria-pressed="false" aria-controls="hero-shell">Your personality</button>
              <button type="button" data-hero-scene="moment" aria-pressed="false" aria-controls="hero-shell">Your moment</button>
            </div>
            <div class="showcase-grid">
              <div class="app-shell adaptive-app" id="hero-shell" data-theme="spring" data-personality="minimal">
                <div class="app-topbar"><span class="app-name"><svg class="icon" aria-hidden="true"><use href="#i-leaf"/></svg>GardenMate</span><span class="pill accent"><svg class="icon theme-icon" aria-hidden="true"><use href="#i-sprout"/></svg>Spring</span></div>
                <div class="app-tabs"><span class="selected">Overview</span><span>My garden</span><span>Care history</span></div>
                <div class="app-canvas"><div class="app-kicker"><svg class="icon theme-icon" aria-hidden="true"><use href="#i-sun"/></svg><span>Hello, spring.</span></div><h3>A fresh start for your garden.</h3><p>A little spring energy for your day. Three familiar tasks, ready when you are.</p><div class="app-metrics"><div><strong>3</strong><span>Care tasks</span></div><div><strong>2</strong><span>To review</span></div><div><strong>1</strong><span>Weather check</span></div></div><div class="task-row"><span>Hydrangea</span><span>Watering review</span></div><div class="task-row"><span>Lawn</span><span>Seasonal care</span></div><div class="task-row"><span>Oleander</span><span>Weather check</span></div></div>
                <div class="app-footer">Check local conditions before taking action.</div>
              </div>
              <aside class="experience-story" aria-label="About this example">
                <p class="experience-request" id="hero-request">“Give it a fresh spring feel.”</p>
                <h3 id="hero-story-title">A fresh look.<br>A familiar place.</h3>
                <p id="hero-story-copy">A fresh palette, a seasonal greeting and a few thoughtful details. The same app can feel a little more like your world.</p>
                <dl class="experience-facts" id="hero-facts"><div><dt>Look</dt><dd>Spring</dd></div><div><dt>Voice</dt><dd>Natural</dd></div><div><dt>Language</dt><dd>English</dd></div></dl>
                <a class="text-link" href="#demo">Make it yours <span aria-hidden="true">↗</span></a>
              </aside>
            </div>
            <figcaption class="demo-caption">Interactive prototype · Illustrative content · Select an example to see it change.</figcaption>
            <p class="sr-only" id="hero-status" role="status" aria-live="polite"></p>
          </figure>
        </div>
        <div class="hero-foot"><p><strong>Understands what you need.</strong>Start with your own words.</p><p><strong>Adapts with care.</strong>Changes that fit the product.</p><p><strong>Keeps you in control.</strong>An experience you can shape.</p></div>
      </div>
    </section>

    <section class="section wrap" id="vision" aria-labelledby="possibilities-title">
      <div class="section-head reveal"><div><p class="eyebrow">What this looks like</p><h2 id="possibilities-title">As individual<br>as you are.</h2></div><p>Personalization is more than a level of detail. It is how software looks, speaks, feels—and fits into your life.</p></div>
      <div class="possibility-grid">
        <article class="possibility reveal"><div class="possibility-visual palette-sample" aria-hidden="true"><span style="background:#38794d"></span><span style="background:#c66a20"></span><span style="background:#a63042"></span><span style="background:#783ce0"></span></div><h3>Switch Effortlessly</h3><p>Christmas warmth. Halloween spirit. A fresh spring palette. Or a look made from your own favorite colors.</p><a class="text-link" href="#demo" data-open-editor="appearance">Find your look <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual voice-sample" aria-hidden="true"><span>Hey, plant parent.</span><span>Your garden briefing.</span></div><h3>Speak Naturally</h3><p>From a social feed to the boardroom—or the elegant turn of phrase of another era. A voice that meets people where they are.</p><a class="text-link" href="#demo" data-open-editor="voice">Hear the difference <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual language-sample" aria-hidden="true"><span>Hello.</span><span>Hallo.</span><span>Vela.</span></div><h3>Translate Instantly</h3><p>Feel at home in a familiar language. Or imagine a new one, with a vocabulary born from creativity rather than geography.</p><a class="text-link" href="#demo" data-open-editor="language">Explore a language <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual comfort-sample" aria-hidden="true"><span>Aa</span><span>Aa</span><span>Aa</span></div><h3>Adapt to Every Ability</h3><p>Larger text. Clearer contrast. Simpler layouts. Preferences that make an experience easier to use, supported by thoughtful design and accessibility testing.</p><a class="text-link" href="#demo" data-open-editor="comfort">Find your comfort <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual personality-sample" aria-hidden="true"><span>Quiet.</span><span>Bold.</span></div><h3>Reflect Your Personality</h3><p>Playful, minimalist, formal or bold. Let the visual rhythm and character of an app feel closer to your own.</p><a class="text-link" href="#demo" data-open-editor="personality">Set the mood <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual moment-sample" aria-hidden="true"><span>MAR</span><span>OCT</span><span>DEC</span></div><h3>Evolve with Time</h3><p>Let a chosen look follow the seasons, celebrations and cultural moments that matter to you. An experience that can change as life does.</p><a class="text-link" href="#demo" data-open-editor="moment">Move through the year <span aria-hidden="true">↗</span></a></article>
      </div>
      <p class="statement reveal">Not one fixed version of you.<br><strong>Room for every side of you.</strong></p>
    </section>

    <section class="section shift" aria-labelledby="shift-title">
      <div class="wrap"><div class="section-head reveal"><div><p class="eyebrow">A shift in software</p><h2 id="shift-title">A more personal<br>kind of software.</h2></div><p>The next step could take personalization beyond a chat window and into the application itself.</p></div>
        <ol class="evolution reveal"><li class="era"><span class="meta">Static apps</span><h3>One experience.</h3><p>The same screens and workflows for everyone.</p></li><li class="era"><span class="meta">Personalized apps</span><h3>You configure it.</h3><p>Settings, saved views and recommendations.</p></li><li class="era"><span class="meta">AI assistants</span><h3>It responds to you.</h3><p>A conversational layer that understands requests.</p></li><li class="era future"><span class="meta">Adaptive apps</span><h3>The product adapts.</h3><p>An experience shaped around your needs, within clear boundaries.</p></li></ol>
      </div>
    </section>

    <section class="section wrap" id="how-it-works" aria-labelledby="how-title">
      <div class="architecture-grid">
        <div class="architecture-copy reveal"><p class="eyebrow">How Illuna works</p><h2 id="how-title">You say it.<br>The experience responds.</h2><p class="lead">Illuna connects what a person asks for with the experience a product can offer. Changes follow rules set by the team behind the product.</p><p class="principle">The AI proposes.<br>Product rules decide.<span>The application executes.</span></p><p class="small" style="margin-top:24px">It can ask when something is unclear. And it keeps the product’s essential rules in place.</p></div>
        <div class="reveal"><div class="flow-layout">
          <ol class="flow" id="architecture-flow" aria-label="Reference adaptation flow">
            <li class="flow-step" style="--step:0"><div class="flow-box"><b>User intent</b><small>“Keep it simple.”</small></div></li>
            <li class="flow-step" style="--step:1"><div class="flow-box"><b>Intent understanding</b><small>Understand what you mean.</small></div></li>
            <li class="flow-step" style="--step:2"><div class="flow-box"><b>Context</b><small>Consider what matters right now.</small></div></li>
            <li class="flow-step" style="--step:3"><div class="flow-box"><b>Personalization decision</b><small>Find a change that fits.</small></div></li>
            <li class="flow-step guard" style="--step:4"><div class="flow-box"><b>Product rules &amp; guardrails</b><small>Keep the product in control.</small></div></li>
            <li class="flow-step" style="--step:5"><div class="flow-box"><b>Adaptation plan</b><small>Prepare only approved changes.</small></div></li>
            <li class="flow-step output" style="--step:6"><div class="flow-box"><b>Application experience</b><small>Make the change. Let you undo it.</small></div></li>
          </ol>
          <aside><div class="memory"><svg class="icon" aria-hidden="true"><use href="#i-layers"/></svg><b>Preference memory</b><p>What matters to you, when it matters.</p><p>Yours to inspect. Yours to reset.</p></div><p class="memory-note">Preferences are remembered only where the product’s rules and your consent allow.</p></aside>
        </div></div>
      </div>
      <details class="under-hood reveal"><summary>A closer look <span>The architecture behind the experience</span></summary>
        <div class="components"><div><b>Interaction Gateway</b><p>Normalizes input and app state.</p></div><div><b>Intent Classifier</b><p>Turns language into structured intent.</p></div><div><b>Context Engine</b><p>Resolves the relevant product context.</p></div><div><b>Personalization Engine</b><p>Evaluates signals, rules and consent.</p></div><div><b>Preference Memory</b><p>Stores meaningful, scoped preferences.</p></div><div><b>Adaptation Engine</b><p>Translates decisions into allowed changes.</p></div><div><b>Application Runtime</b><p>Renders approved states and runs workflows.</p></div><div><b>Domain Services</b><p>Own trusted data and business operations.</p></div></div>
        <p class="small">A chat or standard app interface sits above these layers. Product rules inform decisions and remain enforced at execution. <a class="text-link" href="{{ route('docs.show', 'reference-architecture') }}">Read the architecture <span aria-hidden="true">→</span></a></p>
      </details>
    </section>

    <section class="section demo-section" id="demo" aria-labelledby="demo-title">
      <div class="wrap">
        <div class="section-head reveal"><div><p class="eyebrow">Make it yours</p><h2 id="demo-title">Same app.<br>More you.</h2></div><p>A festive look. A professional voice. Larger text. Mix what matters to you and watch one familiar app adapt.</p></div>
        <div class="editor-nav js-only" role="group" aria-label="Choose a personalization dimension">
          <button type="button" data-editor-view="appearance" aria-pressed="true" aria-controls="panel-appearance">Appearance</button>
          <button type="button" data-editor-view="voice" aria-pressed="false" aria-controls="panel-voice">Voice</button>
          <button type="button" data-editor-view="language" aria-pressed="false" aria-controls="panel-language">Language</button>
          <button type="button" data-editor-view="comfort" aria-pressed="false" aria-controls="panel-comfort">Comfort</button>
          <button type="button" data-editor-view="personality" aria-pressed="false" aria-controls="panel-personality">Personality</button>
          <button type="button" data-editor-view="moment" aria-pressed="false" aria-controls="panel-moment">Seasons</button>
        </div>
        <div class="experience-editor">
          <div class="editor-controls js-only">
            <fieldset class="control-panel" id="panel-appearance"><legend>A world of color.</legend><p>Colors, greetings and little seasonal details. Choose a theme, or start with your favorite color.</p><div class="option-grid" role="group" aria-label="Appearance theme">
              <button class="choice-button" type="button" data-key="theme" data-value="spring" aria-pressed="true"><span class="theme-swatch spring" aria-hidden="true"></span>Spring</button>
              <button class="choice-button" type="button" data-key="theme" data-value="halloween" aria-pressed="false"><span class="theme-swatch halloween" aria-hidden="true"></span>Halloween</button>
              <button class="choice-button" type="button" data-key="theme" data-value="christmas" aria-pressed="false"><span class="theme-swatch christmas" aria-hidden="true"></span>Christmas</button>
              <button class="choice-button" type="button" data-key="theme" data-value="custom" aria-pressed="false"><span class="theme-swatch custom" aria-hidden="true"></span>Your palette</button>
            </div><label class="color-choice" for="custom-color">Make the color yours <input id="custom-color" type="color" value="#7037e5"></label><p class="control-note">Your voice, language and comfort choices stay with you.</p></fieldset>
            <fieldset class="control-panel" id="panel-voice" hidden><legend>Words that feel right.</legend><p>The same information, in a voice that fits the person reading it.</p><div class="stack-options" role="group" aria-label="Voice">
              <button class="choice-button" type="button" data-key="tone" data-value="natural" aria-pressed="true">Natural <small>Warm and straightforward</small></button>
              <button class="choice-button" type="button" data-key="tone" data-value="social" aria-pressed="false">Social <small>A little more playful</small></button>
              <button class="choice-button" type="button" data-key="tone" data-value="professional" aria-pressed="false">Professional <small>Clear, concise, considered</small></button>
              <button class="choice-button" type="button" data-key="tone" data-value="period" aria-pressed="false">Another era <small>A touch of old-world elegance</small></button>
            </div></fieldset>
            <fieldset class="control-panel" id="panel-language" hidden><legend>At home in your words.</legend><p>Try a familiar language—or step into an imagined one.</p><div class="stack-options" role="group" aria-label="Language">
              <button class="choice-button" type="button" data-key="language" data-value="en" aria-pressed="true">English <small>Hello, garden.</small></button>
              <button class="choice-button" type="button" data-key="language" data-value="de" aria-pressed="false">Deutsch <small>Hallo, Garten.</small></button>
              <button class="choice-button" type="button" data-key="language" data-value="pl" aria-pressed="false">Polski <small>Cześć, ogrodzie.</small></button>
              <button class="choice-button" type="button" data-key="language" data-value="lunari" aria-pressed="false">Lunari <small>Vela, lumari.</small></button>
            </div><p class="control-note">Lunari is an invented language for this example. These examples use prepared translations.</p></fieldset>
            <fieldset class="control-panel" id="panel-comfort" hidden><legend>A little easier to use.</legend><p>Combine the adjustments that help you read and focus.</p><div class="comfort-options">
              <label><span>Larger text<small>More comfortable reading</small></span><input type="checkbox" data-toggle="large"></label>
              <label><span>Higher contrast<small>Clear black-and-white surfaces</small></span><input type="checkbox" data-toggle="contrast"></label>
              <label><span>Simpler layout<small>One task at a time</small></span><input type="checkbox" data-toggle="simple"></label>
            </div><p class="control-note">These are examples of accessibility preferences. A complete accessible product also needs appropriate design, implementation and testing.</p></fieldset>
            <fieldset class="control-panel" id="panel-personality" hidden><legend>Find your kind of feel.</legend><p>Change the typography, shapes and visual energy. Keep your chosen voice.</p><div class="option-grid" role="group" aria-label="Visual personality">
              <button class="choice-button persona-minimal" type="button" data-key="personality" data-value="minimal" aria-pressed="true">Minimalist</button>
              <button class="choice-button persona-formal" type="button" data-key="personality" data-value="formal" aria-pressed="false">Formal</button>
              <button class="choice-button persona-playful" type="button" data-key="personality" data-value="playful" aria-pressed="false">Playful</button>
              <button class="choice-button persona-bold" type="button" data-key="personality" data-value="bold" aria-pressed="false">Bold</button>
            </div><p class="control-note">Your personality can change with your mood. No permanent labels required.</p></fieldset>
            <fieldset class="control-panel" id="panel-moment" hidden><legend>Let the year inspire it.</legend><p>Preview a moment. With seasonal changes enabled, the look and greeting follow along.</p><div class="comfort-options"><label><span>Follow the moment<small>Allow seasonal theme changes</small></span><input type="checkbox" data-toggle="auto"></label></div><div class="stack-options" role="group" aria-label="Preview a seasonal moment">
              <button class="choice-button" type="button" data-key="moment" data-value="spring" aria-pressed="true">March 20 <small>A fresh start to spring</small></button>
              <button class="choice-button" type="button" data-key="moment" data-value="halloween" aria-pressed="false">October 31 <small>A little Halloween spirit</small></button>
              <button class="choice-button" type="button" data-key="moment" data-value="christmas" aria-pressed="false">December 25 <small>A little festive warmth</small></button>
            </div><p class="control-note" id="season-note">Turn on “Follow the moment” to let the theme follow the selected date.</p></fieldset>
          </div>
          <div class="editor-preview">
            <div class="preview-heading"><span>Your GardenMate</span><span class="pill">Live prototype</span></div>
            <div class="app-shell adaptive-app" id="demo-shell" data-theme="spring" data-personality="minimal"><div class="app-topbar"><span class="app-name">GardenMate</span><span class="pill accent"><svg class="icon theme-icon" aria-hidden="true"><use href="#i-sprout"/></svg>Spring</span></div><div class="app-canvas"><div class="app-kicker"><svg class="icon theme-icon" aria-hidden="true"><use href="#i-sun"/></svg><span>Hello, spring.</span></div><h3>A fresh start for your garden.</h3><p>Three tasks this week: a hydrangea watering review, seasonal lawn care and an oleander weather check.</p></div><div class="app-footer">Check local conditions before taking action.</div></div>
            <ul class="active-preferences" id="active-preferences" aria-label="Current preferences"><li>Spring</li><li>Natural</li><li>English</li><li>Minimalist</li></ul>
            <p class="translation-note" id="language-note" hidden>Lunari is invented for this example. The three garden tasks and their meaning stay the same.</p>
          </div>
        </div>
        <div class="decision-strip"><div><strong id="decision-title">Your choices work together.</strong><p id="decision-reason">Change one part of the experience. Keep the others just the way you like them.</p></div><div class="demo-actions js-only"><button class="undo" id="undo-demo" type="button" disabled>Undo</button><button class="undo" id="reset-demo" type="button" disabled>Start fresh</button></div></div>
        <p class="demo-caption">Interactive prototype with prepared examples, not live AI. Preferences apply only to this page session.</p><p class="sr-only" id="demo-status" role="status" aria-live="polite"></p>
      </div>
    </section>

    <section class="section wrap" aria-labelledby="teams-title">
      <div class="team-grid"><div class="reveal"><p class="eyebrow">Thoughtfully designed</p><h2 id="teams-title">Made personal.<br>Still your product.</h2><p class="lead">AI should not replace product design. It should make products responsive to the people using them.</p><p class="ownership">Designers, developers and product managers stay in control. Your team defines the experience. Illuna helps it meet different people’s needs.</p></div>
        <div class="reveal"><table class="boundary-table"><caption class="sr-only">Example product-defined adaptation boundaries</caption><thead><tr><th scope="col"><svg class="icon" aria-hidden="true"><use href="#i-layers"/></svg>Adaptable</th><th scope="col"><svg class="icon" aria-hidden="true"><use href="#i-lock"/></svg>Locked</th></tr></thead><tbody><tr><td>Theme &amp; visual personality</td><td>Business rules</td></tr><tr><td>Voice &amp; language</td><td>Permissions &amp; access</td></tr><tr><td>Text size, contrast &amp; density</td><td>Critical workflows</td></tr><tr><td>Guidance &amp; feature emphasis</td><td>Compliance &amp; consent</td></tr><tr><td>Seasonal preferences</td><td>Brand &amp; accessibility limits</td></tr></tbody></table><p class="small" style="margin-top:17px">The product stays familiar. Important information stays visible. People can always find their way back.</p></div>
      </div>
      <details class="under-hood reveal"><summary>Designed to fit your product <span>What makes Illuna different</span></summary><div class="components"><div><b>Beyond a chatbot wrapper</b><p>The application’s behavior changes, not only the answer.</p></div><div><b>Beyond a theme engine</b><p>Guidance, density and workflows matter alongside appearance.</p></div><div><b>Controlled UI adaptation</b><p>Explicit targets replace arbitrary model-generated layouts.</p></div><div><b>A layer for existing products</b><p>A framework for developers, rather than a no-code app builder.</p></div><div><b>Structured decisions</b><p>Contracts, context and rules go beyond a collection of prompts.</p></div><div><b>Integrated product behavior</b><p>Adaptation reaches the experience beyond an assistant panel.</p></div></div></details>
    </section>

    <section class="section platform" id="platform" aria-labelledby="platform-title">
      <div class="wrap"><div class="platform-intro reveal"><p class="eyebrow">A platform vision</p><h2 id="platform-title">One adaptive layer.<br>Every application.</h2><p class="lead">Imagine making your product feel personal without rebuilding personalization from scratch. Illuna’s long-term direction is Framework-as-a-Service for adaptive applications.</p></div>
        <div class="platform-loop reveal" aria-label="Conceptual platform integration"><div class="endpoint"><svg class="icon" aria-hidden="true"><use href="#i-grid"/></svg><strong>Your application</strong><p>Intent + app context</p></div><div class="engine-block"><div class="engine-title"><strong>Illuna</strong><span>SDK / API concept</span></div><div class="engine-steps"><span>Intent + context</span><svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg><span>Personalization</span><svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg><span>Approved plan</span></div></div><div class="endpoint"><svg class="icon" aria-hidden="true"><use href="#i-grid"/></svg><strong>Your application</strong><p>Controlled adaptation</p></div></div>
        <div class="module-label"><span class="small">What the platform could offer</span><span class="pill">Future capabilities</span></div>
        <div class="module-grid reveal"><article class="module"><h3>Easy integration</h3><p>An SDK to connect Illuna with your product.</p></article><article class="module"><h3>A shared connection</h3><p>An API for hosted personalization services.</p></article><article class="module"><h3>Meaningful memory</h3><p>A preference layer people can inspect, change and reset.</p></article><article class="module"><h3>Your rules</h3><p>A policy engine to define what can change.</p></article><article class="module"><h3>Thoughtful adaptation</h3><p>An adaptation engine that works within your boundaries.</p></article><article class="module"><h3>Clear insight</h3><p>Observability to understand what changed and why.</p></article><article class="module"><h3>Confidence to improve</h3><p>Testing for useful, predictable experiences.</p></article><article class="module"><h3>One place to manage it</h3><p>A developer console for rules and insights.</p></article></div>
        <p class="small" style="margin-top:24px;text-align:center">One shared foundation for personal interfaces, helpful workflows and product-specific AI agents.</p>
      </div>
    </section>



    <section class="section wrap" aria-labelledby="moat-title">
      <div class="section-head reveal"><div><p class="eyebrow">Why Illuna</p><h2 id="moat-title">Built around trust.<br>Designed for people.</h2></div><p>Illuna separates understanding, decisions and execution so product teams can make adaptation predictable, explainable and reversible.</p></div>
      <div class="moat-grid reveal"><article class="moat-item"><span>Architecture</span><h3>Thoughtful by design.</h3><p>Understanding, decision-making and action have distinct roles, so each part can be checked and improved.</p></article><article class="moat-item"><span>Control</span><h3>Boundaries that hold.</h3><p>The product team decides what can change and what must stay protected.</p></article><article class="moat-item"><span>Memory</span><h3>Context worth remembering.</h3><p>Relevant preferences could spare people from repeating themselves, with control over what is remembered.</p></article><article class="moat-item"><span>Integration</span><h3>Less work, reused.</h3><p>Shared tools could help teams add personal experiences without solving the same problems again.</p></article><article class="moat-item"><span>Reach</span><h3>A model that travels.</h3><p>A product keeps its own expertise. Illuna’s adaptation model could support many different kinds of application.</p></article><article class="moat-item"><span>Understanding</span><h3>Changes you can explain.</h3><p>Understanding why an experience changed is essential to making it better.</p></article></div>
      <div class="insight reveal"><svg class="icon" aria-hidden="true"><use href="#i-layers"/></svg><div><h3>Every preference could teach the product something.</h3><p>With consent and careful aggregation, repeated requests could help teams see where people struggle and what deserves to improve.</p></div></div>
    </section>

    <section class="section wrap" aria-labelledby="ecosystem-title">
      <div class="section-head reveal"><div><p class="eyebrow">A world of possibilities</p><h2 id="ecosystem-title">One idea.<br>Many possibilities.</h2></div><p>GardenMate is the first documented example. Other scenarios explore how the same idea could fit different parts of life.</p></div>
      <div class="ecosystem-grid"><article class="garden-example reveal"><span class="pill accent">The first example</span><svg class="icon" aria-hidden="true"><use href="#i-leaf"/></svg><h3>GardenMate</h3><p>A gardening companion that explores how an app could fit your knowledge, language, style and everyday needs.</p><blockquote class="example-quote">“I am new to gardening and only have 20 minutes per week.”</blockquote><p class="small">Guidance is one dimension. This prototype also explores voice, language, appearance and comfort around the same garden tasks.</p><a class="text-link" href="{{ route('docs.show', 'examples-and-implementation') }}">Explore the product examples <span aria-hidden="true">→</span></a></article>
        <div class="domain-grid reveal"><article class="domain"><span class="meta">A possible application</span><h3>Finance</h3><p>Concise decision views or detailed audit trails.</p></article><article class="domain"><span class="meta">A possible application</span><h3>Education</h3><p>Explanation pace, visual density and difficulty matched to learner signals.</p></article><article class="domain"><span class="meta">A possible application</span><h3>Health routines</h3><p>Tone and reminders that respond to motivation and context.</p></article><article class="domain"><span class="meta">A possible application</span><h3>Team productivity</h3><p>Guidance, summaries and notification intensity shaped by role and workload.</p></article></div>
      </div>
    </section>

    <section class="section roadmap" id="roadmap" aria-labelledby="roadmap-title">
      <div class="wrap"><div class="section-head reveal"><div><p class="eyebrow">Where we are</p><h2 id="roadmap-title">From vision<br>to working prototypes.</h2></div><p>Illuna is in the prototyping phase. We are developing and testing the first experiences, building on the public architecture and learning what makes adaptation useful.</p></div>
        <ol class="timeline reveal"><li class="milestone completed"><span class="pill">Completed</span><h3>Concept</h3><p>The foundation: product vision, reference architecture and initial interface patterns.</p></li><li class="milestone current"><span class="pill accent">Today</span><h3>Prototyping</h3><p>Developing the first flows, exploring intent understanding and testing how approved adaptations feel in practice.</p></li><li class="milestone"><span class="pill">Planned</span><h3>Pilot</h3><p>Learn with a small group of users. See which changes help, which get undone and what earns trust.</p></li><li class="milestone"><span class="pill">Planned</span><h3>Production readiness</h3><p>Strengthen product boundaries and integrations. Give people clear ways to inspect, export, reset and delete preferences.</p></li></ol>
        <div class="horizon reveal"><div><strong>The longer-term ambition: a shared platform.</strong><p>Turn what works in early products into a framework that more teams can use.</p></div><span class="pill">Future direction</span></div>
        <a class="text-link" href="{{ route('docs.show', 'roadmap') }}">Read the roadmap <span aria-hidden="true">→</span></a>
      </div>
    </section>



    <section class="closing" id="learn-more" aria-labelledby="learn-more-title">
      <div class="wrap reveal"><p class="eyebrow">Get to know Illuna</p><h2 id="learn-more-title">Understand the idea.<br><span>Explore the details.</span></h2><p class="lead">See how intent, context and product rules work together to create more personal software.</p><div class="actions"><a class="button primary" href="{{ route('docs.index') }}">Explore the documentation<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a><a class="button" href="#demo">Try the interactive demo</a></div><p class="meta">Currently in prototyping. The documentation describes concepts, patterns and the planned architecture.</p></div>
    </section>
  </main>
  <footer class="site-footer"><div class="wrap"><div class="footer-row"><a class="brand" href="#top" aria-label="Illuna home"><svg class="brand-mark" aria-hidden="true"><use href="#i-mark"/></svg>illuna</a><p class="small">Software, more personal.</p><div class="footer-links"><a href="#vision">Vision</a><a href="#roadmap">Roadmap</a><a href="{{ route('docs.index') }}">Documentation</a></div></div><p class="footer-note">Illuna is in the prototyping phase. Explore the product vision, try the interactive examples and learn how controlled adaptation works.</p></div></footer>
  <noscript><p class="wrap small" style="padding-bottom:24px">Enable JavaScript to combine themes, voices, languages and comfort preferences, and try undo. The default examples and product information are available above.</p></noscript>
  <script src="{{ asset('assets/landing.js') }}" defer></script>
</body>
</html>
