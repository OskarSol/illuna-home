(() => {
    "use strict";

    const workspace = document.getElementById("layout-workspace");
    const buttons = [...document.querySelectorAll("[data-layout]")];
    const steps = [...workspace.querySelectorAll("[data-guided-step]")];
    const undo = document.getElementById("layout-undo");
    const reset = document.getElementById("layout-reset");
    const back = document.getElementById("guided-back");
    const next = document.getElementById("guided-next");
    const history = [];
    let mode = "cards";
    let step = 0;
    const copy = {
        cards: ["A little care goes a long way.", "Your week, at a glance. Pick a task when you are ready.", "Cards keep all three tasks visible at a glance."],
        table: ["Your garden workbench.", "All the details. Less scrolling. The same tasks.", "A compact table brings task, location, time and status together."],
        guided: ["A moment of focus.", "One task, then the next. Nothing to rush.", "The sidebar and overview step aside for a focused, guided flow."]
    };

    function render() {
        workspace.dataset.mode = mode;
        buttons.forEach(button => button.setAttribute("aria-pressed", String(button.dataset.layout === mode)));
        workspace.querySelectorAll("[data-layout-panel]").forEach(panel => { panel.hidden = panel.dataset.layoutPanel !== mode; });
        steps.forEach((item, index) => { item.hidden = index !== step; });
        document.getElementById("workspace-title").textContent = copy[mode][0];
        document.getElementById("workspace-description").textContent = copy[mode][1];
        document.getElementById("guided-progress").textContent = `Step ${step + 1} of ${steps.length}`;
        document.getElementById("layout-status").textContent = copy[mode][2] + (mode === "guided" ? ` Step ${step + 1} of ${steps.length}: ${steps[step].querySelector("h4").textContent}.` : "");
        back.disabled = step === 0;
        next.textContent = step === steps.length - 1 ? "Back to first task ↺" : "Next task →";
        undo.disabled = history.length === 0;
        reset.disabled = mode === "cards" && step === 0;
    }

    function changeMode(value) {
        if (!Object.hasOwn(copy, value) || value === mode) return;
        history.push({mode, step});
        if (history.length > 40) history.shift();
        mode = value;
        render();
    }
    buttons.forEach(button => button.addEventListener("click", () => changeMode(button.dataset.layout)));
    next.addEventListener("click", () => { step = (step + 1) % steps.length; render(); });
    back.addEventListener("click", () => {
        step = Math.max(0, step - 1);
        render();
        if (back.disabled) next.focus({preventScroll: true});
    });
    undo.addEventListener("click", () => {
        if (!history.length) return;
        ({mode, step} = history.pop());
        render();
        if (undo.disabled) buttons.find(button => button.dataset.layout === mode).focus({preventScroll: true});
    });
    reset.addEventListener("click", () => {
        history.push({mode, step});
        if (history.length > 40) history.shift();
        mode = "cards";
        step = 0;
        render();
        undo.focus({preventScroll: true});
    });
})();
