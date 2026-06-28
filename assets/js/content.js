(function (root) {
  function extendCollection(baseItems, options) {
    const output = [...baseItems];
    let index = 0;
    while (output.length < options.target) {
      const source = baseItems[index % baseItems.length];
      const number = String(output.length + 1).padStart(2, "0");
      output.push({
        ...source,
        slug: `${options.slugPrefix}-${number}`,
        title: `${options.titlePrefix} ${number}`,
        excerpt: source.excerpt,
        body: source.body || "Details need verification from the original source before publication.",
        status: "needs-verification",
        category: options.categories[index % options.categories.length],
        tone: options.tones[index % options.tones.length],
        verificationNote: "Details need verification from the original source before publication.",
      });
      index += 1;
    }
    return output;
  }

  root.VisitTemajukData = {
    site: {
      brand: "Visit Temajuk",
      nav: [
        { label: "Home", route: "home", href: "index.html" },
        { label: "Popular Places", route: "popular-places", href: "popular-places/index.html" },
        { label: "Places To Stay", route: "places-to-stay", href: "places-to-stay/index.html" },
        { label: "News of Temajuk", route: "news", href: "news/index.html" },
        { label: "How To Get There", route: "how-to-get-there", href: "how-to-get-there/index.html" },
      ],
      hero: {
        eyebrow: "Your Gateway to Kalimantan's Charm",
        title: "\"Discover Desa Temajuk Sambas - Unveil Indonesia's Hidden Gem\"",
        typewriterVariants: [
          "\"Discover Desa Temajuk Sambas - Unveil Indonesia's Hidden Gem\"",
          "\"Explore Temajuk's Coast, Stays, Stories, and Travel Routes\"",
          "\"Plan Your Journey to Desa Temajuk on West Kalimantan's Northern Tip\"",
        ],
        body: "A coastal village on the northern tip of West Kalimantan, bordering Sarawak, Malaysia. Explore popular places, stays, stories, and travel routes in one tourism guide.",
      },
      popularIntro:
        "Temajuk Village is located in Sambas Regency, West Kalimantan, and is known as one of the tourist destinations that is still natural and rarely touched.",
      stayIntro:
        "Find the best places to stay in Temajuk Village. Enjoy your stay with great amenities and unforgettable experiences.",
      newsIntro:
        "Stories and information from the original Visit Temajuk reference.",
      footerInfo:
        "Temajuk Village is one of the main tourist destinations in Sambas Regency which also borders directly with Malaysia.",
      contact: {
        phone: "+6281217741889",
        location: "Temajuk, Sambas Kalimantan",
        hours: "Senin, 08:00 - Sabtu 18:00",
      },
      partners: [
        "Telkom University",
        "iCATS University College",
        "Politeknik Sambas",
        "Univ Panca Bhakti",
        "ICCS",
      ],
      copyright: "(c) 2024 Visit Temajuk Village. All rights reserved.",
    },
    popularPlaces: extendCollection([
      {
        slug: "temajuk-top-300",
        title: "Temajuk is the top 300",
        excerpt: "Temajuk is a village located in Paloh District, Sambas Regency.",
        body: "More detailed copy needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Village",
        tone: "amber",
        verificationNote:
          "Title and short excerpt are visible in the original reference. Full detail copy still needs verification.",
      },
      {
        slug: "monument",
        title: "Monument",
        excerpt: "Description needs verification from the original source.",
        body: "More detailed copy needs verification from the original source before publication.",
        status: "needs-verification",
        category: "Landmark",
        tone: "forest",
        verificationNote:
          "The place name is visible in the reference. Description and image are not final.",
      },
      {
        slug: "teluk-atong",
        title: "Teluk Atong",
        excerpt:
          "Teluk Atong Bahari Beach is located in the Maludin hamlet, featuring a beach that needs further source verification.",
        body: "More detailed copy needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Beach",
        tone: "teal",
        verificationNote:
          "Name and partial description are visible. Keep spelling under review because the source also shows Telok Atong in body text.",
      },
    ], {
      target: 12,
      slugPrefix: "temajuk-destination",
      titlePrefix: "Temajuk Destination",
      tones: ["amber", "forest", "teal", "dark"],
      categories: ["Nature", "Coast", "Culture", "Village"],
    }),
    stays: extendCollection([
      {
        slug: "teluk-atong",
        title: "Teluk Atong",
        excerpt:
          "Telok Atong Bahari Beach is located in the Maludin hamlet, featuring a beach that needs further verification.",
        body: "Accommodation detail content needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Beach Stay",
        tone: "teal",
        verificationNote:
          "Shown in the Places To Stay section. Naming and category need final verification.",
      },
      {
        slug: "jlo",
        title: "JLO",
        excerpt:
          "JLO Resort offers a unique and unforgettable holiday experience with various amenities to pamper visitors.",
        body: "Accommodation detail content needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Resort",
        tone: "amber",
        verificationNote:
          "Do not add prices, ratings, reviews, or facilities unless verified from the original source.",
      },
      {
        slug: "upside-down-house",
        title: "Upside Down House",
        excerpt:
          "Amidst the natural beauty of West Kalimantan, there is an Upside Down House that needs further source verification.",
        body: "Accommodation detail content needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Unique Stay",
        tone: "forest",
        verificationNote:
          "Partial copy is visible in the reference. Full description needs verification.",
      },
    ], {
      target: 12,
      slugPrefix: "temajuk-stay",
      titlePrefix: "Temajuk Stay",
      tones: ["teal", "amber", "forest", "dark"],
      categories: ["Stay", "Resort", "Coastal Stay", "Homestay"],
    }),
    news: extendCollection([
      {
        slug: "temajuk-tourism-village-support-local-economy",
        title: "Temajuk Tourism Village as a Support for the Local Community's Economy",
        excerpt:
          "Temajuk Tourism Village, located in Sambas Regency, West Kalimantan, is a hidden gem that offers stunning natural scenery.",
        body:
          "Temajuk Tourism Village, located in Sambas Regency, West Kalimantan, is a hidden gem that offers stunning natural scenery, rich culture, and needs full source verification.\n\nFull article content needs verification from the original source before publication.",
        status: "verified-partial",
        category: "Tourism",
        tone: "dark",
        verificationNote:
          "Title and excerpt are partially visible in the original screenshots. Do not add author, date, category, or event details.",
      },
    ], {
      target: 10,
      slugPrefix: "temajuk-story",
      titlePrefix: "Temajuk Story",
      tones: ["dark", "forest", "amber", "teal"],
      categories: ["News", "Community", "Culture", "Travel"],
    }),
    travelGuide: [
      {
        title: "Get To Temajuk",
        layout: "routes",
        groups: [
          {
            title: "Via Pontianak",
            routes: [
              {
                time: "06.00",
                distance: "100 km",
                route: "Kuching Airport - Temajuk Village",
                transport: "Bus",
              },
              {
                time: "0300",
                distance: "133km",
                route: "Temajuk - Pontianak",
                transport: "Bus",
              },
            ],
          },
          {
            title: "Via Kuching",
            routes: [
              {
                time: "0600",
                distance: "122 km",
                route: "Pontianak",
                transport: "Airplane",
              },
              {
                time: "06.00",
                distance: "100km",
                route: "Airport Kuching - Village Temajuk",
                transport: "Travel",
              },
            ],
          },
        ],
      },
      {
        title: "Temajuk Map View",
        layout: "map",
        intro:
          "This is the details about Temajuk Village, which will be found by the following map as well as the QR code.",
      },
      {
        title: "Border Information",
        layout: "border",
        intro:
          "This is detailed information regarding border crossing information between Indonesia and Malaysia.",
        posters: ["Departure", "Arrival"],
      },
    ],
  };
})(window);
