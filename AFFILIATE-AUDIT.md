# Amazon Affiliate Link Audit — MJM-192
**Date:** 2026-04-21
**Auditor:** Lorcan (Senior Dev)
**Site:** https://rollingreno.com

---

## Summary

Full audit of all Amazon affiliate links across all published posts and pages (65 total).

**Result: No live Amazon affiliate URLs found in post content or post meta.**

The site uses an affiliate product card system (MJM-137) with Amazon Associate ID `rollingreno-20`, but no product cards have been populated yet. Posts reference "Amazon" as a general shopping destination in text only — no clickable `amazon.com` links exist.

---

## Audit Scope

| Check | Result |
|-------|--------|
| `amazon.com` URLs in post content | ❌ None found |
| `amzn.to` URLs in post content | ❌ None found |
| `?tag=` param in post content | ❌ None found |
| Product card meta (`_rr_affiliate_products`) | ❌ Empty on all posts |
| Affiliate disclosure page | ✅ Exists at `/affiliate-disclosure/` (ID 78) |
| Footer link to disclosure | ✅ Present in Resources nav fallback |
| Per-card inline disclosure | ✅ Present in `affiliate-card.php` |

---

## Posts Mentioning "Amazon" (text reference only — no links)

| Post ID | Title | Amazon context |
|---------|-------|----------------|
| 42 | Budget RV Makeover Under $1,000 | "cafè curtains from Amazon or Target" |
| 45 | Van Electrical System DIY | "current prices on Amazon, Renogy's direct site..." |
| 48 | RV & Van Heating | "sold under 30+ brand names on Amazon" |
| 49 | RV & Van Ventilation | "imported budget units...on Amazon" |
| 54 | The Complete Van & RV Buyer's Guide | "moisture meter (~$25 on Amazon)" |

None of these are affiliate links — they are editorial text references only.

---

## Issues Found & Fixes Applied

### Fix 1 — `rr_affiliate_url()` — amzn.to short link bug
**File:** `functions.php`
**Issue:** The original function attempted to append `?tag=rollingreno-20` to `amzn.to` short links. Amazon short links don't support query parameters — the tag would be silently dropped, costing the site commission.
**Fix:** `amzn.to` URLs are now returned unchanged (they should always be expanded to full `amazon.com` URLs before use).

### Fix 2 — `rr_affiliate_url()` — foreign affiliate tag replacement
**File:** `functions.php`
**Issue:** If a URL already contained a `tag=` param belonging to a different associate, the function returned the URL unchanged, leaking commissions.
**Fix:** If a URL contains a `tag=` that isn't `rollingreno-20`, it is replaced with `rollingreno-20`.

### Fix 3 — Affiliate section disclosure notice
**File:** `functions.php` (`rr_render_affiliate_products`)
**Issue:** The affiliate products section rendered cards with per-card micro-disclosures but had no prominent section-level FTC disclosure notice. Per FTC guidelines, disclosure should be "clear and conspicuous" — ideally visible before the affiliate links, not buried at the bottom of each card.
**Fix:** Added a disclosure paragraph immediately below the section heading, linking to `/affiliate-disclosure/`.

### Fix 4 — Disclosure paragraph styling
**File:** `style.css`
**Fix:** Added `.affiliate-products-section__disclosure` styles — small text, muted colour, left-border accent for visibility.

---

## No Changes Required

| Area | Status |
|------|--------|
| Broken links | N/A — no affiliate links exist yet |
| Missing affiliate tags on existing links | N/A — no links exist yet |
| Affiliate disclosure page content | ✅ Adequate |
| Footer disclosure link | ✅ Present |
| `rel="nofollow sponsored"` on card links | ✅ Already correct |
| Amazon Associate ID | ✅ `rollingreno-20` hardcoded in constants |

---

## Recommendations (not blocking)

1. **Add real product cards** — The infrastructure is in place. When adding posts with gear recommendations, use the "Affiliate Products" metabox in the WordPress editor.
2. **Expand `amzn.to` short links** — If any `amzn.to` links are added in future, they should be expanded to full `amazon.com` URLs with the `tag=rollingreno-20` parameter.
3. **Consider inline text links** — For editorial mentions like "moisture meter on Amazon", consider converting to actual affiliate links with `?tag=rollingreno-20` to capture commission on product references.
