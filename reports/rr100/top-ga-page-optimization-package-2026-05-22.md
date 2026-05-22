# RR100 Top GA Page Optimization Package — 2026-05-22

Issue: MJM-Agents/rolling-reno-theme#100  
Owner/review lane: Sarah copy + affiliate review  
Live status: **Not live from this package**. This is a repo-backed implementation package only; WordPress writes and final Sienna QA remain blocked until valid WP REST/app-password access and media/default featured-image prerequisites are available.

## Scope

Source GA window from issue #100: May 8–14, 2026. This package covers the 10 priority pages named in the issue and gives implementation-ready edits for:

- affiliate CTA placement and link target
- affiliate disclosure placement
- internal links to add/strengthen
- focus keyword
- SEO title
- meta description
- copy/safety notes

## Current live validation snapshot

Checked public `https://rollingreno.com` pages on 2026-05-22 ET with a Node HTTPS metadata/link probe. No WordPress credentials were used.

| Priority | Page | Live HTTP | Current affiliate links found | Current metadata note |
|---:|---|---:|---:|---|
| 1 | `/` | 200 | 5 | Meta is too long/noisy because it appears to pull page body text. |
| 2 | `/rv-wall-panel-replacement/` | 200 | 0 | Title/meta are solid; page has a clear affiliate gap. |
| 3 | `/rv-electrical-renovation-planning/` | 200 | 0 | Safety content should stay conservative; affiliate gap exists. |
| 4 | `/rv-renovation-weight-checklist/` | 200 | 0 | Good topic fit for scale/material links; affiliate gap exists. |
| 5 | `/blog/` | 200 | 0 direct Amazon links in hub body | Meta is generic: “RV renovation for real budgets.” |
| 6 | `/rv-water-system-upgrade-pex-pump/` | 200 | 1 | Existing affiliate link passes tag/rel/target pattern. |
| 7 | `/rv-insulation-upgrades-four-season/` | 200 | 1 | Existing affiliate link passes tag/rel/target pattern. |
| 8 | `/rv-roof-reseal-before-renovation/` | 200 | 1 | Existing affiliate link passes tag/rel/target pattern. |
| 9 | `/rv-renovation-water-damage-mistakes/` | 200 | 0 | Strong safety page; affiliate gap exists for inspection tools. |
| 10 | `/rv-kitchen-storage-ideas-small-spaces/` | 200 | 1 | Existing affiliate link passes tag/rel/target pattern. |

Existing Amazon affiliate links sampled on live pages use `tag=rollingreno-20`, `target="_blank"`, and `rel="nofollow sponsored noopener"` / `rel="sponsored nofollow noopener"`.

## Global implementation rules

1. Place the disclosure before the first product recommendation on every post with affiliate links:
   > **Affiliate disclosure:** As an Amazon Associate, Rolling Reno may earn from qualifying purchases. This post includes affiliate links at no extra cost to you.
2. Use only specific Amazon product URLs, not `/s?k=` search URLs.
3. Required link attributes for inline product CTAs: `rel="sponsored nofollow noopener" target="_blank"`.
4. Keep 1–2 affiliate CTAs per post. The homepage already has a gear strip; do not add more homepage product links unless the page design is intentionally revised.
5. Preserve safety language for electrical, roof, water, insulation, weight, and water-damage pages. Product links should support inspection/planning, not imply unsafe DIY work.
6. After WP writes, Sienna QA should verify each live page returns 200, canonical is correct, disclosure precedes affiliate CTA, Amazon URLs include `tag=rollingreno-20`, link attributes are present, and metadata reflects the final page.

---

## Page-by-page package

### 1. Homepage — `/` — WP page ID 17

- **Focus keyword:** RV renovation guides
- **SEO title:** Rolling Reno: Practical RV Renovation Guides for Real Budgets
- **Meta description:** Practical RV renovation guides for planning, weight, water damage, electrical, storage, insulation, roof reseal, and road-tested gear decisions.
- **Affiliate approach:** Keep existing gear strip only. It already includes specific Amazon affiliate links and attributes; avoid adding more homepage CTAs above the fold.
- **Internal links to strengthen:**
  - `/rv-renovation-weight-checklist/` from a “Plan the build weight first” hub card.
  - `/rv-wall-panel-replacement/` from an “Interior repairs” hub card.
  - `/rv-roof-reseal-before-renovation/` from a “Dry before pretty” hub card.
  - `/rv-water-system-upgrade-pex-pump/` from a “Systems to inspect before closing cabinets” card.
  - `/blog/` from a “See all guides” CTA.
- **Copy edit:** Replace the current hero/supporting copy if needed with a more RV-renovation-specific value prop: “Practical RV renovation guides for budgets, weight, leaks, storage, systems, and road-ready upgrades — no fantasy build math required.”
- **Safety note:** None beyond existing gear caveats.

### 2. RV Wall Panel Replacement — `/rv-wall-panel-replacement/` — post ID 264

- **Focus keyword:** RV wall panel replacement
- **SEO title:** RV Wall Panel Replacement: Repair Interior Walls Without Trapping Moisture
- **Meta description:** Learn how to replace RV wall panels, inspect for leaks, choose lightweight materials, and avoid trapping moisture behind fresh interior walls.
- **Affiliate CTAs:**
  1. After the moisture inspection section: “For checking suspicious wall areas before you close them back up, compare the Klein Tools ET140 pinless moisture meter on Amazon.”  
     URL: `https://www.amazon.com/Klein-Tools-ET140-Non-Destructive-Detection/dp/B07SZX8QXH?tag=rollingreno-20`
  2. Optional, only if there is a prep/tools section: “For cleaner panel cuts and outlet openings, compare the DEWALT DCS356C1 oscillating multi-tool kit on Amazon.”  
     URL: `https://www.amazon.com/dp/B085B253MD?tag=rollingreno-20`
- **Disclosure placement:** Before the first moisture-meter CTA.
- **Internal links to add/strengthen:**
  - `/rv-renovation-water-damage-mistakes/`
  - `/rv-roof-reseal-before-renovation/`
  - `/rv-insulation-upgrades-four-season/`
  - `/rv-renovation-weight-checklist/`
  - `/rv-subfloor-repair-soft-spots/` if relevant in the damage assessment section.
- **Copy note:** Keep the “do not hide moisture” framing. The product CTA should be positioned as an inspection aid, not a guarantee.

### 3. RV Electrical Renovation Planning — `/rv-electrical-renovation-planning/` — post ID 262

- **Focus keyword:** RV electrical renovation planning
- **SEO title:** RV Electrical Renovation Planning: Map 12V, 120V, Outlets, and Access
- **Meta description:** Plan RV electrical updates before closing walls: map 12V and 120V runs, outlet placement, lighting, battery access, labels, and pro-only safety decisions.
- **Affiliate CTAs:**
  1. After the labeling/access planning section: “For mapping circuits before demo, compare the Brother P-touch PTD220 label maker on Amazon.”  
     URL: `https://www.amazon.com/Brother-P-Touch-PTD220-Label-Maker/dp/B0B3ZQ2NML?tag=rollingreno-20`
  2. Optional after access/inspection section: “For non-contact checks while identifying unknown wiring, compare the Klein Tools NCVT-1P voltage tester on Amazon — and use it only as a screening tool, not a substitute for a qualified electrician.”  
     URL: `https://www.amazon.com/Klein-Tools-NCVT-1P-Non-Contact-Indicator/dp/B099SJ6469?tag=rollingreno-20`
- **Disclosure placement:** Before the label-maker CTA.
- **Internal links to add/strengthen:**
  - `/rv-electrical-labeling-before-demo/`
  - `/rv-renovation-weight-checklist/`
  - `/rv-insulation-upgrades-four-season/`
  - `/rv-wall-panel-replacement/`
  - `/rv-renovation-tool-kit-weekend-projects/`
- **Safety note:** Keep explicit language that 120V, inverter, battery bank, and unclear wiring work should be handled by qualified help.

### 4. RV Renovation Weight Checklist — `/rv-renovation-weight-checklist/` — post ID 266

- **Focus keyword:** RV renovation weight checklist
- **SEO title:** RV Renovation Weight Checklist: Upgrade Without Overloading Your Rig
- **Meta description:** Use this RV renovation weight checklist to plan materials, batteries, water, storage, and upgrades without quietly eating up payload.
- **Affiliate CTAs:**
  1. Near the weighing/materials section: “For weighing removed parts, packed bins, and small build materials, compare the Etekcity luggage scale on Amazon.”  
     URL: `https://www.amazon.com/Etekcity-Luggage-Scale-Digital-Suitcase/dp/B00NW62PCA?tag=rollingreno-20`
  2. Optional near lightweight materials: “For insulation planning, compare 3M Thinsulate SM600L on Amazon before choosing materials.”  
     URL: `https://www.amazon.com/SM600L-Automotive-Camper-Insulation-Inch/dp/B0DP3NGNGQ?tag=rollingreno-20`
- **Disclosure placement:** Before the scale CTA.
- **Internal links to add/strengthen:**
  - `/lightweight-rv-remodel-materials-amazon/`
  - `/rv-insulation-upgrades-four-season/`
  - `/rv-kitchen-storage-ideas-small-spaces/`
  - `/rv-water-system-upgrade-pex-pump/`
  - `/rv-wall-panel-replacement/`
- **Copy note:** Tie every product mention back to payload discipline. Avoid “buy this upgrade” framing.

### 5. Blog index — `/blog/` — WP page ID 18

- **Focus keyword:** RV renovation blog
- **SEO title:** Rolling Reno Blog: RV Renovation Guides, Gear, Storage, Leaks, and Systems
- **Meta description:** Browse Rolling Reno’s RV renovation guides by project stage, from leaks and wall panels to electrical planning, storage, insulation, tools, and road-tested gear.
- **Affiliate approach:** No direct Amazon links needed on the hub. The hub should route readers to relevant post-level guides where disclosure and affiliate context are clearer.
- **Internal links to strengthen:** Add or feature pathways to:
  - `/rv-roof-reseal-before-renovation/`
  - `/rv-wall-panel-replacement/`
  - `/rv-electrical-renovation-planning/`
  - `/rv-renovation-weight-checklist/`
  - `/rv-kitchen-storage-ideas-small-spaces/`
- **Copy edit:** Update the intro from general “From the Road” positioning to a more search/use-case oriented line: “Find the right RV renovation guide by job: leaks first, walls next, weight always, and systems before you close anything up.”

### 6. RV Water System Upgrade — `/rv-water-system-upgrade-pex-pump/` — post ID 252

- **Focus keyword:** RV water system upgrade
- **SEO title:** RV Water System Upgrade: PEX, Fittings, Pumps, and Leak Checks
- **Meta description:** Plan an RV water system upgrade with PEX, fittings, pumps, access panels, pressure checks, and leak prevention before cabinets hide the plumbing.
- **Affiliate CTAs:**
  1. Existing CTA can remain: SHURFLO Revolution 3.0 GPM water pump.  
     URL: `https://www.amazon.com/SHURFLO-4008-101-E65-Revolution-Water-Pump/dp/B002XM5G70?tag=rollingreno-20`
  2. Add near pressure/leak testing: “For quick pre-close leak checks, compare the Camco blow-out plug on Amazon if it fits your winterizing/test setup.”  
     URL: `https://www.amazon.com/Camco-Brass-Blow-Plug-36153/dp/B0006IX68O?tag=rollingreno-20`
- **Disclosure placement:** Existing disclosure appears in meta/content context; verify it appears in body before the first product CTA after WP update.
- **Internal links to add/strengthen:**
  - `/rv-renovation-water-damage-mistakes/`
  - `/rv-roof-reseal-before-renovation/`
  - `/rv-kitchen-storage-ideas-small-spaces/`
  - `/rv-wall-panel-replacement/`
- **Safety note:** Keep pressure testing conservative; avoid advising over-pressurizing plumbing.

### 7. RV Insulation Upgrades — `/rv-insulation-upgrades-four-season/` — post ID 254

- **Focus keyword:** RV insulation upgrades
- **SEO title:** RV Insulation Upgrades: Add Comfort Without Trapping Moisture
- **Meta description:** Compare RV insulation upgrade options, where to add comfort, and how to avoid trapping moisture behind walls, floors, and cabinets.
- **Affiliate CTAs:**
  1. Existing CTA can remain: 3M Thinsulate SM600L.  
     URL: `https://www.amazon.com/SM600L-Automotive-Camper-Insulation-Inch/dp/B0DP3NGNGQ?tag=rollingreno-20`
  2. Add near seam/air sealing prep only if copy supports it: “For clean prep before insulation, compare 3M foil tape on Amazon.”  
     URL: `https://www.amazon.com/3M-3381-Foil-Tape-1-88/dp/B00A7I5R6A?tag=rollingreno-20`
- **Disclosure placement:** Before Thinsulate CTA if not already present in body.
- **Internal links to add/strengthen:**
  - `/rv-wall-panel-replacement/`
  - `/rv-renovation-water-damage-mistakes/`
  - `/rv-roof-reseal-before-renovation/`
  - `/rv-renovation-weight-checklist/`
- **Safety note:** Keep the warning against trapping moisture; do not imply insulation fixes leaks.

### 8. RV Roof Reseal Before Renovation — `/rv-roof-reseal-before-renovation/` — post ID 250

- **Focus keyword:** RV roof reseal before renovation
- **SEO title:** RV Roof Reseal Before Renovation: Stop Leaks Before Interior Work
- **Meta description:** Reseal RV roof seams, vents, and penetrations before renovation so leaks do not ruin new walls, floors, cabinets, or insulation.
- **Affiliate CTAs:**
  1. Existing CTA can remain: Dicor self-leveling lap sealant.  
     URL: `https://www.amazon.com/Dicor-501LSW-1-Self-Leveling-Sealant-Pack/dp/B00G6KGPFM?tag=rollingreno-20`
  2. Add near inspection/testing: “For checking questionable ceiling or wall areas after a leak, compare the Klein Tools ET140 pinless moisture meter on Amazon.”  
     URL: `https://www.amazon.com/Klein-Tools-ET140-Non-Destructive-Detection/dp/B07SZX8QXH?tag=rollingreno-20`
- **Disclosure placement:** Before sealant CTA if not already present in body.
- **Internal links to add/strengthen:**
  - `/rv-renovation-water-damage-mistakes/`
  - `/rv-wall-panel-replacement/`
  - `/rv-subfloor-repair-soft-spots/`
  - `/rv-leak-prevention-kit-amazon/`
- **Safety note:** Include material compatibility warning for roof membranes and vertical vs horizontal sealants.

### 9. RV Renovation Mistakes That Cause Water Damage — `/rv-renovation-water-damage-mistakes/` — post ID 242

- **Focus keyword:** RV renovation water damage
- **SEO title:** RV Renovation Water Damage Mistakes: Avoid Soft Floors and Hidden Leaks
- **Meta description:** Avoid RV renovation mistakes that cause water damage, from sealing over leaks to hiding soft floors, wall rot, and plumbing drips behind new finishes.
- **Affiliate CTAs:**
  1. After the “verify it is dry” section: “For checking suspect floors and wall panels before you cover them, compare the Klein Tools ET140 pinless moisture meter on Amazon.”  
     URL: `https://www.amazon.com/Klein-Tools-ET140-Non-Destructive-Detection/dp/B07SZX8QXH?tag=rollingreno-20`
  2. Optional if the post has a roof/sealant mistake section: “For roof seam repairs where compatible, compare Dicor self-leveling lap sealant on Amazon.”  
     URL: `https://www.amazon.com/Dicor-501LSW-1-Self-Leveling-Sealant-Pack/dp/B00G6KGPFM?tag=rollingreno-20`
- **Disclosure placement:** Before the first moisture-meter CTA.
- **Internal links to add/strengthen:**
  - `/rv-roof-reseal-before-renovation/`
  - `/rv-wall-panel-replacement/`
  - `/rv-water-system-upgrade-pex-pump/`
  - `/rv-subfloor-repair-soft-spots/`
  - `/rv-leak-prevention-kit-amazon/`
- **Copy note:** Keep the tone cautionary and practical. Do not turn this into a shopping page.

### 10. RV Kitchen Storage Ideas — `/rv-kitchen-storage-ideas-small-spaces/` — post ID 256

- **Focus keyword:** RV kitchen storage ideas
- **SEO title:** RV Kitchen Storage Ideas: Small-Space Upgrades That Stay Put
- **Meta description:** Practical RV kitchen storage ideas for small spaces, with road-safe organizers, non-slip cabinet liner, weight-aware storage, and fewer rattles.
- **Affiliate CTAs:**
  1. Existing CTA can remain: Gorilla Grip drawer/shelf liner.  
     URL: `https://www.amazon.com/Gorilla-Grip-Drawer-Shelf-Liners/dp/B07773PQG7?tag=rollingreno-20`
  2. Add near vertical/spice storage only if the copy supports road-safety caveats: “For lightweight cabinet-door storage, compare the SimpleHouseware over-door organizer on Amazon and install only where it will not swing loose in transit.”  
     URL: `https://www.amazon.com/SimpleHouseware-Crystal-Hanging-Organizer-Holders/dp/B01D58DRVC?tag=rollingreno-20`
- **Disclosure placement:** Before existing shelf-liner CTA if not already present in body.
- **Internal links to add/strengthen:**
  - `/rv-renovation-weight-checklist/`
  - `/rv-storage-upgrades-small-camper-amazon/`
  - `/lightweight-rv-remodel-materials-amazon/`
  - `/rv-renovation-tool-kit-weekend-projects/`
- **Safety note:** Product mentions should stress secure installation and weight distribution.

---

## WP/apply blocker

This package is ready for copy/affiliate review and later implementation, but I cannot apply it live from this runtime because valid WordPress REST/app-password credentials are not available here. Needed action:

1. Provide or restore a valid WordPress REST application password for the Rolling Reno publishing user in the accessible secret store/runtime.
2. Confirm the media/default featured-image prerequisite for publisher flows if any of these page edits trigger republish/update automation.
3. After credentials are restored, apply the approved changes and run live QA against the 10 URLs.

## Handoff checklist for implementation

- [ ] Sarah copy/affiliate review approves final page specs.
- [ ] WP credentials are available to the publishing runtime.
- [ ] Apply page/post metadata and body edits.
- [ ] Verify HTTP 200 for each URL.
- [ ] Verify canonical URLs unchanged.
- [ ] Verify disclosure before first affiliate link on posts with affiliate CTAs.
- [ ] Verify every Amazon URL includes `tag=rollingreno-20`.
- [ ] Verify every Amazon link has `rel="sponsored nofollow noopener"` and `target="_blank"`.
- [ ] Verify homepage/blog hub links route to the priority posts.
- [ ] Log final before/after notes in `reports/`.
