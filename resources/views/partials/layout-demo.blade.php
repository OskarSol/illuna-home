@php
    $tasks = [
        ['id' => 'hydrangea', 'name' => 'Hydrangea', 'action' => 'Watering review', 'area' => 'Patio border', 'time' => '5 min', 'icon' => 'i-sprout', 'detail' => 'Review the soil moisture and your watering notes before deciding what your hydrangea needs.'],
        ['id' => 'lawn', 'name' => 'Lawn', 'action' => 'Seasonal care', 'area' => 'Back garden', 'time' => '10 min', 'icon' => 'i-leaf', 'detail' => 'Check which seasonal care tasks are relevant to your lawn and the conditions in your garden.'],
        ['id' => 'oleander', 'name' => 'Oleander', 'action' => 'Weather check', 'area' => 'Terrace', 'time' => '5 min', 'icon' => 'i-sun', 'detail' => 'Compare the local forecast with the care notes for your oleander before making a change.'],
    ];
@endphp
<section class="section wrap" id="layout-demo" aria-labelledby="layout-title">
    <div class="section-head"><div><p class="eyebrow">02 / A DIFFERENT WAY THROUGH</p><h2 id="layout-title">Your tasks.<br>Your kind of workspace.</h2></div><p>From a visual overview to a dense workbench or a quiet, guided flow. The same three tasks, organized around you.</p></div>
    <div class="layout-choices js-only" role="group" aria-label="Choose workspace layout">
        <button type="button" data-layout="cards" aria-pressed="true" aria-controls="layout-workspace"><span>01 · Visual overview</span><strong>“Give me the big picture.”</strong><small>Roomy cards and a sidebar</small></button>
        <button type="button" data-layout="table" aria-pressed="false" aria-controls="layout-workspace"><span>02 · Compact workbench</span><strong>“Let me scan everything.”</strong><small>A full-width, information-rich table</small></button>
        <button type="button" data-layout="guided" aria-pressed="false" aria-controls="layout-workspace"><span>03 · Guided focus</span><strong>“One thing at a time, please.”</strong><small>A focused step-by-step flow</small></button>
    </div>
    <div class="layout-workspace" id="layout-workspace" data-mode="cards">
        <aside class="workspace-sidebar" aria-label="Example app sections"><span class="workspace-brand"><svg class="icon" aria-hidden="true"><use href="#i-leaf"/></svg>GardenMate</span><span class="workspace-nav-label selected">My week</span><span class="workspace-nav-label">My plants</span><span class="workspace-nav-label">Care notes</span><div class="workspace-season"><svg class="icon" aria-hidden="true"><use href="#i-sun"/></svg><strong>A little room to grow.</strong><p>Make the most of a quiet garden moment.</p></div></aside>
        <div class="workspace-main">
            <div class="workspace-top"><span>MY GARDEN / THIS WEEK</span><span class="pill accent">3 tasks · 20 minutes</span></div>
            <div class="workspace-heading"><h3 id="workspace-title">A little care goes a long way.</h3><p id="workspace-description">Your week, at a glance. Pick a task when you are ready.</p></div>
            <div class="workspace-cards" data-layout-panel="cards">
                @foreach ($tasks as $task)
                    <article class="garden-task" data-task-id="{{ $task['id'] }}"><div class="task-illustration"><svg class="icon" aria-hidden="true"><use href="#{{ $task['icon'] }}"/></svg></div><span class="task-area">{{ $task['area'] }}</span><h4>{{ $task['name'] }}</h4><p>{{ $task['action'] }}</p><div class="task-meta"><span>To review</span><span>{{ $task['time'] }}</span></div></article>
                @endforeach
            </div>
            <div class="workspace-table" data-layout-panel="table" hidden>
                <table><caption class="sr-only">The same garden tasks in a compact view</caption><thead><tr><th scope="col">Plant / area</th><th scope="col">Task</th><th scope="col">Location</th><th scope="col">Time</th><th scope="col">Status</th></tr></thead><tbody>
                    @foreach ($tasks as $task)
                        <tr data-task-id="{{ $task['id'] }}"><th scope="row">{{ $task['name'] }}</th><td>{{ $task['action'] }}</td><td>{{ $task['area'] }}</td><td>{{ $task['time'] }}</td><td><span class="pill">To review</span></td></tr>
                    @endforeach
                </tbody></table>
            </div>
            <div class="workspace-guided" data-layout-panel="guided" hidden>
                <p class="guided-progress" id="guided-progress">Step 1 of 3</p>
                @foreach ($tasks as $task)
                    <article class="guided-task" data-guided-step="{{ $loop->index }}" data-task-id="{{ $task['id'] }}" @if(!$loop->first) hidden @endif><svg class="icon" aria-hidden="true"><use href="#{{ $task['icon'] }}"/></svg><span class="task-area">{{ $task['area'] }} · {{ $task['time'] }}</span><h4>{{ $task['name'] }}</h4><strong>{{ $task['action'] }}</strong><p>{{ $task['detail'] }}</p></article>
                @endforeach
                <div class="guided-navigation"><button type="button" class="button" id="guided-back" disabled>Previous</button><button type="button" class="button primary" id="guided-next">Next task →</button></div>
            </div>
            <div class="workspace-footer"><svg class="icon" aria-hidden="true"><use href="#i-lock"/></svg>Check local conditions before taking action.</div>
        </div>
    </div>
    <div class="decision-strip"><div><strong>Same information. A different path.</strong><p id="layout-status" role="status" aria-live="polite">Cards keep all three tasks visible at a glance.</p></div><div class="demo-actions js-only"><button type="button" class="undo" id="layout-undo" disabled>Undo layout</button><button type="button" class="undo" id="layout-reset" disabled>Reset layout</button></div></div>
    <p class="demo-caption">Prepared layouts, selected locally. Switching views does not change or complete the underlying tasks.</p>
</section>
