(() => {
    "use strict";
    document.querySelectorAll("[data-js-control]").forEach(button => { button.hidden = false; });
    document.querySelectorAll("[data-toggle-key]").forEach(button => button.addEventListener("click", () => {
        const input = document.getElementById(button.dataset.toggleKey);
        const visible = input.type === "password";
        input.type = visible ? "text" : "password";
        button.textContent = visible ? "Hide key" : "Show key";
        button.setAttribute("aria-pressed", String(visible));
    }));
    document.querySelectorAll("[data-copy-target]").forEach(button => button.addEventListener("click", async () => {
        const target = document.getElementById(button.dataset.copyTarget);
        const value = target instanceof HTMLInputElement ? target.value : target.textContent;
        const scope = button.closest(".api-key-card, .api-demo") || document;
        const status = scope.querySelector(".code-copy-status");
        try {
            await navigator.clipboard.writeText(value);
            status.textContent = "Copied to clipboard.";
        } catch {
            status.textContent = "Clipboard access is unavailable. Select and copy the text manually.";
            target.focus();
            if (target instanceof HTMLInputElement) {
                target.type = "text";
                target.select();
                const toggle = scope.querySelector("[data-toggle-key]");
                if (toggle) {
                    toggle.textContent = "Hide key";
                    toggle.setAttribute("aria-pressed", "true");
                }
            } else {
                const range = document.createRange();
                range.selectNodeContents(target);
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }
    }));
})();
