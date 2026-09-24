@extends('layouts.site')
@section('content')

    <section class="hero" id="top" aria-labelledby="hero-title">
      <div class="wrap">
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="eyebrow">Software, made personal.</p>
            <h1 id="hero-title">Every App Should Feel<br>Like It Was <span>Made for You</span></h1>
            <p class="lead">Your style. Your language. Your way of moving through the world. Illuna imagines software that adapts to all of it.</p>
            <div class="actions"><a class="button primary" href="{{ route('demo') }}#demo">Explore Illuna<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a><a class="button" href="{{ route('docs.index') }}">Read the documentation<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a></div>
            <p class="stage-note">Now prototyping. Turning the vision into working experiences.</p>
            <p class="stage-note"><strong>Up to 1,000 free requests per month.</strong> After registration, use translations and language or tone adjustments for text labels only. <a class="text-link" href="{{ route('register') }}">Create your account <span aria-hidden="true">↗</span></a></p>
          </div>
          <figure class="hero-visual" id="hero-visual">
            <div class="visual-label"><span>One app. So many ways to be you.</span><span class="index">Explore the possibilities</span></div>
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
                <a class="text-link" href="{{ route('demo') }}#demo">Make it yours <span aria-hidden="true">↗</span></a>
              </aside>
            </div>
            <figcaption class="demo-caption">A glimpse of GardenMate. Explore the interactive examples on the demo page.</figcaption>
            <p class="sr-only" id="hero-status" role="status" aria-live="polite"></p>
          </figure>
        </div>
        <div class="hero-foot"><p><strong>Understands what you need.</strong>Start with your own words.</p><p><strong>Adapts with care.</strong>Changes that fit the product.</p><p><strong>Keeps you in control.</strong>An experience you can shape.</p></div>
      </div>
    </section>

    <section class="section wrap" id="vision" aria-labelledby="possibilities-title">
      <div class="section-head reveal"><div><p class="eyebrow">What this looks like</p><h2 id="possibilities-title">As individual<br>as you are.</h2></div><p>Personalization is more than a level of detail. It is how software looks, speaks, feels—and fits into your life.</p></div>
      <div class="possibility-grid">
        <article class="possibility reveal"><div class="possibility-visual palette-sample" aria-hidden="true"><span style="background:#38794d"></span><span style="background:#c66a20"></span><span style="background:#a63042"></span><span style="background:#783ce0"></span></div><h3>Switch Effortlessly</h3><p>Christmas warmth. Halloween spirit. A fresh spring palette. Or a look made from your own favorite colors.</p><a class="text-link" href="{{ route('demo', ['view' => 'appearance']) }}#demo">Find your look <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual voice-sample" aria-hidden="true"><span>Hey, plant parent.</span><span>Your garden briefing.</span></div><h3>Speak Naturally</h3><p>From a social feed to the boardroom—or the elegant turn of phrase of another era. A voice that meets people where they are.</p><a class="text-link" href="{{ route('demo', ['view' => 'voice']) }}#demo">Hear the difference <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual language-sample" aria-hidden="true"><span>Hello.</span><span>Hallo.</span><span>Vela.</span></div><h3>Translate Instantly</h3><p>Feel at home in a familiar language. Or imagine a new one, with a vocabulary born from creativity rather than geography.</p><a class="text-link" href="{{ route('demo', ['view' => 'language']) }}#demo">Explore a language <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual comfort-sample" aria-hidden="true"><span>Aa</span><span>Aa</span><span>Aa</span></div><h3>Adapt to Every Ability</h3><p>Larger text. Clearer contrast. Simpler layouts. Preferences that make an experience easier to use, supported by thoughtful design and accessibility testing.</p><a class="text-link" href="{{ route('demo', ['view' => 'comfort']) }}#demo">Find your comfort <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual personality-sample" aria-hidden="true"><span>Quiet.</span><span>Bold.</span></div><h3>Reflect Your Personality</h3><p>Playful, minimalist, formal or bold. Let the visual rhythm and character of an app feel closer to your own.</p><a class="text-link" href="{{ route('demo', ['view' => 'personality']) }}#demo">Set the mood <span aria-hidden="true">↗</span></a></article>
        <article class="possibility reveal"><div class="possibility-visual moment-sample" aria-hidden="true"><span>MAR</span><span>OCT</span><span>DEC</span></div><h3>Evolve with Time</h3><p>Let a chosen look follow the seasons, celebrations and cultural moments that matter to you. An experience that can change as life does.</p><a class="text-link" href="{{ route('demo', ['view' => 'moment']) }}#demo">Move through the year <span aria-hidden="true">↗</span></a></article>
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
      <div class="wrap reveal"><p class="eyebrow">Get to know Illuna</p><h2 id="learn-more-title">Understand the idea.<br><span>Explore the details.</span></h2><p class="lead">See how intent, context and product rules work together to create more personal software.</p><div class="actions"><a class="button primary" href="{{ route('docs.index') }}">Explore the documentation<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg></a><a class="button" href="{{ route('demo') }}#demo">Try the interactive demo</a></div><p class="meta">Currently in prototyping. The documentation describes concepts, patterns and the planned architecture.</p></div>
    </section>

@endsection
