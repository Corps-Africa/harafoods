# Deploying the HaRa Foods site

HaRa Foods pays for its own domain and hosting (campaign terms). This guide covers going live.

## 1. Hosting requirements

Any shared or managed WordPress host with:

- WordPress **7.0+** (current WooCommerce requires it), PHP **8.3+**, MySQL 8 / MariaDB 10.6+
- Free SSL (Let's Encrypt) — **HTTPS is required** for Paystack
- SSH + WP-CLI (makes setup much easier; most cPanel hosts have it)
- At least 512 MB PHP memory, daily backups

Ghana-based hosts with cPanel work fine; so do international ones (e.g. Hostinger, Namecheap, SiteGround).
Expect roughly US$3–10/month plus about US$10–15/year for the domain.

**Domain:** the client already uses `harafoodsltd.com`. Point it at the new host only when the new site is ready
(see step 6), so the current site stays up meanwhile.

## 2. Install WordPress and plugins

1. Install WordPress from the host's control panel (Softaculous / "WordPress installer").
2. Plugins → Add New → install and activate:
   - **WooCommerce**
   - **Paystack WooCommerce Payment Gateway** (`woo-paystack`)
   - Recommended: **WP Mail SMTP** (reliable order/enquiry emails), **UpdraftPlus** (backups), **Wordfence** or similar (security)
   - Optional: **Smash Balloon Social Photo Feed** for a live Instagram feed — the site shows it automatically once connected
3. Delete unused default plugins and themes.

## 3. Upload the custom code

Upload from this repository (SFTP or File Manager):

```
wp-content/themes/hara/          →  wp-content/themes/hara/
wp-content/mu-plugins/           →  wp-content/mu-plugins/      (create the folder if missing)
```

Activate the **HaRa Foods** theme under Appearance → Themes.

## 4. Configure and seed content

Choose **one** option.

**A — Run provisioning on the server (recommended for a fresh site).**
Upload the `bin/` folder somewhere outside the web root (e.g. `~/hara-bin/`), then over SSH:

```bash
cd ~/public_html
wp eval-file ~/hara-bin/provision.php
```

This configures WooCommerce (GH₵, Ghana delivery zones, pay-on-delivery, Paystack settings, emails), creates all pages,
menus and sample products, and sets the homepage. It is safe to run again.

**B — Migrate the local database.** Build the site locally (`bin/setup.sh`), enter real content there, then move it
with a migration plugin (All-in-One WP Migration, Duplicator) or `wp db export` / `wp db import` followed by:

```bash
wp search-replace 'http://localhost:8080' 'https://www.harafoodsltd.com' --all-tables
```

## 5. Before go-live checklist

- [ ] All items in [CONTENT-CHECKLIST.md](CONTENT-CHECKLIST.md) replaced (no `SAMPLE-` SKUs, no `[…]` placeholders)
- [ ] **HaRa Settings**: phone, WhatsApp number, hours, enquiry email(s)
- [ ] **Paystack**: business account verified → WooCommerce → Settings → Payments → Paystack:
      paste **live** public + secret keys, untick Test mode, Payment option "Redirect", enable.
      In the Paystack dashboard set the webhook URL shown on that settings screen.
- [ ] Run one real order with a small amount by MoMo and by card, then refund it
- [ ] Delivery fees and zones confirmed (WooCommerce → Settings → Shipping)
- [ ] Emails: install WP Mail SMTP, send a test, place a test order and confirm both customer and admin emails arrive
- [ ] Settings → General: admin email is HaRa's; Settings → Reading: "Discourage search engines" **unticked**
- [ ] Legal pages reviewed by HaRa Foods
- [ ] Google Search Console: verify the domain, submit `https://www.harafoodsltd.com/wp-sitemap.xml`
- [ ] Google Business Profile updated with the new website link
- [ ] Backups scheduled; strong admin passwords; each staff member has their own login (Shop Manager role for staff)

## 6. Switch the domain

Update DNS at the domain registrar (A record or nameservers, as the host instructs). Allow up to 24 hours.
Then confirm Settings → General shows `https://www.harafoodsltd.com` for both addresses and force HTTPS in the host panel.
