# MJM-190 — Rolling Reno brand image audit

Date: 2026-04-21
Site: https://rollingreno.com
Theme: rolling-reno-v2

## Summary
- Replaced 4 theme assets that were visibly off-brand or too generic: `mara-landscape`, `mara-portrait`, `mara-avatar`, `hero-unsplash`
- Kept the strongest existing Mara/van lifestyle images already aligned to the brand
- Left blog thumbnails alone unless confidence was high
- No image logo found, header uses text branding
- No sidebar image module detected on audited templates

## Inventory

| URL / Asset | Location | Verdict | Notes |
|---|---|---|---|
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-hero.jpg` | Homepage hero | Keep | Strong brand fit, real van-life feel |
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-landscape.jpg` | Homepage Mara spotlight, About gallery | Replace | Previous image felt generic/off-brand, replaced with stronger Mara lifestyle image |
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-portrait.jpg` | Homepage about teaser, About gallery | Replace | Previous portrait felt generic/AI-smooth, replaced with warmer on-brand crop |
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-about.jpg` | About hero, About gallery | Keep | Relevant camper/doorway lifestyle image |
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-card.jpg` | About gallery | Keep | Best supporting Mara lifestyle image in current set |
| `/wp-content/themes/rolling-reno-v2/assets/images/mara-avatar.jpg` | Author bio on posts | Replace | Previous avatar felt generic/off-brand, swapped to portrait matching site image family |
| `/wp-content/themes/rolling-reno-v2/assets/images/hero-unsplash.jpg` | Theme asset only, not visibly primary on audited pages | Replace | Old generic stock fallback, synced to current hero family |
| `/wp-content/uploads/2026/04/126-full-time-rv-insurance.png` | Post hero | Keep | Relevant, realistic, strong fit |
| `/wp-content/uploads/2026/04/126-full-time-rv-insurance-480x360.png` | Homepage/blog thumbnail | Keep | Relevant van-life work scene |
| `/wp-content/uploads/2026/04/55-best-lightweight-materials-rv-remodel-480x360.png` | Homepage/blog thumbnail | Keep | Authentic renovation-in-progress feel |
| `/wp-content/uploads/2026/04/54-best-vans-rvs-to-renovate-buyers-guide-480x360.png` | Homepage/blog thumbnail | Needs human review | Reads more like promo lineup than grounded renovation image |
| `/wp-content/uploads/2026/04/53-rv-van-bed-build-diy-480x360.png` | Homepage/blog thumbnail | Keep | Strong interior build relevance |
| `/wp-content/uploads/2026/04/52-rv-van-kitchen-build-diy-guide-480x360.png` | Homepage/blog thumbnail | Keep | Strong kitchen build relevance |
| `/wp-content/uploads/2026/04/51-rv-van-bathroom-toilet-guide-480x360.png` | Homepage/blog thumbnail | Keep | Realistic install scene |
| `/wp-content/uploads/2026/04/50-rv-van-storage-solutions-diy-480x360.png` | Blog thumbnail | Keep | Good storage/cabinet build detail |
| `/wp-content/uploads/2026/04/49-rv-van-ventilation-condensation-guide-480x360.png` | Blog thumbnail | Needs human review | More stylized than practical, less believable than the rest |
| `/wp-content/uploads/2026/04/48-rv-van-heating-options-480x360.png` | Blog thumbnail | Keep | Strong cozy van-life image |
| `/wp-content/uploads/2026/04/47-rv-solar-system-diy-guide-480x360.png` | Blog thumbnail | Keep | Relevant solar install image |

## Human review list
- `/wp-content/uploads/2026/04/54-best-vans-rvs-to-renovate-buyers-guide-480x360.png`
- `/wp-content/uploads/2026/04/49-rv-van-ventilation-condensation-guide-480x360.png`

## Notes
- I did not replace the two flagged blog thumbnails because I was not confident enough in a better free stock replacement without risking a less authentic result.
- Permissions must be normalized after upload: directories `755`, files `644`.
- Cache flush required after deploy: `php /www/fw-flush-cache.php`
