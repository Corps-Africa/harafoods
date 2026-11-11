#!/usr/bin/env bash
# One-command local setup: downloads plugins, starts Docker, provisions WordPress + WooCommerce.
# Safe to re-run: provisioning is idempotent.
set -euo pipefail
cd "$(dirname "$0")/.."

[ -f .env ] || cp .env.example .env
set -a; . ./.env; set +a

WOO_URL="https://github.com/woocommerce/woocommerce/releases/latest/download/woocommerce.zip"
PAYSTACK_REPO="https://github.com/PaystackOSS/woo-paystack"
PAYSTACK_TAG="v5.8.6"

mkdir -p .cache/plugins
if [ ! -f .cache/plugins/woocommerce.zip ]; then
  echo "→ Downloading WooCommerce…"
  curl -fsSL -o .cache/plugins/woocommerce.zip "$WOO_URL"
fi
if [ ! -f .cache/plugins/woo-paystack.zip ]; then
  echo "→ Downloading Paystack for WooCommerce ($PAYSTACK_TAG)…"
  tmp="$(mktemp -d)"
  git clone -q --depth 1 --branch "$PAYSTACK_TAG" "$PAYSTACK_REPO" "$tmp/woo-paystack"
  rm -rf "$tmp/woo-paystack/.git"
  (cd "$tmp" && zip -qr woo-paystack.zip woo-paystack)
  mv "$tmp/woo-paystack.zip" .cache/plugins/
  rm -rf "$tmp"
fi

echo "→ Starting containers…"
docker compose up -d db wordpress

echo "→ Waiting for WordPress files…"
for _ in $(seq 1 60); do
  docker compose exec -T wordpress test -f /var/www/html/wp-config.php && break
  sleep 2
done

echo "→ Provisioning…"
docker compose run --rm -T \
  -e SITE_URL="$SITE_URL" -e ADMIN_USER="$ADMIN_USER" -e ADMIN_PASSWORD="$ADMIN_PASSWORD" -e ADMIN_EMAIL="$ADMIN_EMAIL" \
  cli bash /scripts/provision.sh

echo
echo "✓ Done. Storefront: $SITE_URL   Admin: $SITE_URL/wp-admin  ($ADMIN_USER / $ADMIN_PASSWORD)"
