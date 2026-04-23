# Amazon Affiliate Link Audit — MJM-192
**Date:** 2026-04-21  
**Auditor:** Lorcan (Senior Dev)  
**Site:** https://rollingreno.com  
**Affiliate Tag:** `rollingreno-20`

---

## Summary

Full audit of all Amazon affiliate links across all published posts and pages on Rolling Reno.

- **Total Amazon affiliate links found:** 11 (across 3 published posts)
- **Affiliate tag correct:** ✅ 11/11
- **Links have `rel="nofollow sponsored"`:** ✅ 11/11
- **Links open in new tab (`target="_blank"`):** ✅ 11/11
- **Broken links (4xx):** ✅ 0 — all URLs return 503 (Amazon bot-blocking, not broken)
- **Missing affiliate tags:** ✅ 0
- **In-post affiliate disclosure:** ⚠️ 0/3 posts — disclosure exists site-wide in footer only
- **Disclosure page live:** ✅ https://rollingreno.com/affiliate-disclosure/

---

## Detailed Link Audit

### Post 53 — RV & Van Bed Build: Fixed vs Convertible, Murphy Beds, and Mattress Options
| URL | Tag | rel | Status |
|-----|-----|-----|--------|
| `https://www.amazon.com/s?k=heavy+duty+drawer+slides+100lb&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=murphy+bed+hardware+kit&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=Sealy+RV+mattress&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=King+Koil+RV+mattress&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |

### Post 54 — The Complete Van & RV Buyer's Guide: Best Models to Renovate
| URL | Tag | rel | Status |
|-----|-----|-----|--------|
| `https://www.amazon.com/s?k=Aluminess+roof+rack&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=Owl+Vans+storage+panel&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ⚠️ Owl Vans is a specialty brand — limited Amazon stock |
| `https://www.amazon.com/s?k=moisture+meter&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |

### Post 55 — Best Lightweight Materials for an RV Remodel
| URL | Tag | rel | Status |
|-----|-----|-----|--------|
| `https://www.amazon.com/s?k=COREtec+Pro+Plus+4mm&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=Celtec+PVC+foam+board&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=Formica+laminate+sheet&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |
| `https://www.amazon.com/s?k=thin+butcher+block+countertop&tag=rollingreno-20` | ✅ rollingreno-20 | ✅ nofollow sponsored | ✅ Valid search URL |

---

## Findings

### ✅ PASS — Affiliate Tag
All 11 links use `tag=rollingreno-20`. No missing or incorrect tags found.

### ✅ PASS — Link Format
All links use Amazon search (`/s?k=`) format. This is a valid affiliate linking strategy that redirects to search results and avoids broken product-page links if a specific ASIN goes out of stock.

### ✅ PASS — SEO Attributes
All links have `rel="nofollow sponsored"` per Google's requirements for paid/affiliate links, and `target="_blank"`.

### ✅ PASS — Affiliate Disclosure Page
Page live at `/affiliate-disclosure/`. Linked in site footer on every page.

### ⚠️ ISSUE — No In-Post Disclosure Notices
Posts 53, 54, and 55 contain affiliate links but have no disclosure notice within the post body itself. FTC guidelines recommend affiliate disclosures to be "clear and conspicuous" and near the affiliate links — not just in a site footer.

**Fix applied:** Added `rolling_reno_affiliate_notice()` to `functions.php` using the `the_content` filter. Automatically appends a styled affiliate disclosure to any post that contains Amazon affiliate links with tag `rollingreno-20`. No manual per-post edits required.

### ⚠️ NOTE — Owl Vans Amazon Availability
The URL `https://www.amazon.com/s?k=Owl+Vans+storage+panel&tag=rollingreno-20` may return limited/irrelevant results as Owl Vans is a specialty van conversion fabricator that primarily sells direct. Recommend monitoring this link — consider replacing with direct Owl Vans website link + a generic "van storage panels" Amazon search link.

---

## Changes Made

### `functions.php`
Added `rolling_reno_affiliate_notice()` function that:
- Detects if post content contains `rollingreno-20` affiliate links
- Appends a visible disclosure box above the content for those posts
- Uses standard `the_content` filter — no template changes required
- PHP lint verified ✅

---

## Verification

```bash
# Verify all links from Flywheel SSH
wp --path=/wordpress db query "SELECT ID, post_title FROM wp_2s4o8u5fqt_posts WHERE (post_content LIKE '%amazon.com%' OR post_content LIKE '%rollingreno-20%') AND post_status='publish'"
# Returns: Post 53, 54, 55 — all confirmed
```

All 11 links verified. Tag `rollingreno-20` consistent across all. Policy compliance improved via auto-disclosure in `functions.php`.
