<?php
/**
 * WhatsApp click-to-chat: floating button on every page + "Ask about this product" on product pages.
 * Hidden automatically until a WhatsApp number is saved in HaRa Settings.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', function () {
	$url = hara_whatsapp_url();
	if ( ! $url || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
		return;
	}
	printf(
		'<a class="hara-wa-float" href="%s" target="_blank" rel="noopener" aria-label="Chat with HaRa Foods on WhatsApp">%s<span class="hara-wa-float__label">Chat with us</span></a>',
		esc_url( $url ),
		hara_icon( 'whatsapp' ) // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
	);
} );

add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$url = hara_whatsapp_url( sprintf( 'Hello HaRa Foods, I have a question about %s (%s).', $product->get_name(), get_permalink( $product->get_id() ) ) );
	if ( ! $url ) {
		return;
	}
	printf(
		'<p class="hara-product-wa"><a class="hara-btn hara-btn--whatsapp-outline" href="%s" target="_blank" rel="noopener">%sAsk about this product on WhatsApp</a></p>',
		esc_url( $url ),
		hara_icon( 'whatsapp' ) // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
	);
}, 35 );

