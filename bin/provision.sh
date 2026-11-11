#!/usr/bin/env bash
# Runs inside the WP-CLI container. Installs WordPress, plugins and the HaRa theme,
# then hands over to provision.php for store configuration and starter content.
set -euo pipefail
cd /var/www/html

if ! wp core is-installed 2>/dev/null; then
  wp core install --url="$SITE_URL" --title="HaRa Foods Ltd" \
    --admin_user="$ADMIN_USER" --admin_password="$ADMIN_PASSWORD" --admin_email="$ADMIN_EMAIL" --skip-email
fi

wp plugin is-installed woocommerce  || wp plugin install /plugins-cache/woocommerce.zip
wp plugin is-installed woo-paystack || wp plugin install /plugins-cache/woo-paystack.zip
wp plugin activate woocommerce woo-paystack
wp plugin delete hello akismet 2>/dev/null || true

wp theme activate hara
wp theme delete twentytwentythree twentytwentyfour 2>/dev/null || true

wp option update blogdescription "Naturally Solar Dried Goodness"
wp option update timezone_string "Africa/Accra"
wp option update date_format "j F Y"
wp option update permalink_structure "/%postname%/"
wp rewrite flush --hard 2>/dev/null || wp rewrite flush

wp eval-file /scripts/provision.php
wp rewrite flush
