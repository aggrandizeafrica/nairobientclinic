# Nairobi ENT Clinic – 2026 website redesign

This repository saves the redesigned version of [nairobientclinic.com](https://nairobientclinic.com), captured on 19 November 2026 just before the live site was rolled back to its previous design.

It holds two things:

| Folder | What it is | Used for |
| --- | --- | --- |
| `site/` | A static copy of all 92 pages of the redesigned site, with their images, styles and scripts | Hosting a viewable copy on Vercel |
| `wordpress-theme/medcity-child/` | The WordPress child theme that produces the redesign | Putting the redesign back on the real WordPress site |

## Viewing the copy on Vercel

`vercel.json` tells Vercel to serve the `site/` folder as-is, with no build step. Import this repository at [vercel.com/new](https://vercel.com/new) and keep the default settings.

The copy is sent with a `noindex` header and a `robots.txt` that blocks search engines, so Google doesn't treat it as a duplicate of the real site.

Because it is a static copy, anything that needs WordPress won't work there:

- the online appointment booking;
- the contact forms;
- blog pages that weren't captured.

Pages and links that were captured work fully, including the smooth scrolling, menus and animations.

## Putting the redesign back on WordPress

The redesign is still installed on the WordPress server, just switched off. To turn it back on:

1. Log in to WordPress as an administrator.
2. Visit `https://nairobientclinic.com/wp-admin/?nent_redesign=on`.

To switch back to the old design: `https://nairobientclinic.com/wp-admin/?nent_redesign=off`.

While the redesign is off, logged-in administrators still see the new design, so it can be previewed; add `?nent_old=1` to any page to see the old one. The page cache clears itself when the setting changes.

If the theme files are ever lost from the server, upload the contents of `wordpress-theme/medcity-child/` to `wp-content/themes/medcity-child/` (the parent `medcity` theme must be installed), then use the switch above.

### Theme layout

- `functions.php`: the child theme's functions, which load `nent/setup.php`, plus the SEO and speed fixes from the earlier audit (these stay active whichever design is on).
- `header.php`, `footer.php`, `front-page.php`: use the new design when the redesign is on, and fall back to the parent theme otherwise.
- `nent/`: the redesign itself:
  - `setup.php`: the on/off switch and asset loading
  - `data.php`: menu, services, conditions, doctors, clinics and phone numbers
  - `home.php`: homepage sections
  - `header-bar.php`, `footer-bar.php`, `page-hero.php`: site header, footer and page banners
  - `nent.css`, `nent.js`: styles and interactions
  - `lenis.min.js`: smooth scrolling (MIT licence)
