(() => {
    "use strict";
    const motion = window.matchMedia("(prefers-reduced-motion: reduce)");
    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");
    function closeMenu(restoreFocus = false) {
      navLinks.classList.remove("open");
      menuToggle.setAttribute("aria-expanded", "false");
      if (restoreFocus) menuToggle.focus();
    }
    menuToggle.addEventListener("click", () => {
      const expanded = menuToggle.getAttribute("aria-expanded") !== "true";
      menuToggle.setAttribute("aria-expanded", String(expanded));
      navLinks.classList.toggle("open", expanded);
    });
    navLinks.addEventListener("click", event => {
      if (event.target instanceof Element && event.target.closest("a")) closeMenu();
    });
    document.addEventListener("keydown", event => {
      if (event.key === "Escape" && navLinks.classList.contains("open")) closeMenu(true);
    });

    // Preserve native anchor navigation and move keyboard focus to the destination.
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener("click", () => {
        const target = document.getElementById(link.getAttribute("href").slice(1));
        if (!target) return;
        if (!target.hasAttribute("tabindex")) target.setAttribute("tabindex", "-1");
        target.focus({ preventScroll: true });
      });
    });

    const header = document.getElementById("site-header");
    let scrollQueued = false;
    function syncHeader() { header.classList.toggle("scrolled", window.scrollY > 12); scrollQueued = false; }
    window.addEventListener("scroll", () => {
      if (!scrollQueued) { scrollQueued = true; requestAnimationFrame(syncHeader); }
    }, { passive: true });
    syncHeader();

    document.documentElement.classList.add("js");

    // Finite reveals and a single architecture pass; no autoplaying demo or loop.
    if ("IntersectionObserver" in window && !motion.matches) {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          entry.target.classList.remove("pending");
          if (entry.target.id === "architecture-flow") entry.target.classList.add("played");
          observer.unobserve(entry.target);
        });
      }, { threshold: .08 });
      document.querySelectorAll(".reveal").forEach(element => {
        if (element.getBoundingClientRect().top > window.innerHeight) element.classList.add("pending");
        observer.observe(element);
      });
      const flow = document.getElementById("architecture-flow");
      if (flow) observer.observe(flow);
      motion.addEventListener("change", event => {
        if (!event.matches) return;
        document.querySelectorAll(".reveal.pending").forEach(element => element.classList.remove("pending"));
        observer.disconnect();
        document.getAnimations().forEach(animation => animation.cancel());
      });
    }

  })();
