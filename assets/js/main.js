(function () {
  const data = window.VisitTemajukData;
  const body = document.body;
  const page = body.dataset.page;
  const root = body.dataset.root || ".";

  const pageConfig = {
    popularPlaces: {
      title: "Popular Places",
      route: "popular-places",
      intro: data.site.popularIntro,
      detailLabel: "Popular Places",
      relatedTitle: "Other Popular Places",
      relatedCtaLabel: "See More Places",
    },
    stays: {
      title: "Places To Stay",
      route: "places-to-stay",
      intro: data.site.stayIntro,
      detailLabel: "Places To Stay",
      relatedTitle: "Other Places To Stay",
      relatedCtaLabel: "See More Stays",
    },
    news: {
      title: "News of Temajuk",
      route: "news",
      intro: data.site.newsIntro,
      detailLabel: "News of Temajuk",
      relatedTitle: "Other News",
      relatedCtaLabel: "See More News",
    },
  };

  function esc(value) {
    return String(value || "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function visitorText(value) {
    return String(value || "")
      .replace(/Description needs verification from the original source\./gi, "Visit Temajuk reference entry.")
      .replace(/that needs further source verification/gi, "from the Visit Temajuk reference")
      .replace(/that needs further verification/gi, "from the Visit Temajuk reference")
      .replace(/,?\s*and needs full source verification/gi, "")
      .replace(/More detailed copy needs verification from the original source before publication\./gi, "")
      .replace(/Accommodation detail content needs verification from the original source before publication\./gi, "")
      .replace(/Full article content needs verification from the original source before publication\./gi, "")
      .replace(/Details need verification from the original source before publication\./gi, "")
      .replace(/\s{2,}/g, " ")
      .trim();
  }

  function visitorParagraphs(value) {
    return String(value || "")
      .split("\\n\\n")
      .map(visitorText)
      .filter(Boolean);
  }

  function href(target) {
    if (target === "index.html") return root === "." ? "index.html" : `${root}/index.html`;
    return root === "." ? target : `${root}/${target}`;
  }

  function detailHref(route, slug) {
    return href(`${route}/detail.html?slug=${encodeURIComponent(slug)}`);
  }

  function routeBaseHref(route) {
    return href(`${route}/index.html`);
  }

  function attrJson(value) {
    return esc(JSON.stringify(value || []));
  }

  function categoryBadge(item, route) {
    const fallback = route === "news" ? "News" : route === "places-to-stay" ? "Stay" : "Destination";
    const category = item.category || fallback;
    const tone = route === "news" ? "story" : route === "places-to-stay" ? "stay" : "place";
    return `<span class="category-badge category-${tone}"><span></span>${esc(category)}</span>`;
  }

  function visualPanel(item, ratioClass) {
    return `
      <div class="visual-panel tone-${esc(item.tone || "forest")} ${ratioClass || ""}" role="img" aria-label="${esc(item.title)} visual">
        <div class="visual-grid" aria-hidden="true"></div>
        <div class="visual-line" aria-hidden="true"></div>
      </div>
    `;
  }

  function card(item, route, variant) {
    return `
      <a class="content-card ${variant ? `card-variant-${variant}` : ""}" href="${detailHref(route, item.slug)}">
        <div class="card-media-wrap">${visualPanel(item, "ratio-card")}</div>
        <div class="card-body">
          ${categoryBadge(item, route)}
          <h3>${esc(item.title)}</h3>
          <p>${esc(visitorText(item.excerpt))}</p>
          <span class="card-action">Explore <span aria-hidden="true">-></span></span>
        </div>
      </a>
    `;
  }

  function sectionHeader({ eyebrow, title, intro, cta, light }) {
    return `
      <div class="section-header ${light ? "section-header-light" : ""}">
        <div>
          <div class="eyebrow-row">
            <span></span>
            <p>${esc(eyebrow)}</p>
          </div>
          <h2>${esc(title)}</h2>
          ${intro ? `<p class="section-intro">${esc(intro)}</p>` : ""}
        </div>
        ${
          cta
            ? `<a class="button button-${light ? "ghost-light" : "dark"}" href="${href(cta.href)}">${esc(cta.label)} <span aria-hidden="true">-></span></a>`
            : ""
        }
      </div>
    `;
  }

  function carousel(id, items, route) {
    return `
      <div class="carousel" data-carousel="${esc(id)}">
        <button class="carousel-control carousel-control-prev" type="button" data-dir="-1" aria-label="Previous slide">
          <span aria-hidden="true">&lt;</span>
        </button>
        <div class="carousel-viewport">
          <div class="carousel-track" tabindex="0">
            ${items.map((item) => `<div class="carousel-slide">${card(item, route, "carousel")}</div>`).join("")}
          </div>
        </div>
        <button class="carousel-control carousel-control-next" type="button" data-dir="1" aria-label="Next slide">
          <span aria-hidden="true">&gt;</span>
        </button>
        <div class="carousel-status" aria-live="polite">1 / ${items.length}</div>
      </div>
    `;
  }

  function newsFeatureSlide(item) {
    return `
      <div class="news-feature-grid">
        <div class="reveal">
          <div class="eyebrow-row">
            <span></span>
            <p>News of Temajuk</p>
          </div>
          <h2>${esc(item.title)}</h2>
          ${categoryBadge(item, "news")}
          <p>${esc(visitorText(item.excerpt))}</p>
          <div class="news-feature-actions">
            <a class="button button-orange" href="${detailHref("news", item.slug)}">Read full story <span aria-hidden="true">-></span></a>
            <a class="button button-ghost-light" href="${routeBaseHref("news")}">See More News <span aria-hidden="true">-></span></a>
          </div>
        </div>
        <div class="news-visual reveal">
          ${visualPanel(item, "ratio-feature")}
        </div>
      </div>
    `;
  }

  function newsFeatureCarousel(items) {
    return `
      <div class="carousel news-feature-carousel" data-carousel="news">
        <button class="carousel-control carousel-control-prev" type="button" data-dir="-1" aria-label="Previous news">
          <span aria-hidden="true">&lt;</span>
        </button>
        <div class="carousel-viewport">
          <div class="carousel-track" tabindex="0">
            ${items.map((item) => `<div class="carousel-slide">${newsFeatureSlide(item)}</div>`).join("")}
          </div>
        </div>
        <button class="carousel-control carousel-control-next" type="button" data-dir="1" aria-label="Next news">
          <span aria-hidden="true">&gt;</span>
        </button>
        <div class="carousel-status" aria-live="polite">1 / ${items.length}</div>
      </div>
    `;
  }

  function stayShowcase(items) {
    const featured = items[0];
    const supporting = items.slice(1, 4);
    return `
      <div class="stay-showcase">
        <a class="stay-feature-card" href="${detailHref("places-to-stay", featured.slug)}">
          <div class="stay-feature-visual">${visualPanel(featured, "ratio-stay-feature")}</div>
          <div class="stay-feature-copy">
            ${categoryBadge(featured, "places-to-stay")}
            <h3>${esc(featured.title)}</h3>
            <p>${esc(visitorText(featured.excerpt))}</p>
            <span class="card-action">Explore <span aria-hidden="true">-></span></span>
          </div>
        </a>
        <div class="stay-rail">
          ${supporting
            .map(
              (item) => `
                <a class="stay-rail-card" href="${detailHref("places-to-stay", item.slug)}">
                  <div class="stay-rail-visual">${visualPanel(item, "ratio-stay-rail")}</div>
                  <span>
                    ${categoryBadge(item, "places-to-stay")}
                    <strong>${esc(item.title)}</strong>
                    <small>${esc(visitorText(item.excerpt))}</small>
                  </span>
                </a>
              `,
            )
            .join("")}
        </div>
      </div>
    `;
  }

  function pageHero({ eyebrow, title, intro, size }) {
    return `
      <section class="page-hero ${size === "md" ? "page-hero-md" : ""}">
        <div class="hero-pattern" aria-hidden="true"></div>
        <div class="container page-hero-inner reveal">
          ${eyebrow ? `<p class="page-eyebrow">${esc(eyebrow)}</p>` : ""}
          <h1>${esc(title)}</h1>
          ${intro ? `<p>${esc(intro)}</p>` : ""}
        </div>
      </section>
    `;
  }

  function renderHeader() {
    const current = body.dataset.route || (page === "home" ? "home" : page === "travel" ? "how-to-get-there" : "");
    document.getElementById("site-header").innerHTML = `
      <header class="site-header">
        <div class="container header-inner">
          <a class="brand" href="${href("index.html")}" aria-label="Visit Temajuk Home">
            <span aria-hidden="true"></span>
            <strong>${esc(data.site.brand)}</strong>
          </a>
          <nav class="desktop-nav" aria-label="Primary navigation">
            ${data.site.nav
              .map((item) => {
                const active = item.route === current;
                return `<a class="${active ? "active" : ""}" href="${href(item.href)}">${esc(item.label)}</a>`;
              })
              .join("")}
          </nav>
          <div class="header-actions">
            <button class="admin-button" type="button">Admin</button>
            <div class="language-toggle" aria-label="Language switch">
              <button class="active" type="button">EN</button>
              <button type="button">ID</button>
            </div>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu">
              <span></span><span></span>
            </button>
          </div>
        </div>
        <nav id="mobile-menu" class="mobile-nav" aria-label="Mobile navigation">
          ${data.site.nav
            .map((item) => `<a class="${item.route === current ? "active" : ""}" href="${href(item.href)}">${esc(item.label)}</a>`)
            .join("")}
          <div class="mobile-nav-actions">
            <button class="admin-button" type="button">Admin</button>
            <div class="language-toggle" aria-label="Language switch">
              <button class="active" type="button">EN</button>
              <button type="button">ID</button>
            </div>
          </div>
        </nav>
      </header>
    `;
  }

  function renderFooter() {
    document.getElementById("site-footer").innerHTML = `
      <footer class="site-footer">
        <div class="footer-glow" aria-hidden="true"></div>
        <div class="container footer-grid">
          <div>
            <a class="brand footer-brand" href="${href("index.html")}">
              <span aria-hidden="true"></span>
              <strong>${esc(data.site.brand)}</strong>
            </a>
            <h3>Company Info</h3>
            <p>${esc(data.site.footerInfo)}</p>
          </div>
          <div>
            <h3>Contacts</h3>
            <ul class="footer-list">
              <li>${esc(data.site.contact.phone)}</li>
              <li>${esc(data.site.contact.location)}</li>
              <li>${esc(data.site.contact.hours)}</li>
            </ul>
          </div>
          <div>
            <h3>ICCS Collaborated Program</h3>
            <ul class="partner-grid">
              ${data.site.partners.map((partner) => `<li>${esc(partner)}</li>`).join("")}
            </ul>
          </div>
        </div>
        <div class="footer-bottom">${esc(data.site.copyright)}</div>
      </footer>
    `;
  }

  function renderHome() {
    const app = document.getElementById("app");
    const heroVariants = Array.isArray(data.site.hero.typewriterVariants) && data.site.hero.typewriterVariants.length
      ? data.site.hero.typewriterVariants
      : [data.site.hero.title];
    app.innerHTML = `
      <section class="home-hero">
        <div class="hero-pattern" aria-hidden="true"></div>
        <div class="hero-motion-layer" aria-hidden="true">
          <span class="hero-sweep hero-sweep-one"></span>
          <span class="hero-sweep hero-sweep-two"></span>
          <span class="hero-sheen"></span>
        </div>
        <div class="container home-hero-inner">
          <div class="hero-copy reveal">
            <p class="hero-eyebrow">${esc(data.site.hero.eyebrow)}</p>
            <h1 class="hero-title" data-typewriter-text="${esc(data.site.hero.title)}" data-typewriter-variants="${attrJson(heroVariants)}" data-typewriter-current="${esc(data.site.hero.title)}" data-typewriter-loop="true" aria-label="${esc(data.site.hero.title)}">
              <span class="hero-title-fallback">${esc(data.site.hero.title)}</span>
              <span class="hero-typewriter-layer" aria-hidden="true">
                <span class="hero-typewriter-output"></span><span class="hero-typewriter-caret"></span>
              </span>
            </h1>
            <span class="hero-rule"></span>
            <p>${esc(data.site.hero.body)}</p>
            <div class="hero-actions">
              <a class="button button-orange" href="${routeBaseHref("popular-places")}">Explore Popular Places <span aria-hidden="true">-></span></a>
              <a class="button button-ghost-light" href="${routeBaseHref("how-to-get-there")}">How To Get There</a>
            </div>
          </div>
          <div class="hero-visual reveal">
            <div class="hero-visual-glow" aria-hidden="true"></div>
            ${visualPanel({ title: "Visit Temajuk", tone: "teal" }, "ratio-hero")}
            <span class="location-pill">Sambas, West Kalimantan</span>
          </div>
        </div>
      </section>

      <section class="section surface section-shell section-shell-popular">
        <div class="section-ambient" aria-hidden="true"></div>
        <div class="container">
          ${sectionHeader({
            eyebrow: "Popular Places",
            title: "Where Temajuk reveals itself",
            intro: data.site.popularIntro,
            cta: { href: "popular-places/index.html", label: "See more places" },
          })}
          ${carousel("popular", data.popularPlaces, "popular-places")}
        </div>
      </section>

      <section class="section surface-alt section-shell section-shell-stays">
        <div class="section-ambient" aria-hidden="true"></div>
        <div class="container">
          ${sectionHeader({
            eyebrow: "Places To Stay",
            title: "Rest close to the coast",
            intro: data.site.stayIntro,
            cta: { href: "places-to-stay/index.html", label: "See more" },
          })}
          ${stayShowcase(data.stays)}
        </div>
      </section>

      <section class="section news-feature section-shell section-shell-news">
        <div class="section-ambient" aria-hidden="true"></div>
        <div class="container">
          ${newsFeatureCarousel(data.news)}
        </div>
      </section>

      <section class="section surface-alt travel-teaser section-shell section-shell-travel">
        <div class="section-ambient" aria-hidden="true"></div>
        <div class="container travel-teaser-grid">
          <div class="reveal">
            <div class="eyebrow-row">
              <span></span>
              <p>How To Get There</p>
            </div>
            <h2>Plan your route to Temajuk</h2>
            <p>Layered travel information for your journey to Temajuk - via Pontianak or Kuching, including map view and border information.</p>
            <a class="button button-dark" href="${routeBaseHref("how-to-get-there")}">See full guide <span aria-hidden="true">-></span></a>
          </div>
          <div class="travel-teaser-list reveal">
            ${data.travelGuide
              .map(
                (item) => `
                  <a class="travel-link-card" href="${routeBaseHref("how-to-get-there")}">
                    <span>
                      <strong>${esc(item.title)}</strong>
                      <small>${item.layout === "routes" ? "Routes via Pontianak and Kuching" : item.layout === "map" ? "Map view and QR code" : "Departure and arrival information"}</small>
                    </span>
                    <span aria-hidden="true">-></span>
                  </a>
                `,
              )
              .join("")}
          </div>
        </div>
      </section>
    `;
  }

  function renderListing() {
    const collectionName = body.dataset.collection;
    const config = pageConfig[collectionName];
    const items = data[collectionName] || [];
    body.dataset.route = config.route;
    document.title = `${config.title} - Visit Temajuk`;
    document.getElementById("app").innerHTML = `
      ${pageHero({ title: config.title, intro: config.intro })}
      <section class="section listing-section">
        <div class="container">
          <div class="paginated-list" data-page-size="6">
            <div class="card-grid" data-pagination-items>
              ${items.map((item) => card(item, config.route, "grid")).join("")}
            </div>
            <nav class="pagination" aria-label="${esc(config.title)} pagination">
              <button type="button" data-page-prev aria-label="Previous page">&lt;</button>
              <span data-page-status>Page 1 of 1</span>
              <button type="button" data-page-next aria-label="Next page">&gt;</button>
            </nav>
          </div>
        </div>
      </section>
    `;
  }

  function findCurrentItem(items) {
    const params = new URLSearchParams(window.location.search);
    const slug = params.get("slug");
    return items.find((item) => item.slug === slug) || items[0];
  }

  function renderDetail() {
    const collectionName = body.dataset.collection;
    const config = pageConfig[collectionName];
    const items = data[collectionName] || [];
    const item = findCurrentItem(items);
    const related = items.filter((candidate) => candidate.slug !== item.slug);
    body.dataset.route = config.route;
    document.title = `${item.title} - ${config.title} - Visit Temajuk`;
    document.getElementById("app").innerHTML = `
      ${pageHero({ eyebrow: config.detailLabel, title: item.title, size: "md" })}
      <section class="detail-shell">
        <div class="container">
          <article class="detail-card reveal">
            <div class="detail-media">${visualPanel(item, "ratio-detail")}</div>
            <div class="detail-copy">
              ${categoryBadge(item, config.route)}
              <h2>${esc(item.title)}</h2>
              <p>${esc(visitorText(item.excerpt))}</p>
              ${visitorParagraphs(item.body)
                .map((paragraph) => `<p>${esc(paragraph)}</p>`)
                .join("")}
            </div>
          </article>
          <div class="back-row">
            <a class="button button-outline" href="${routeBaseHref(config.route)}"><span aria-hidden="true">&lt;-</span> Back to listing</a>
          </div>
        </div>
      </section>
      <section class="section related-section surface-alt">
        <div class="container">
          ${sectionHeader({
            eyebrow: config.detailLabel,
            title: config.relatedTitle,
            intro: related.length ? "Continue exploring related Visit Temajuk content." : "No related content is available yet.",
            cta: { href: `${config.route}/index.html`, label: config.relatedCtaLabel },
          })}
          ${
            related.length
              ? `
                <div class="paginated-list related-pagination" data-page-size-desktop="3" data-page-size-tablet="2" data-page-size-mobile="1">
                  <div class="related-grid" data-pagination-items>
                    ${related.map((candidate) => card(candidate, config.route, "compact")).join("")}
                  </div>
                  <nav class="pagination" aria-label="${esc(config.relatedTitle)} pagination">
                    <button type="button" data-page-prev aria-label="Previous related page">&lt;</button>
                    <span data-page-status>Page 1 of 1</span>
                    <button type="button" data-page-next aria-label="Next related page">&gt;</button>
                  </nav>
                </div>
              `
              : ""
          }
        </div>
      </section>
    `;
  }

  function routeCard(route) {
    return `
      <article class="route-card">
        <dl>
          <div><dt>Time</dt><dd>${esc(route.time)}</dd></div>
          <div><dt>Distance</dt><dd>${esc(route.distance)}</dd></div>
          <div class="full"><dt>Route</dt><dd>${esc(route.route)}</dd></div>
          <div><dt>Transport</dt><dd>${esc(route.transport)}</dd></div>
        </dl>
        <button class="button button-dark" type="button">Read More</button>
      </article>
    `;
  }

  function travelPanel(item, index) {
    if (item.layout === "routes") {
      return `
        <div class="nested-accordion">
          ${item.groups
            .map(
              (group, groupIndex) => `
                <article class="accordion-item nested ${groupIndex === 0 ? "is-open" : ""}">
                  <button class="accordion-trigger" type="button" aria-expanded="${groupIndex === 0 ? "true" : "false"}">
                    <span>${esc(group.title)}</span>
                    <span aria-hidden="true"></span>
                  </button>
                  <div class="accordion-panel">
                    <div class="route-card-list">
                      ${group.routes.map(routeCard).join("")}
                    </div>
                  </div>
                </article>
              `,
            )
            .join("")}
        </div>
      `;
    }
    if (item.layout === "map") {
      return `
        <div class="travel-info-panel">
          <p>${esc(item.intro)}</p>
          <div class="map-grid">
            <div class="map-art" role="img" aria-label="Temajuk map view">
              <span class="map-pin"></span>
              <strong>Temajuk Map View</strong>
            </div>
            <div class="qr-art" role="img" aria-label="QR code">
              <span></span><span></span><span></span><span></span>
              <strong>QR Code</strong>
            </div>
          </div>
        </div>
      `;
    }
    return `
      <div class="travel-info-panel">
        <p>${esc(item.intro)}</p>
        <div class="poster-grid">
          ${item.posters
            .map(
              (poster) => `
                <article class="poster-card">
                  <h3>${esc(poster)}</h3>
                  <div class="poster-art" role="img" aria-label="${esc(poster)} information poster">
                    <span></span><span></span><span></span><span></span>
                  </div>
                </article>
              `,
            )
            .join("")}
        </div>
      </div>
    `;
  }

  function renderTravel() {
    body.dataset.route = "how-to-get-there";
    document.getElementById("app").innerHTML = `
      ${pageHero({ title: "How To Get There", intro: "Layered travel information for your journey to Temajuk.", size: "md" })}
      <section class="section travel-section section-shell">
        <div class="section-ambient" aria-hidden="true"></div>
        <div class="container travel-container">
          <div class="accordion-list">
            ${data.travelGuide
              .map(
                (item, index) => `
                  <article class="accordion-item ${index === 0 ? "is-open" : ""}">
                    <button class="accordion-trigger" type="button" aria-expanded="${index === 0 ? "true" : "false"}">
                      <span>${esc(item.title)}</span>
                      <span aria-hidden="true"></span>
                    </button>
                    <div class="accordion-panel">
                      ${travelPanel(item, index)}
                    </div>
                  </article>
                `,
              )
              .join("")}
          </div>
        </div>
      </section>
    `;
  }

  function initMobileMenu() {
    const button = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".mobile-nav");
    if (!button || !menu) return;
    button.addEventListener("click", () => {
      const open = menu.classList.toggle("is-open");
      button.classList.toggle("is-open", open);
      button.setAttribute("aria-expanded", String(open));
      button.setAttribute("aria-label", open ? "Close menu" : "Open menu");
      document.body.classList.toggle("menu-open", open);
    });
  }

  function initCarousel() {
    document.querySelectorAll(".carousel").forEach((carouselEl) => {
      const track = carouselEl.querySelector(".carousel-track");
      const slides = Array.from(carouselEl.querySelectorAll(".carousel-slide"));
      const status = carouselEl.querySelector(".carousel-status");
      const controls = carouselEl.querySelectorAll(".carousel-control");
      if (!track || !slides.length) return;

      const update = () => {
        const first = slides[0];
        const gap = parseFloat(getComputedStyle(track).columnGap || "0");
        const step = first.getBoundingClientRect().width + gap;
        const atStart = track.scrollLeft <= 4;
        const atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
        const current = atEnd && !atStart
          ? slides.length
          : step
            ? Math.min(slides.length, Math.max(1, Math.round(track.scrollLeft / step) + 1))
            : 1;
        if (status) status.textContent = `${current} / ${slides.length}`;
        controls.forEach((control) => {
          const dir = Number(control.dataset.dir || "1");
          control.disabled = dir < 0 ? atStart : atEnd;
        });
      };

      controls.forEach((control) => {
        control.addEventListener("click", () => {
          const first = slides[0];
          const gap = parseFloat(getComputedStyle(track).columnGap || "0");
          const step = first.getBoundingClientRect().width + gap;
          const dir = Number(control.dataset.dir || "1");
          const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
          carouselEl.dataset.motionDir = dir > 0 ? "next" : "prev";
          carouselEl.classList.add("is-animating");
          window.clearTimeout(carouselEl._motionTimer);
          track.scrollBy({ left: dir * step, behavior: reduceMotion ? "auto" : "smooth" });
          carouselEl._motionTimer = window.setTimeout(() => {
            carouselEl.classList.remove("is-animating");
            delete carouselEl.dataset.motionDir;
          }, reduceMotion ? 0 : 560);
        });
      });

      track.addEventListener("scroll", () => requestAnimationFrame(update), { passive: true });
      window.addEventListener("resize", update);
      update();
    });
  }

  function initPagination() {
    document.querySelectorAll(".paginated-list").forEach((list) => {
      const items = Array.from(list.querySelectorAll("[data-pagination-items] > *"));
      const prev = list.querySelector("[data-page-prev]");
      const next = list.querySelector("[data-page-next]");
      const status = list.querySelector("[data-page-status]");
      let current = 1;
      let pageSize = 1;
      let total = 1;

      const getPageSize = () => {
        if (window.matchMedia("(max-width: 720px)").matches && list.dataset.pageSizeMobile) {
          return Number(list.dataset.pageSizeMobile);
        }
        if (window.matchMedia("(max-width: 1100px)").matches && list.dataset.pageSizeTablet) {
          return Number(list.dataset.pageSizeTablet);
        }
        if (list.dataset.pageSizeDesktop) return Number(list.dataset.pageSizeDesktop);
        return Number(list.dataset.pageSize || "6");
      };

      const update = () => {
        pageSize = Math.max(1, getPageSize());
        total = Math.max(1, Math.ceil(items.length / pageSize));
        current = Math.min(current, total);
        items.forEach((item, index) => {
          const visible = index >= (current - 1) * pageSize && index < current * pageSize;
          item.hidden = !visible;
        });
        if (status) status.textContent = `Page ${current} of ${total}`;
        if (prev) prev.disabled = current === 1;
        if (next) next.disabled = current === total;
      };

      if (prev) prev.addEventListener("click", () => {
        current = Math.max(1, current - 1);
        update();
      });
      if (next) next.addEventListener("click", () => {
        current = Math.min(total, current + 1);
        update();
      });
      window.addEventListener("resize", update);
      update();
    });
  }

  function initAccordion() {
    document.querySelectorAll(".accordion-trigger").forEach((trigger) => {
      trigger.addEventListener("click", () => {
        const item = trigger.closest(".accordion-item");
        const open = !item.classList.contains("is-open");
        const topLevelList = item.parentElement?.classList.contains("accordion-list") ? item.parentElement : null;
        if (open && topLevelList) {
          Array.from(topLevelList.children).forEach((sibling) => {
            if (sibling === item || !sibling.classList.contains("accordion-item")) return;
            sibling.classList.remove("is-open");
            sibling.querySelector(":scope > .accordion-trigger")?.setAttribute("aria-expanded", "false");
          });
        }
        item.classList.toggle("is-open", open);
        trigger.setAttribute("aria-expanded", String(open));
      });
    });
  }

  function initReveal() {
    const elements = document.querySelectorAll(".reveal, .content-card, .route-card, .poster-card");
    if (!("IntersectionObserver" in window)) {
      elements.forEach((el) => el.classList.add("is-visible"));
      return;
    }
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 },
    );
    elements.forEach((el) => observer.observe(el));
  }

  function initHeroTypewriter() {
    const title = document.querySelector(".hero-title[data-typewriter-text]");
    if (!title) return;
    const output = title.querySelector(".hero-typewriter-output");
    let variants = [];
    try {
      variants = JSON.parse(title.dataset.typewriterVariants || "[]").filter(Boolean);
    } catch {
      variants = [];
    }
    if (!variants.length && title.dataset.typewriterText) variants = [title.dataset.typewriterText];
    if (!output || !variants.length) return;

    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
    if (reduceMotion.matches) {
      title.dataset.typewriterCurrent = variants[0];
      output.textContent = variants[0];
      return;
    }

    let index = 0;
    let variantIndex = 0;
    let currentText = variants[variantIndex];
    const readableRestartIndex = (value) => {
      if (value.includes(" - ")) return value.indexOf(" - ");
      const words = value.trim().split(/\s+/);
      if (words.length > 4) return words.slice(0, 4).join(" ").length;
      return Math.min(24, value.length);
    };
    let restartIndex = readableRestartIndex(currentText);
    const typeDelay = (current) => {
      if (/[-–—]/.test(current)) return 120;
      if (/[,.]/.test(current)) return 70;
      if (/\s/.test(current)) return 26;
      return 34;
    };
    const deleteDelay = (current) => {
      if (/[-–—]/.test(current)) return 52;
      if (/\s/.test(current)) return 16;
      return 22;
    };
    const schedule = (callback, delay) => {
      window.clearTimeout(title._typewriterTimer);
      title._typewriterTimer = window.setTimeout(callback, delay);
    };

    const typeStep = () => {
      title.classList.remove("is-typewriter-deleting");
      title.dataset.typewriterCurrent = currentText;
      output.textContent = currentText.slice(0, index);
      if (index >= currentText.length) {
        title.classList.add("is-typewriter-complete");
        schedule(deleteStep, 2600);
        return;
      }
      const current = currentText[index] || "";
      index += 1;
      schedule(typeStep, typeDelay(current));
    };
    const deleteStep = () => {
      title.classList.add("is-typewriter-deleting");
      title.classList.remove("is-typewriter-complete");
      title.dataset.typewriterCurrent = currentText;
      output.textContent = currentText.slice(0, index);
      if (index <= restartIndex) {
        variantIndex = (variantIndex + 1) % variants.length;
        currentText = variants[variantIndex];
        title.dataset.typewriterCurrent = currentText;
        restartIndex = readableRestartIndex(currentText);
        index = Math.min(1, currentText.length);
        output.textContent = currentText.slice(0, index);
        title.classList.remove("is-typewriter-deleting");
        schedule(typeStep, 220);
        return;
      }
      index -= 1;
      const current = currentText[index] || "";
      schedule(deleteStep, deleteDelay(current));
    };

    title.classList.add("is-typewriter-active");
    title._typewriterTimer = window.setTimeout(typeStep, 260);
  }

  renderHeader();
  renderFooter();
  if (page === "home") renderHome();
  if (page === "listing") renderListing();
  if (page === "detail") renderDetail();
  if (page === "travel") renderTravel();
  initMobileMenu();
  initCarousel();
  initPagination();
  initAccordion();
  initHeroTypewriter();
  initReveal();
})();
