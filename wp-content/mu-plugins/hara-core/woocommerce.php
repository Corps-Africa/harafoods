<?php
/**
 * Store behaviour tweaks for a Ghanaian shop.
 * (Visual WooCommerce changes live in the theme: wp-content/themes/hara/inc/woocommerce.php)
 */

defined( 'ABSPATH' ) || exit;

// mu-plugins load before regular plugins, so wait for WooCommerce.
add_action( 'plugins_loaded', function () {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Phone is the main way to coordinate delivery in Ghana: make it required.
	add_filter( 'woocommerce_billing_fields', function ( $fields ) {
		if ( isset( $fields['billing_phone'] ) ) {
			$fields['billing_phone']['required'] = true;
			$fields['billing_phone']['label']    = 'Phone / WhatsApp';
		}
		if ( isset( $fields['billing_postcode'] ) ) {
			$fields['billing_postcode']['required'] = false; // Ghana Post GPS codes are optional.
			$fields['billing_postcode']['label']    = 'GhanaPost GPS address (optional)';
		}
		return $fields;
	} );

	add_filter( 'woocommerce_default_address_fields', function ( $fields ) {
		if ( isset( $fields['postcode'] ) ) {
			$fields['postcode']['required'] = false;
			$fields['postcode']['label']    = 'GhanaPost GPS address (optional)';
		}
		if ( isset( $fields['address_2'] ) ) {
			$fields['address_2']['placeholder'] = 'Landmark, e.g. near the central mosque';
		}
		return $fields;
	} );

	add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
		if ( isset( $fields['order']['order_comments'] ) ) {
			$fields['order']['order_comments']['placeholder'] = 'Delivery instructions, best time to call, or anything else we should know.';
		}
		return $fields;
	} );

	// Reasonable defaults for the shop grid.
	add_filter( 'loop_shop_per_page', function () { return 12; } );
} );
