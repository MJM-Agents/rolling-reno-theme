## 🚀 Deploy Tonight
**Zip ready:** `rolling-reno-v2.zip` (in `/projects/diy-rv-blog/`)

Steps for Mike:
1. WP Admin → Appearance → Themes → Add New → Upload Theme
2. Upload `rolling-reno-v2.zip` → Install → Activate
3. Appearance → Menus → create Primary + Footer menus
4. Settings → Reading → set Homepage to static (select Rolling Reno Home template)
5. Import posts via WP All Import (content in `/projects/diy-rv-blog/content/posts/`)

---

# Rolling Reno v2 — WordPress Theme

**Version:** 2.0.0  
**Design:** Aoife (MJM-101 Phase 2)  
**Build:** Lorcan (MJM-101 Phase 3)  
**Aesthetic:** Wild Irish Editorial — magazine-quality travel blog  
**WordPress minimum:** 6.0  
**PHP minimum:** 8.0  

---

## Files Built

```
theme-v2/
├── style.css                          # Theme header + CSS imports
├── functions.php                      # Setup, enqueue, menus, widget areas, helpers
├── header.php                         # Sticky nav (transparent→opaque on scroll), mobile menu
├── footer.php                         # 4-column footer (Brand / Explore / Connect / Resources)
├── home.php                           # Homepage — 11 sections per spec
├── single.php                         # Post template — editorial, no sidebar
├── archive.php                        # Category/archive hub page
├── page-about.php                     # About Mara page (Template Name: About Mara)
├── page-gear.php                      # Gear/Resources page (Template Name: Gear & Resources)
├── index.php                          # WP fallback (required)
├── assets/
│   ├── css/
│   │   ├── design-system.css          # All CSS custom properties + base styles
│   │   └── main.css                   # Layout + component styles
│   └── js/
│       └── main.js                    # Sticky nav, TOC, smooth scroll, gear tabs, mobile menu
├── template-parts/
│   ├── author-bio.php                 # Mara Collins bio block (reusable include)
│   └── affiliate-card.php             # Affiliate product card (reusable include)
└── README.md                          # This file
```

---

## Install & Deploy

### 1. Upload to WordPress

**Option A — FTP/SFTP:**
1. Upload the entire `theme-v2/` folder to `/wp-content/themes/rolling-reno-v2/` on your server.
2. In WordPress Admin → Appearance → Themes, activate **Rolling Reno v2**.

**Option B — WP Admin upload:**
1. Zip the `theme-v2/` folder: `zip -r rolling-reno-v2.zip theme-v2/`
2. WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Upload `rolling-reno-v2.zip` → Install → Activate.

---

### 2. Configure Menus

Go to **Appearance → Menus** and create + assign:

| Menu | Location |
|---|---|
| Main navigation | Primary Navigation |
| Footer Explore | Footer Explore |
| Footer Connect | Footer Connect |
| Footer Resources | Footer Resources |

Primary Navigation items: Home · Start Here · Van Life · RV Life · Gear · About Mara

---

### 3. Configure Customizer

Go to **Appearance → Customize** and fill in:

**Homepage Hero:**
- Hero Background Image — `1920×1080px` min, WebP
- Hero Title — default set; edit as needed
- Hero Subheading

**Mara Collins Profile:**
- Mara Avatar Image — `192×192px` minimum, circular crop, WebP
- About Teaser Image — `600×800px` (3:4 portrait), WebP

**Social Links:**
- Instagram, Pinterest, YouTube, TikTok URLs

**Newsletter / Lead Magnet:**
- Form Action URL — point to your ConvertKit/Mailchimp form handler

---

### 4. Add Category Images

In the Customizer, set category tile images:

| Setting Key | Image Spec |
|---|---|
| `rr_cat_img_van_life` | `600×600px`, square, van on Irish road |
| `rr_cat_img_rv_life` | `600×600px`, square, RV at golden hour |
| `rr_cat_img_gear` | `600×600px`, square, gear flat-lay |
| `rr_cat_img_maras_rig` | `600×600px`, square, van interior |

---

### 5. About Page Setup

1. Create a new **Page** in WordPress.
2. In **Page Attributes → Template**, select **About Mara**.
3. Set the URL slug to `/about`.
4. Publish.

---

### 6. Gear Page Setup

1. Create a new **Page** in WordPress.
2. In **Page Attributes → Template**, select **Gear & Resources**.
3. Set the URL slug to `/gear`.
4. Publish.
5. Update affiliate product links in `page-gear.php` (search for `'shop_url' => '#'`) with real Amazon Associates links.

---

### 7. Affiliate Links

All placeholder affiliate links in `page-gear.php` are set to `#`. Replace with your Amazon Associates links:

```php
'shop_url' => 'https://www.amazon.co.uk/dp/YOUR-ASIN?tag=YOUR-ASSOCIATE-TAG',
```

All affiliate links already include `rel="nofollow sponsored"`, `target="_blank"`, and descriptive `aria-label`. Do not remove these.

---

### 8. Instagram Strip

The homepage Instagram strip (Section 10) currently uses placeholder emoji cells.

**To connect a real Instagram feed**, use one of:
- **Smash Balloon Social Photo Feed** (recommended, free tier available)
- **LightWidget** (free, lightweight)
- **WP Instagram Widget** (free)

Once installed, replace the `.instagram-grid` section in `home.php` with the plugin's shortcode output.

---

### 9. Category Hero Images

In WordPress Admin → **Posts → Categories**, add:
- A description for each category (used as the hero subheading)
- A featured image (via plugin like **Category Featured Image** or **ACF**)

Alternatively, set category images via the Customizer.

---

## Core Web Vitals Notes

- **LCP (hero image):** Hero images use `loading="eager"` + `fetchpriority="high"`. Add `<link rel="preload" as="image">` for the above-the-fold hero via Customizer output in `functions.php`.
- **CLS:** All images have explicit `width`/`height` attributes. Placeholder divs maintain aspect ratios via CSS.
- **FID/INP:** `main.js` is deferred via `defer` attribute. No render-blocking JS.
- **Fonts:** Google Fonts loads via `preconnect` + `display=swap`.

---

## Mara Collins Imagery

All image slots currently use CSS placeholder divs with emoji. To add real imagery:

1. Upload images via WordPress Media Library.
2. Set them via the Customizer (hero, avatar, about image, gallery).
3. For category tiles, set via Customizer category image fields.
4. Instagram feed: connect via plugin.

**Required photo brief (see `about-mara-v2.md` for full spec):**
- Hero: Mara at van doorway, Irish landscape, golden hour, 1920×1080px
- Avatar: Headshot/half-body, 192×192px, warm-toned
- About teaser: Portrait 3:4, 600×800px
- Gallery strip: 4 × 600×900px, consistent warm edit

---

## Custom Post Meta Reference

| Meta Key | Template Used | Description |
|---|---|---|
| `_rr_featured` | `home.php` | Set to `1` to feature a post in the Featured Story section |
| `_rr_pinned` | `archive.php` | Set to `1` to pin a post to the top of a category page |
| `_rr_hero_caption` | `single.php` | Custom caption for the post hero image |

Use **Advanced Custom Fields** (free) or **Simple Custom Post Meta** to manage these fields.

---

## Development Notes

- All styles use CSS custom properties from `design-system.css`. Never hardcode colours.
- `main.css` imports after `design-system.css`. Order matters.
- `main.js` is vanilla JS, no jQuery dependency.
- WordPress >= 6.0 uses `wp_enqueue_script()` with `strategy: 'defer'` — ensure your WP version supports this.
- The theme passes Customizer settings for images. If using ACF or custom meta, update the `get_theme_mod()` calls in templates.

---

*Built by Lorcan | MJM-101 Phase 3 | 2026-04-18*
