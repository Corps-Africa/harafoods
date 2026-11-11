# Managing your website — quick guide for HaRa Foods

Log in at **yoursite.com/wp-admin**.

## Orders
**WooCommerce → Orders.** New orders arrive by email too.
- *Pay on delivery* orders start as **Processing** — call or WhatsApp the customer, deliver, then mark **Completed**.
- *Paystack* orders are paid already — pack, deliver, mark **Completed**. The customer gets an email at each step.
- Refunds: open the order → **Refund**. Paystack refunds go back to the customer's MoMo wallet or card.

## Products
**Products → Add New** (or open an existing one).
- Title, long description (main box), **Product short description** (shown next to the price)
- **Product data**: *Simple product* for one size; *Variable product* for several pack sizes (Attributes → "Pack size" → Variations → set each price)
- **Inventory**: tick *Manage stock* and enter quantity; the product shows "Out of stock" automatically at 0
- **Product image** (right side) + **Product gallery** for extra photos
- **Product categories**: tick one
- Tick the ★ in the products list to feature a product on the homepage

## Enquiries
**Enquiries** (left menu) lists every contact and wholesale form message, with a red counter for unread ones.
Each one is also emailed to the address in HaRa Settings.

## Contact details, WhatsApp, social links
**HaRa Settings** — change once, updates everywhere (header, footer, contact page, WhatsApp buttons, Google).
The WhatsApp button appears as soon as a WhatsApp number is saved.

## Pages
**Pages** → open a page → click any text to edit. Sections are "Group" blocks; you can duplicate, move or delete them
with the block toolbar. To add a section like testimonials or a form, add a **Shortcode** block:

| Shortcode | Shows |
|---|---|
| `[hara_testimonials count="3"]` | Testimonials |
| `[hara_latest_posts count="3"]` | Latest news posts |
| `[hara_contact_form]` / `[hara_wholesale_form]` | Enquiry forms |
| `[hara_whatsapp_button text="Chat with us"]` | WhatsApp button |
| `[hara_contact_details]`, `[hara_map]`, `[hara_social_links]`, `[hara_instagram]` | Contact info, map, social icons, Instagram |
| `[products limit="4" category="dried-fruits"]` | Products from a category |

## News & testimonials
- **Posts → Add New** for news, recipes and impact stories. Add a *Featured image* for the card.
- **Testimonials → Add New**: name in the title, quote in the text box, role/town in the side box.

## Menus
**Appearance → Menus** — Main menu, Footer: company, Footer: help & legal.

## Good habits
- Keep WordPress and plugins updated (Dashboard → Updates) after taking a backup
- Give each staff member their own login; use the **Shop manager** role for people who only handle orders/products
- Photos: square, at least 1200 px, under 500 KB (compress with squoosh.app)
