(() => {
      "use strict";

      // Optional launch configuration: add only a verified https: or mailto: URL.
      // Empty keeps the honest contact placeholder and GitHub fallback.
      const CONTACT_URL = "";
      const motion = window.matchMedia("(prefers-reduced-motion: reduce)");
      const arrow = '<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg>';
      // Prepared, local-only examples. No model call or real translation service is implied.
      // Domain record IDs stay constant across every presentation and seasonal state.
      const taskIds = Object.freeze(["hydrangea", "lawn", "oleander"]);
      const base = Object.freeze({ theme:"spring", tone:"natural", language:"en", personality:"minimal", large:false, contrast:false, simple:false, auto:false, moment:"spring", color:"#7037e5", step:0 });
      const labels = {
        theme:{spring:"Spring",halloween:"Halloween",christmas:"Christmas",custom:"Your palette"},
        tone:{natural:"Natural",social:"Social",professional:"Professional",period:"Another era"},
        language:{en:"English",de:"Deutsch",pl:"Polski",lunari:"Lunari"},
        personality:{minimal:"Minimalist",formal:"Formal",playful:"Playful",bold:"Bold"},
        moment:{spring:"March 20",halloween:"October 31",christmas:"December 25"}
      };
      const words = {
        en:{ lang:"en", nav:["Overview","My garden","Care history"], metrics:["Care tasks","To review","Weather check"], names:["Hydrangea","Lawn","Oleander"], ops:["Watering review","Seasonal care","Weather check"], details:["Review the watering information for your hydrangea before deciding what it needs.","Check which seasonal care tasks are relevant to your lawn.","Compare the local weather with the care notes for your oleander."], footer:"Check local conditions before taking action.", theme:["Spring","Halloween","Christmas","Your palette"], step:"Step", of:"of", note:"Three tasks. The same garden.", kicker:["A little room to grow","Your garden era","This week’s priorities","A note from the garden"], title:["Your garden, looking good.","Hey, plant parent.","Your garden briefing.","Shall we tend the garden?"], intro:["Three small tasks. A little care goes a long way.","Three little check-ins. You and your plants have got this.","Three scheduled reviews. Here is your overview.","Three matters invite your attention. Let us give each its due care."], next:["Next task","What’s next?","Next item","Pray, continue"], back:["Back to first task","One more look?","Return to first item","Let us begin anew"] },
        de:{ lang:"de", nav:["Übersicht","Mein Garten","Pflegeverlauf"], metrics:["Aufgaben","Zur Prüfung","Wettercheck"], names:["Hortensie","Rasen","Oleander"], ops:["Bewässerung prüfen","Saisonale Pflege","Wetter prüfen"], details:["Sieh dir die Bewässerungsinformationen deiner Hortensie an, bevor du entscheidest, was sie braucht.","Prüfe, welche saisonalen Pflegeaufgaben für deinen Rasen anstehen.","Vergleiche das Wetter vor Ort mit den Pflegehinweisen für deinen Oleander."], footer:"Prüfe die Bedingungen vor Ort, bevor du handelst.", theme:["Frühling","Halloween","Weihnachten","Deine Farben"], step:"Schritt", of:"von", note:"Drei Aufgaben. Derselbe Garten.", kicker:["Ein bisschen Raum zum Wachsen","Dein Gartenmoment","Prioritäten dieser Woche","Eine Nachricht aus dem Garten"], title:["Dein Garten macht sich.","Na, du Pflanzenprofi!","Dein Garten im Überblick.","Wollen wir den Garten hegen?"], intro:["Drei kleine Aufgaben. Ein wenig Pflege macht viel aus.","Drei kurze Checks. Das kriegt ihr hin, du und dein Grün.","Drei geplante Prüfungen. Hier ist die Übersicht.","Drei Angelegenheiten erbitten deine Aufmerksamkeit. Widmen wir jeder die gebührende Sorgfalt."], next:["Nächste Aufgabe","Was steht noch an?","Nächster Punkt","Fahren wir fort"], back:["Zur ersten Aufgabe","Noch eine Runde?","Zurück zum ersten Punkt","Beginnen wir aufs Neue"] },
        pl:{ lang:"pl", nav:["Przegląd","Mój ogród","Historia pielęgnacji"], metrics:["Zadania","Do przeglądu","Pogoda"], names:["Hortensja","Trawnik","Oleander"], ops:["Sprawdź podlewanie","Pielęgnacja sezonowa","Sprawdź pogodę"], details:["Sprawdź informacje o podlewaniu hortensji, zanim zdecydujesz, czego potrzebuje.","Sprawdź, jakie sezonowe prace są potrzebne na trawniku.","Porównaj lokalną pogodę z zaleceniami dotyczącymi oleandra."], footer:"Przed działaniem sprawdź lokalne warunki.", theme:["Wiosna","Halloween","Boże Narodzenie","Twoje kolory"], step:"Krok", of:"z", note:"Trzy zadania. Ten sam ogród.", kicker:["Czas na odrobinę zieleni","Twój ogrodowy moment","Priorytety tygodnia","Wieści z ogrodu"], title:["Twój ogród ma się dobrze.","Hej, miłośniku roślin!","Twój raport ogrodowy.","Czy zechcesz zadbać o ogród?"], intro:["Trzy małe zadania. Odrobina troski wiele zmienia.","Trzy szybkie przeglądy. Ty i twoje rośliny dacie radę.","Trzy zaplanowane przeglądy. Oto ich zestawienie.","Trzy sprawy upraszają się twej uwagi. Każdej poświęćmy należytą troskę."], next:["Następne zadanie","Co dalej?","Następny punkt","Zechciejmy kontynuować"], back:["Wróć do pierwszego zadania","Jeszcze raz?","Wróć do pierwszego punktu","Pocznijmy na nowo"] },
        lunari:{ lang:"art-x-lunari", nav:["Luma","Mi lumari","Vela nori"], metrics:["Nori","Veli","Aeri"], names:["Hydralu","Verdin","Olearis"], ops:["Aqua veli","Sola nori","Aeri veli"], details:["Veli aqua na Hydralu. Nori sera, luma clara.","Veli sola nori na Verdin. Luma sera.","Veli aeri na Olearis. Nori sera, aeri clara."], footer:"Veli aeri e terra, ante nori.", theme:["Florali","Noctara","Stellara","Mi colori"], step:"Nora", of:"de", note:"Tri nori. Uni lumari.", kicker:["Luma sera","Vela, florin!","Nori ordinata","Epistola lumaris"], title:["Vela, mi lumari.","Hei, florin luma!","Lumari: tri nori.","Velaria, lumaris serena."], intro:["Tri nori. Sera luma, florali vera.","Tri nori, florin. Luma-luma, sera!","Tri nori ordinata. Veli luma clara.","Tri noralia velaria. Sera lumaris, clara floralia."], next:["Nora nova","Luma nexta?","Nori sequa","Velaria, proceda"], back:["Nora prima","Luma renova?","Nori prima","Velaria, renova"] }
      };
      // Seasonal presentation copy is localized and keeps the selected tone.
      // The garden records, safety text and user preferences are unchanged.
      const seasonalCopy = {
        en: {
          spring: { kicker:"Hello, spring.", lines:[
            ["A fresh start for your garden.","A little spring energy for your day. Three familiar tasks, ready when you are."],
            ["New season. Same plant parent.","Spring has entered the chat. Your three little garden check-ins are ready."],
            ["Your spring garden briefing.","A fresh seasonal view of your three scheduled reviews."],
            ["Shall we welcome the spring?","A gentler season graces our garden. Three matters await your kind attention."]
          ]},
          halloween: { kicker:"A little Halloween spirit.", lines:[
            ["A little spooky. Still your garden.","A touch of autumn magic, with three familiar tasks to keep things feeling cared for."],
            ["Hey, pumpkin. Let’s check in.","Spooky season, zero jump scares. Just your three garden check-ins."],
            ["Your Halloween garden briefing.","A seasonal touch for Halloween. Your three scheduled reviews remain in focus."],
            ["A curious evening in the garden.","As lanterns glow and shadows gather, three garden matters request your attention."]
          ]},
          christmas: { kicker:"A little festive warmth.", lines:[
            ["A little joy for your garden.","Make room for a quiet garden moment among the festivities. Your three tasks are here."],
            ["Merry little garden moments.","A festive glow, a little green. Three quick check-ins before the next mince pie."],
            ["Your festive garden briefing.","A Christmas view of your three scheduled reviews, clearly organized for the holidays."],
            ["Season’s greetings, dear gardener.","Amid the merriment, let us spare a moment for the three matters of our garden."]
          ]}
        },
        de: {
          spring: { kicker:"Hallo, Frühling.", lines:[
            ["Ein frischer Start für deinen Garten.","Ein bisschen Frühlingsgefühl für deinen Tag. Deine drei vertrauten Aufgaben warten auf dich."],
            ["Neue Saison. Dein grüner Moment.","Der Frühling ist im Chat. Deine drei kleinen Gartenchecks stehen bereit."],
            ["Dein Gartenbriefing zum Frühling.","Ein frischer saisonaler Blick auf deine drei geplanten Prüfungen."],
            ["Wollen wir den Frühling begrüßen?","Eine mildere Jahreszeit hält Einzug. Drei Gartenangelegenheiten erbitten deine Aufmerksamkeit."]
          ]},
          halloween: { kicker:"Ein Hauch von Halloween.", lines:[
            ["Ein bisschen Spuk im Garten.","Etwas Herbstzauber für deinen Tag. Die drei vertrauten Gartenaufgaben bleiben im Blick."],
            ["Buh! Na, du Pflanzenprofi?","Gruselige Stimmung, ganz entspannte Gartenchecks. Drei kleine Aufgaben warten auf dich."],
            ["Dein Gartenbriefing zu Halloween.","Ein saisonaler Akzent zu Halloween. Deine drei geplanten Prüfungen bleiben im Fokus."],
            ["Ein wunderlicher Abend im Garten.","Während die Laternen leuchten, erbitten drei Gartenangelegenheiten deine geschätzte Aufmerksamkeit."]
          ]},
          christmas: { kicker:"Ein wenig Weihnachtszauber.", lines:[
            ["Ein festlicher Moment für deinen Garten.","Zwischen all den Feierlichkeiten ist Zeit für ein wenig Grün. Deine drei Aufgaben sind hier."],
            ["Ho, ho, hol dir deinen Gartenmoment.","Etwas Weihnachtsglanz, etwas Grün. Drei kleine Checks vor dem nächsten Plätzchen."],
            ["Dein weihnachtliches Gartenbriefing.","Deine drei geplanten Prüfungen, übersichtlich zusammengestellt für die Festtage."],
            ["Festliche Grüße, werter Gartenfreund.","Inmitten der Feierlichkeiten wollen wir den drei Angelegenheiten unseres Gartens einen Moment widmen."]
          ]}
        },
        pl: {
          spring: { kicker:"Witaj, wiosno.", lines:[
            ["Świeży początek dla twojego ogrodu.","Odrobina wiosennej energii na dziś. Trzy znajome zadania czekają na ciebie."],
            ["Nowy sezon. Twój zielony moment.","Wiosna dołączyła do rozmowy. Twoje trzy małe przeglądy ogrodu są gotowe."],
            ["Twój wiosenny raport ogrodowy.","Świeże, sezonowe spojrzenie na trzy zaplanowane przeglądy."],
            ["Czy zechcemy powitać wiosnę?","Łagodniejsza pora roku zawitała do ogrodu. Trzy sprawy upraszają się twej uwagi."]
          ]},
          halloween: { kicker:"Odrobina ducha Halloween.", lines:[
            ["Trochę tajemnicy w twoim ogrodzie.","Odrobina jesiennej magii. Trzy znajome zadania pozostają w zasięgu ręki."],
            ["Buu! Jak tam twoje rośliny?","Straszny klimat, spokojny ogród. Tylko trzy krótkie przeglądy."],
            ["Twój raport ogrodowy na Halloween.","Sezonowy akcent na Halloween. Trzy zaplanowane przeglądy pozostają na pierwszym planie."],
            ["Osobliwy wieczór w ogrodzie.","Gdy latarnie rozświetlają mrok, trzy ogrodowe sprawy proszą o twą uwagę."]
          ]},
          christmas: { kicker:"Odrobina świątecznego ciepła.", lines:[
            ["Świąteczna chwila dla twojego ogrodu.","Wśród świątecznej radości znajdź chwilę na zieleń. Twoje trzy zadania są tutaj."],
            ["Ho, ho, ogrodowy czas!","Trochę blasku, trochę zieleni. Trzy szybkie przeglądy przed kolejnym pierniczkiem."],
            ["Twój świąteczny raport ogrodowy.","Trzy zaplanowane przeglądy, przejrzyście zestawione na świąteczny czas."],
            ["Świąteczne pozdrowienia, miły ogrodniku.","Pośród radosnych obchodów poświęćmy chwilę trzem sprawom naszego ogrodu."]
          ]}
        },
        lunari: {
          spring: { kicker:"Vela, Florali.", lines:[
            ["Florali nova, mi lumari.","Sera florali, luma vera. Tri nori na mi lumari."],
            ["Hei florin, Florali nova!","Luma-luma, florali! Tri nori, sera nova."],
            ["Florali: lumari ordinata.","Tri nori ordinata. Veli florali, luma clara."],
            ["Velaria, Floralis serena.","Floralia grata, lumaris nova. Tri noralia velaria."]
          ]},
          halloween: { kicker:"Vela, Noctara.", lines:[
            ["Noctara sera, mi lumari.","Luma noctara, sera vera. Tri nori na mi lumari."],
            ["Buu, florin nocta!","Nocta-luma, florin! Tri nori, sera-sera."],
            ["Noctara: lumari ordinata.","Tri nori ordinata. Veli noctara, luma clara."],
            ["Velaria, Noctaris lumina.","Noctaria lumina, lumaris serena. Tri noralia velaria."]
          ]},
          christmas: { kicker:"Vela, Stellara.", lines:[
            ["Stellara luma, mi lumari.","Sera stellara, luma vera. Tri nori na mi lumari."],
            ["Hei florin, stella-stella!","Luma-luma, stellara! Tri nori, sera festa."],
            ["Stellara: lumari ordinata.","Tri nori ordinata. Veli stellara, luma clara."],
            ["Velaria, Stellaris serena.","Stellaria grata, lumaris lumina. Tri noralia velaria."]
          ]}
        }
      };
      const seasonalIcons = Object.freeze({spring:["i-sprout","i-sun"],halloween:["i-pumpkin","i-moon"],christmas:["i-tree","i-snowflake"]});
      const seasonIcon = id => `<svg class="icon theme-icon" aria-hidden="true" focusable="false"><use href="#${id}"/></svg>`;

      const toneIndex = key => ["natural","social","professional","period"].indexOf(key);
      const escapeText = value => String(value).replace(/[&<>"']/g, c => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]));
      const effectiveTheme = state => state.auto ? state.moment : state.theme;
      const scenes = {
        look:{ request:"“Give it a fresh spring feel.”", title:"A fresh look. A familiar place.", story:"A fresh palette, a seasonal greeting and a few thoughtful details. The same app can feel a little more like your world.", changes:{}, facts:[["Look","Spring"],["Voice","Natural"],["Language","English"]] },
        voice:{ request:"“Speak with a little old-world charm.”", title:"The same thought. A different voice.", story:"From a casual hello to a polished briefing—or a turn of phrase from another era. Familiar information, expressed your way.", changes:{tone:"period",personality:"formal"}, facts:[["Voice","Another era"],["Typography","Refined"],["Meaning","Preserved"]] },
        language:{ request:"“Take me somewhere words don’t exist yet.”", title:"Beyond borders. Even imagined ones.", story:"A familiar language can make an app feel like home. This invented language, Lunari, explores how a fictional world could feel at home too.", changes:{language:"lunari",theme:"custom",color:"#7037e5"}, facts:[["Language","Lunari · invented"],["Content","Prepared example"],["Garden tasks","The same three"]] },
        comfort:{ request:"“Bigger text. Clear contrast. One thing at a time.”", title:"Your comfort comes first.", story:"Reading preferences and a simpler flow can work together. A useful step toward an accessible experience, supported by careful product design and testing.", changes:{large:true,contrast:true,simple:true}, facts:[["Text","Larger"],["Contrast","Black & white"],["Layout","One task at a time"]] },
        personality:{ request:"“Make it bold. And a little more me.”", title:"A little character. A lot of you.", story:"More energy in the typography. A color you love. A playful voice. Your preferences can combine into an experience that feels like yours.", changes:{theme:"custom",color:"#a5297b",personality:"bold",tone:"social"}, facts:[["Personality","Bold"],["Voice","Social"],["Palette","Personal"]] },
        moment:{ request:"“Let it feel like the festive season.”", title:"Life moves. Your app can too.", story:"When you choose to let it, the look can follow a season or celebration. Preview different moments below while keeping your other preferences.", changes:{auto:true,moment:"christmas"}, facts:[["Preview date","December 25"],["Theme","Christmas"],["Seasonal changes","User-enabled"]] }
      };
      let heroScene = "look";
      let heroState = {...base};
      let demoState = {...base};
      const history = [];
      const heroShell = document.getElementById("hero-shell");
      const demoShell = document.getElementById("demo-shell");
      const undoButton = document.getElementById("undo-demo");
      const resetButton = document.getElementById("reset-demo");
      const leaf = '<svg class="icon" aria-hidden="true"><use href="#i-leaf"/></svg>';
      const lock = '<svg class="icon" aria-hidden="true"><use href="#i-lock"/></svg>';

      function inkFor(hex) {
        const rgb = hex.slice(1).match(/../g).map(v => parseInt(v,16)/255).map(v => v <= .04045 ? v/12.92 : Math.pow((v+.055)/1.055,2.4));
        const l = rgb[0]*.2126 + rgb[1]*.7152 + rgb[2]*.0722;
        return (l+.05)/.05 >= 1.05/(l+.05) ? "#000000" : "#ffffff";
      }
      function appMarkup(state) {
        const w = words[state.language], t = toneIndex(state.tone);
        const selectedTheme = effectiveTheme(state);
        const theme = ["spring","halloween","christmas","custom"].indexOf(selectedTheme);
        const seasonal = seasonalCopy[state.language][selectedTheme];
        const [title, intro] = seasonal ? seasonal.lines[t] : [w.title[t], w.intro[t]];
        const kicker = seasonal ? seasonal.kicker : w.kicker[t];
        const icons = seasonalIcons[selectedTheme] || [];
        const step = state.step % taskIds.length;
        const content = state.simple
          ? `<div class="app-card guided" data-task-id="${taskIds[step]}"><span class="pill">${escapeText(w.step)} ${step+1} ${escapeText(w.of)} 3</span><h4>${escapeText(w.names[step])}</h4><p><strong>${escapeText(w.ops[step])}</strong></p><p>${escapeText(w.details[step])}</p><button class="app-action" type="button" data-next-step>${escapeText(step===2 ? w.back[t] : w.next[t])}${arrow}</button></div>`
          : `<div class="app-metrics">${w.metrics.map((label,i)=>`<div><strong>${[3,2,1][i]}</strong><span>${escapeText(label)}</span></div>`).join("")}</div>${taskIds.map((id,i)=>`<div class="task-row" data-task-id="${id}"><span class="task-title">${escapeText(w.names[i])}</span><span>${escapeText(w.ops[i])}</span></div>`).join("")}`;
        return `<div class="app-topbar"><span class="app-name">${leaf}GardenMate</span><span class="pill accent">${icons[0] ? seasonIcon(icons[0]) : ""}${escapeText(w.theme[theme])}</span></div><div class="app-tabs">${w.nav.map((v,i)=>`<span${i===0?' class="selected"':""}>${escapeText(v)}</span>`).join("")}</div><div class="app-canvas"><div class="app-kicker">${icons[1] ? seasonIcon(icons[1]) : ""}<span>${escapeText(kicker)}</span></div><h3>${escapeText(title)}</h3><p>${escapeText(intro)}</p>${content}<p class="app-read-note">${escapeText(w.note)}</p></div><div class="app-footer">${lock}<span>${escapeText(w.footer)}</span></div>`;
      }
      function paintApp(shell,state,animate=true) {
        shell.dataset.theme = effectiveTheme(state);
        shell.dataset.personality = state.personality;
        shell.classList.toggle("is-large",state.large);
        shell.classList.toggle("is-contrast",state.contrast);
        shell.lang = words[state.language].lang;
        shell.style.setProperty("--custom-accent",state.color);
        shell.style.setProperty("--custom-ink",inkFor(state.color));
        shell.style.setProperty("--custom-bg",state.color+"09");
        shell.style.setProperty("--custom-tint",state.color+"16");
        shell.innerHTML = appMarkup(state);
        if(animate && !motion.matches && typeof shell.animate === "function") {
          shell.getAnimations().forEach(animation=>animation.cancel());
          shell.animate([{opacity:.7},{opacity:1}],{duration:210,easing:"ease-out"});
        }
      }
      function renderHero(announce=true) {
        const scene = scenes[heroScene];
        document.querySelectorAll("[data-hero-scene]").forEach(button=>button.setAttribute("aria-pressed",String(button.dataset.heroScene===heroScene)));
        document.getElementById("hero-request").textContent = scene.request;
        document.getElementById("hero-story-title").textContent = scene.title;
        document.getElementById("hero-story-copy").textContent = scene.story;
        document.getElementById("hero-facts").innerHTML = scene.facts.map(([k,v])=>`<div><dt>${escapeText(k)}</dt><dd>${escapeText(v)}</dd></div>`).join("");
        paintApp(heroShell,heroState,announce);
        if(announce) document.getElementById("hero-status").textContent = scene.title + " " + scene.story;
      }
      function preferenceNames(state) {
        const names = [labels.theme[effectiveTheme(state)],labels.tone[state.tone],labels.language[state.language],labels.personality[state.personality]];
        if(state.large) names.push("Larger text");
        if(state.contrast) names.push("Higher contrast");
        if(state.simple) names.push("One task at a time");
        if(state.auto) names.push("Following "+labels.moment[state.moment]);
        return names;
      }
      function renderDemo(message="",animate=true) {
        document.querySelectorAll("[data-key]").forEach(button=>{
          const key = button.dataset.key;
          button.setAttribute("aria-pressed",String((key==="theme" ? effectiveTheme(demoState) : demoState[key])===button.dataset.value));
        });
        document.querySelectorAll("[data-toggle]").forEach(input=>{input.checked = demoState[input.dataset.toggle];});
        document.getElementById("custom-color").value = demoState.color;
        document.getElementById("language-note").hidden = demoState.language!=="lunari";
        document.getElementById("active-preferences").innerHTML = preferenceNames(demoState).map(value=>`<li>${escapeText(value)}</li>`).join("");
        document.getElementById("season-note").textContent = demoState.auto ? "The theme follows this preview date. Your voice, language and comfort preferences stay in place." : "Seasonal changes are off. Your selected theme stays in place when you preview another date.";
        undoButton.disabled = history.length===0;
        resetButton.disabled = JSON.stringify(demoState)===JSON.stringify(base);
        if(message) {
          document.getElementById("decision-reason").textContent = message;
          document.getElementById("demo-status").textContent = message;
        }
        paintApp(demoShell,demoState,animate);
      }
      function changeDemo(patch,message) {
        const next = {...demoState,...patch};
        if(JSON.stringify(next)===JSON.stringify(demoState)) return;
        history.push({...demoState});
        if(history.length>40) history.shift();
        demoState=next;
        renderDemo(message);
      }
      function openEditor(name) {
        if(!["appearance","voice","language","comfort","personality","moment"].includes(name)) return;
        document.querySelectorAll("[data-editor-view]").forEach(button=>button.setAttribute("aria-pressed",String(button.dataset.editorView===name)));
        document.querySelectorAll(".control-panel").forEach(panel=>{panel.hidden = panel.id!=="panel-"+name;});
      }
      document.querySelectorAll("[data-hero-scene]").forEach(button=>button.addEventListener("click",()=>{
        const scene = button.dataset.heroScene;
        if(!Object.hasOwn(scenes,scene)) return;
        heroScene=scene;
        heroState={...base,...scenes[scene].changes};
        renderHero();
      }));
      document.querySelectorAll("[data-editor-view]").forEach(button=>button.addEventListener("click",()=>openEditor(button.dataset.editorView)));
      document.querySelectorAll("[data-open-editor]").forEach(link=>link.addEventListener("click",()=>openEditor(link.dataset.openEditor)));
      document.querySelectorAll("[data-key]").forEach(button=>{
        button.setAttribute("aria-controls","demo-shell");
        button.addEventListener("click",()=>{
          const key=button.dataset.key, value=button.dataset.value;
          if(!Object.hasOwn(labels,key)||!Object.hasOwn(labels[key],value)) return;
          const patch = {[key]:value,step:0};
          if(key==="theme") patch.auto=false;
          let message=labels[key][value]+" selected. Your other preferences stay in place.";
          if(key==="theme" && demoState.auto) message=labels.theme[value]+" selected. Seasonal changes are now off; your other preferences stay in place.";
          if(key==="moment") message=demoState.auto ? "Previewing "+labels.moment[value]+". The theme follows the moment; your other preferences stay in place." : "Previewing "+labels.moment[value]+". Turn on “Follow the moment” to change the theme with the date.";
          if(key==="language" && value==="lunari") message="Lunari selected: an invented language with prepared example text. Your other preferences stay in place.";
          if(key==="personality") message=labels.personality[value]+" styling selected. The voice and meaning of your content stay the same.";
          changeDemo(patch,message);
        });
      });
      document.querySelectorAll("[data-toggle]").forEach(input=>{
        input.setAttribute("aria-controls","demo-shell");
        input.addEventListener("change",()=>{
          const key=input.dataset.toggle;
          if(!["large","contrast","simple","auto"].includes(key)) return;
          const name={large:"Larger text",contrast:"Higher contrast",simple:"One task at a time",auto:"Seasonal changes"}[key];
          const patch = {[key]:input.checked,step:0};
          if(key==="auto"&&!input.checked) patch.theme=effectiveTheme(demoState);
          changeDemo(patch,name+(input.checked?" enabled.":" disabled.")+" Your other preferences stay in place.");
        });
      });
      document.getElementById("custom-color").addEventListener("change",event=>{
        const color=event.target.value;
        if(!/^#[0-9a-f]{6}$/i.test(color)) return;
        changeDemo({color,theme:"custom",auto:false},"Your palette selected. Text on the accent color adjusts for contrast. Your other preferences stay in place.");
      });
      undoButton.addEventListener("click",()=>{
        if(!history.length) return;
        demoState=history.pop();
        renderDemo("Your previous combination has been restored.");
        if(undoButton.disabled) document.querySelector('[data-editor-view][aria-pressed="true"]').focus({preventScroll:true});
      });
      resetButton.addEventListener("click",()=>{
        changeDemo({...base},"Back to the starting combination. You can undo this reset, too.");
        undoButton.focus({preventScroll:true});
      });
      for(const [shell,isHero] of [[heroShell,true],[demoShell,false]]) {
        shell.addEventListener("click",event=>{
          if(!(event.target instanceof Element)||!event.target.closest("[data-next-step]")) return;
          const state=isHero?heroState:demoState;
          state.step=(state.step+1)%taskIds.length;
          if(isHero) paintApp(shell,state);
          else renderDemo("Showing task "+(state.step+1)+" of 3: "+words.en.names[state.step]+".");
          shell.querySelector("[data-next-step]").focus({preventScroll:true});
          if(isHero) document.getElementById("hero-status").textContent="Showing task "+(state.step+1)+" of 3: "+words.en.names[state.step]+".";
        });
      }
      // Native buttons work with Tab, Enter and Space; arrow keys are optional shortcuts.
      document.querySelectorAll('[role="group"]').forEach(group=>group.addEventListener("keydown",event=>{
        if(!["ArrowLeft","ArrowRight","Home","End"].includes(event.key)) return;
        const buttons=[...group.querySelectorAll("button")], current=buttons.indexOf(document.activeElement);
        if(current<0) return;
        event.preventDefault();
        let next=event.key==="ArrowRight"?(current+1)%buttons.length:(current+buttons.length-1)%buttons.length;
        if(event.key==="Home") next=0;
        if(event.key==="End") next=buttons.length-1;
        buttons[next].focus();buttons[next].click();
      }));


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

      const contactLink = document.getElementById("contact-cta");
      const contactDialog = document.getElementById("contact-dialog");
      if (/^(https:\/\/|mailto:)/i.test(CONTACT_URL)) {
        contactLink.href = CONTACT_URL;
        document.getElementById("contact-details").hidden = true;
      } else if (typeof contactDialog.showModal === "function") {
        contactLink.setAttribute("aria-haspopup", "dialog");
        contactLink.addEventListener("click", event => {
          event.preventDefault();
          if (!contactDialog.open) contactDialog.showModal();
        });
      }
      document.getElementById("dialog-close").addEventListener("click", () => contactDialog.close());
      contactDialog.addEventListener("close", () => contactLink.focus({ preventScroll: true }));
      contactDialog.addEventListener("click", event => {
        if (event.target !== contactDialog) return;
        const box = contactDialog.getBoundingClientRect();
        if (event.clientX < box.left || event.clientX > box.right || event.clientY < box.top || event.clientY > box.bottom) contactDialog.close();
      });

      renderHero(false);
      renderDemo("", false);
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
        observer.observe(document.getElementById("architecture-flow"));
        motion.addEventListener("change", event => {
          if (!event.matches) return;
          document.querySelectorAll(".reveal.pending").forEach(element => element.classList.remove("pending"));
          observer.disconnect();
          document.getAnimations().forEach(animation => animation.cancel());
        });
      }

    })();
