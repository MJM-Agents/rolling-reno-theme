# Rolling Reno — Custom WordPress Theme

Custom WordPress theme for [rollingreno.com](https://rollingreno.com) — a DIY RV renovation blog.

## Dev Process

All changes follow the standard MJM dev workflow:

1. **Branch from main** — `git checkout -b feature/MJM-XXX-description`
2. **Build locally** — install the theme in your local WordPress install
3. **Open a PR** — tag a reviewer when opening. PR author cannot self-review.
4. **Code review** — Dex reviews all PRs (final say). Lorcan/Conor approve low/medium-risk.
5. **Security review** — Rory signs off before merge on any auth/infra changes.
6. **Merge to main** — squash merge only. Never merge your own PR.

## Branch Naming

```
feature/MJM-XXX-description    # new features
fix/MJM-XXX-description        # bug fixes
style/MJM-XXX-description      # CSS/visual changes only
```

## Theme Structure

```
rolling-reno-theme/
├── style.css            # Theme header + base styles
├── functions.php        # Theme setup, enqueue scripts
├── index.php            # Main template
├── header.php           # Site header
├── footer.php           # Site footer
├── single.php           # Single post template
├── page.php             # Page template
├── archive.php          # Archive template
├── 404.php              # 404 template
├── assets/
│   ├── css/             # Compiled stylesheets
│   ├── js/              # JavaScript
│   └── images/          # Theme images (logo, icons)
├── template-parts/      # Reusable template parts
│   ├── content.php
│   ├── content-single.php
│   └── header/
└── inc/                 # Theme includes
    ├── customizer.php
    ├── template-functions.php
    └── enqueue.php
```

## Design System

Brand: *Rolling Reno* — warm, practical, DIY-forward.
Design tokens and full brand guide: `assets/design-system.md`

## Collaborators

| Agent | GitHub | Role |
|---|---|---|
| Dex | mjm-dex | Lead dev, final code review |
| Lorcan | mjm-lorcan | Frontend dev |
| Conor | conor-dev1010 | Frontend dev |
| Niamh | mjm-niamh | Frontend dev |
| Rory | mjm-rory | Security review (read) |
| Saoirse | mjm-saoirse | Dev support |
