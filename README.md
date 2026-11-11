# HaRa Foods Ltd — website & online shop

WordPress + WooCommerce site for **HaRa Foods Ltd** (Bole, Savannah Region, Ghana) — *Naturally Solar Dried Goodness*.
Built by Mos EdTech as part of the Corps Africa Alumni free website campaign.

- **Shop:** WooCommerce, prices in GH₵, delivery zones for Ghana, free pickup in Bole
- **Payments:** Paystack (MTN MoMo, Telecel Cash, AirtelTigo Money, Visa, Mastercard) + pay on delivery
- **Pages:** Home, About, Our Impact, Wholesale & Partnerships, News (blog), FAQ, Contact, Delivery & Returns, Terms, Privacy
- **Extras:** WhatsApp click-to-chat (floating + per product), contact & wholesale enquiry forms saved in WP Admin, Google Map, Instagram/LinkedIn links, structured data for Google, branded order emails

## Repository layout

```
docker-compose.yml          Local stack: WordPress 7 (PHP 8.3), MariaDB 11, WP-CLI
bin/setup.sh                One command: download plugins, start Docker, provision
bin/provision.sh / .php     Installs plugins, configures WooCommerce, seeds pages/products/menus
bin/content/                Seed copy: pages.php, products.php (SAMPLE), posts.php (SAMPLE)
bin/lib/blocks.php          Helpers that write valid block-editor markup
wp-content/themes/hara/     Custom theme (presentation only)
wp-content/mu-plugins/      "HaRa Core" site plugin: settings, WhatsApp, forms, shortcodes, SEO
docs/                       Deployment guide, client guide, content checklist
```

Functionality lives in the **must-use plugin** (`hara-core`) so it keeps working if the theme is ever changed;
the theme only handles layout and styling.

## Run it locally

Requires Docker (with Compose) and git.

```bash
bin/setup.sh
```

Then open http://localhost:8080 — admin at http://localhost:8080/wp-admin (user/password in `.env`, created from `.env.example`).

Useful commands:

```bash
docker compose run --rm cli wp <command>                         # any WP-CLI command
docker compose run --rm cli wp eval-file /scripts/provision.php  # re-run provisioning (idempotent)
docker compose run --rm -e HARA_FORCE=1 cli wp eval-file /scripts/provision.php  # overwrite seeded content
docker compose down        # stop      (add -v to wipe the database and start fresh)
```

Provisioning only rewrites pages/posts that are unchanged since they were seeded — anything edited in WP Admin is left alone.

## Placeholder content — must be replaced before launch

Nothing below is real yet. See **[docs/CONTENT-CHECKLIST.md](docs/CONTENT-CHECKLIST.md)** for the full list of what we need from HaRa Foods.

| Item | Where | Status |
|---|---|---|
| 11 products (names, sizes, **prices**) | Products — SKUs start with `SAMPLE-` | Invented for layout; replace |
| Product photos | Products | Branded "photo coming soon" image |
| Delivery fees (GH₵20 / 40 / 60) | WooCommerce → Settings → Shipping | Placeholder |
| Phone & WhatsApp number | HaRa Settings | Empty — WhatsApp button stays hidden until set |
| Testimonials | Testimonials | 3 samples, clearly marked |
| Blog posts | Posts | 3 samples, clearly marked |
| Team bios/photos, founding story, vision | About page | `[To be confirmed]` markers |
| Impact numbers, partner logos | Our impact page | `[#]` markers |
| Terms, privacy, delivery & returns | Legal pages | Templates — client to review |
| Paystack API keys | WooCommerce → Settings → Payments → Paystack | Disabled until keys are added |

Search the admin for `[` or `SAMPLE` to find every placeholder.

## Deploying

See **[docs/DEPLOYMENT.md](docs/DEPLOYMENT.md)**. Short version: any host with PHP 8.3+, MySQL/MariaDB and HTTPS;
install WordPress, upload the theme + mu-plugin, install WooCommerce and Paystack from the plugin directory,
run `provision.php` with WP-CLI (or migrate the local database).

## Brand

| Token | Hex | Use |
|---|---|---|
| Leaf green | `#1F6B2A` | Links, accents |
| Deep green | `#123F1B` | Headings, footer, dark sections |
| Harvest orange | `#E3600B` | Primary buttons, prices |
| Sun yellow | `#F6B42C` | Highlights |
| Cream | `#FFF8EC` | Page background |

Colours were sampled from the HaRa Foods logo. Fonts: Fraunces (headings) and DM Sans (body), from Google Fonts.
