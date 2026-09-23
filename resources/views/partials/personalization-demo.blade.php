    <section class="section demo-section" id="demo" aria-labelledby="demo-title">
      <div class="wrap">
        <div class="section-head reveal"><div><p class="eyebrow">01 / MAKE IT PERSONAL</p><h2 id="demo-title">Same app.<br>More you.</h2></div><p>A festive look. A professional voice. Larger text. Mix what matters to you and watch one familiar app adapt.</p></div>
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
