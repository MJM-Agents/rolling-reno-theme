# DIY RV Blog — Design System
**Version:** 1.0  
**Ticket:** MJM-84  
**Author:** Aoife (Design/Visual QA)  
**Date:** 2026-04-17  

---

## Brand Positioning

The DIY RV Renovation Blog is for hands-on builders and road-life dreamers. The aesthetic is **rugged but readable, practical but warm** — think workshop manuals meets adventure journal. It should feel like it was built by someone who actually uses wrenches, not a design agency.

**Brand personality:** Honest. Resourceful. Encouraging. No-nonsense.  
**Audience:** DIY campervan builders, weekend mechanics, budget travellers, van-lifers.

---

## 1. Color Palette

### Primary
| Name | Hex | Usage |
|---|---|---|
| Diesel Black | `#1C1C1C` | Body text, icons, nav |
| Workshop Steel | `#3A4A5C` | Primary brand color, headers, CTAs |

### Secondary
| Name | Hex | Usage |
|---|---|---|
| Trail Rust | `#C0522B` | Highlight, active states, link hover |
| Dusty Sage | `#7A9E7E` | Secondary accents, tags, success states |

### Accent
| Name | Hex | Usage |
|---|---|---|
| Amber Grease | `#E8A838` | Badges, callout backgrounds, star ratings |
| Canvas Cream | `#F5EED8` | Post card backgrounds, blockquote fills |

### Neutrals
| Name | Hex | Usage |
|---|---|---|
| Off-White | `#FAF8F4` | Page background |
| Light Ash | `#EBEBEB` | Borders, dividers |
| Mid Grey | `#9A9A9A` | Captions, secondary text |
| Dark Slate | `#2E2E2E` | Strong text, section headers |

### Functional
| Name | Hex | Usage |
|---|---|---|
| Warning Orange | `#D96A2A` | Safety callouts ("heads up" blocks) |
| Info Blue | `#4A7FB5` | Tips and resource blocks |
| Success Green | `#4A9463` | Checkmarks, done states |

---

## 2. Font Stack

All fonts are free via [Google Fonts](https://fonts.google.com/).

### Heading Font — **Oswald** (Bold / SemiBold)
- Weight: 600 (SemiBold), 700 (Bold)
- Usage: H1–H3, hero text, card titles, nav logo
- Feel: Strong, compact, utilitarian — like stencil lettering on a toolbox
- Import: `https://fonts.googleapis.com/css2?family=Oswald:wght@600;700&display=swap`

### Sub-heading / UI Font — **Inter** (Medium / SemiBold)
- Weight: 500, 600
- Usage: H4–H6, labels, buttons, nav links, table headers
- Feel: Clean, modern sans-serif — good screen legibility at small sizes
- Import: `https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap`

### Body Font — **Lora** (Regular / Italic)
- Weight: 400, 400i
- Usage: Article body, long-form prose, blockquotes
- Feel: Readable serif — approachable, editorial, works at 16–18px
- Import: `https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;1,400&display=swap`

### Code / Caption / Monospace — **JetBrains Mono** (Regular)
- Weight: 400
- Usage: Code snippets, part numbers, measurements, captions
- Feel: Practical, techy — fits build specs and wiring diagrams
- Import: `https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap`

### Type Scale (rem-based, base 16px)
```
h1: 2.75rem / Oswald 700 / line-height 1.15
h2: 2.00rem / Oswald 600 / line-height 1.2
h3: 1.5rem  / Oswald 600 / line-height 1.25
h4: 1.2rem  / Inter 600  / line-height 1.3
h5: 1.0rem  / Inter 600  / line-height 1.4
body: 1.125rem / Lora 400 / line-height 1.7
caption: 0.85rem / Inter 500 / Mid Grey
code: 0.9rem / JetBrains Mono 400
```

---

## 3. Logo Concept

### Mark Description
A simplified **side-profile silhouette of a campervan/RV** rendered in thick lines — boxy body, rounded roofline, one visible wheel. The silhouette is filled with Workshop Steel (`#3A4A5C`) with a Trail Rust (`#C0522B`) accent line or stripe. Inside or beside the van, a small **wrench icon** overlaps slightly, hinting at the DIY angle.

### Wordmark
- Text: **"WRENCH & WANDER"** (or the blog's chosen name — this is the placeholder brand)
- Font: Oswald 700
- Color: Diesel Black on light, Off-White on dark
- All caps, tight letter-spacing (0.05em)

### Tagline
- "Build it. Drive it. Live it."
- Font: Inter 500, italic
- Color: Mid Grey (`#9A9A9A`) on light backgrounds, Canvas Cream on dark

### Layout Variants
1. **Horizontal lockup** — Mark left, wordmark + tagline stacked right. Use in header.
2. **Stacked lockup** — Mark centered above wordmark. Use in footer, social.
3. **Icon only** — Van silhouette solo. Use as favicon, app icon.

### SVG Asset
See: `assets/logo.svg`

---

## 4. Post Thumbnail Template Spec

### Dimensions
- **Standard**: 1200 × 630px (Open Graph / social share)
- **Card thumb**: 800 × 450px (blog listing grid)
- **Square** (optional): 1080 × 1080px (Instagram)

### Layout Zones
```
┌─────────────────────────────────────────────────┐
│  [TOP BAND — 60px] Category tag + logo icon      │
├─────────────────────────────────────────────────┤
│                                                   │
│  [HERO IMAGE ZONE — full bleed, darkened 40%]    │
│                                                   │
│  ┌─────────────────────────────────────────────┐ │
│  │  [TEXT BOX — bottom-left, 70% width]        │ │
│  │  POST TITLE — Oswald 700, white, 2.5rem     │ │
│  │  Sub-label — Inter 500, Canvas Cream        │ │
│  └─────────────────────────────────────────────┘ │
│                                                   │
│  [BOTTOM STRIP — 48px] Trail Rust accent bar     │
└─────────────────────────────────────────────────┘
```

### Color Usage in Thumbnails
- Background overlay: `rgba(28, 28, 28, 0.45)` on photo
- Top band bg: Workshop Steel `#3A4A5C`
- Bottom strip: Trail Rust `#C0522B`
- Title text: Off-White `#FAF8F4`
- Category tag: Amber Grease `#E8A838` pill on Workshop Steel
- No more than 3 colors active in any thumbnail

### Typography in Thumbnails
- Title: Oswald 700, max 2 lines, 40–52px
- Tag/category: Inter 600, 12–14px, uppercase

### SVG Template
See: `assets/thumbnail-template.svg`

---

## 5. Header / Footer Design Spec

### Header

**Layout:** Full-width sticky header, 72px tall on desktop, 60px mobile.

```
┌────────────────────────────────────────────────────────┐
│  [Logo lockup — left]   [Nav links — center/right]  🔍 │
└────────────────────────────────────────────────────────┘
```

**Colors:**
- Background: Off-White `#FAF8F4` (default), Workshop Steel `#3A4A5C` (dark/hero mode)
- Text/links: Diesel Black `#1C1C1C` on light, Off-White on dark
- Active link underline: Trail Rust `#C0522B`
- Border-bottom: Light Ash `#EBEBEB` 1px

**Nav Structure:**
- Logo (left)
- Links (right): Build Diaries | Parts & Gear | Tips & Tricks | About | [Search icon]
- Mobile: Hamburger → slide-in drawer, same links stacked
- CTA (optional): "Start Your Build →" button in Trail Rust

**Nav font:** Inter 600, 15px, letter-spacing 0.02em

---

### Footer

**Layout:** 3-column grid on desktop, stacked on mobile. Dark background.

```
┌─────────────────────────────────────────────────────────┐
│  [Col 1]           [Col 2]           [Col 3]            │
│  Logo + tagline    Quick Links       Newsletter signup   │
│  Social icons      Build Diaries     "Get free tips"     │
│                    Parts & Gear      [email] [Subscribe] │
│                    Tips & Tricks                         │
│                    About / Contact                       │
├─────────────────────────────────────────────────────────┤
│  © 2026 Wrench & Wander · Privacy · Terms · Built w/ ❤️ │
└─────────────────────────────────────────────────────────┘
```

**Colors:**
- Background: Diesel Black `#1C1C1C`
- Text: Off-White `#FAF8F4`
- Links: Mid Grey → Off-White on hover
- Accent rule: Trail Rust `#C0522B` 2px top border
- Subscribe button: Amber Grease `#E8A838`, Diesel Black text

**Footer font:** Inter 400, 14px

---

## 6. Brand Application Notes

### What Works ✅
- **Dark backgrounds with rust/amber accents** — strong contrast, visually bold in thumbnails and hero sections
- **Oswald headlines on photo overlays** — legible at all sizes, feels authoritative
- **Lora for long-form prose** — serif warmth balances the mechanical aesthetic
- **Amber callout boxes** for tips, part numbers, or "tools needed" sections — stands out without screaming
- **Generous white space** — the rugged aesthetic doesn't mean cluttered; let content breathe
- **Photo-forward layouts** — show real builds, real hands, real grit. Stock photography hurts the brand.
- **Consistent use of Trail Rust as the single interactive affordance color** (links, CTAs, active states)

### What to Avoid ❌
- **Pastel or overly "lifestyle" color treatments** — this isn't a wellness brand
- **Script or handwriting fonts** — they undercut the credibility of build content
- **Gradient-heavy designs** — flat, confident color blocks suit the aesthetic better
- **Excessive rounded corners** — medium radius (4–8px) is fine; pill shapes everywhere feels too soft
- **Stock images of gleaming, factory-perfect RVs** — show real, in-progress builds
- **Neon or high-saturation accent colors** — Amber Grease is warm gold, not yellow; Trail Rust is earthy, not orange
- **More than 3 typefaces in any single view** — stick to the stack
- **Small body text** — minimum 16px for body; the audience skews practical, not design-obsessed, legibility wins

### Responsive Notes
- Header collapses to logo + hamburger at <768px
- Post grid: 3-col → 2-col → 1-col
- Thumbnails: standard 16:9 maintained across breakpoints, text reflows
- Footer: 3-col → 1-col stacked, logo centered

---

## Asset Manifest

| File | Description |
|---|---|
| `assets/logo.svg` | Full horizontal lockup (Workshop Steel + Trail Rust) |
| `assets/logo-icon.svg` | Van icon only (favicon source) |
| `assets/thumbnail-template.svg` | 1200×630 post thumbnail base |
| `assets/color-swatches.svg` | Visual color palette reference |

---

*Design system v1.0 — ready for Niamh's brand research integration and Lorcan/Conor frontend implementation.*
