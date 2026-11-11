<?php
/**
 * Store configuration + starter content for HaRa Foods Ltd.
 * Run with:  docker compose run --rm cli wp eval-file /scripts/provision.php
 *
 * Idempotent: safe to run again. Pages/posts/products are only (re)written while they
 * still match the seeded version — anything edited in WP Admin is left alone.
 * Force a rewrite of seeded content with HARA_FORCE=1.
 *
 * Content marked [SAMPLE] or "to be confirmed" is a placeholder until HaRa Foods
 * supplies final text, photos and prices.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Run with wp eval-file\n" );
}

require __DIR__ . '/lib/blocks.php';
require __DIR__ . '/content/pages.php';
require __DIR__ . '/content/products.php';
require __DIR__ . '/content/posts.php';

$force = (bool) getenv( 'HARA_FORCE' );

function hara_log( $msg ) {
	WP_CLI::log( '  ' . $msg );
}

/**
 * Create or update a post while it still matches what we seeded last time.
 */
function hara_seed_post( array $args, $force = false ) {
	$type     = $args['post_type'] ?? 'page';
	$slug     = $args['post_name'];
	$existing = get_page_by_path( $slug, OBJECT, $type );
	$hash     = md5( ( $args['post_content'] ?? '' ) . '|' . ( $args['post_title'] ?? '' ) . '|' . ( $args['post_excerpt'] ?? '' ) );
	$meta     = $args['meta'] ?? array();
	unset( $args['meta'] );

	if ( $existing ) {
		$seeded = get_post_meta( $existing->ID, '_hara_seed_hash', true );
		$edited = $seeded && md5( $existing->post_content . '|' . $existing->post_title . '|' . $existing->post_excerpt ) !== $seeded;
		if ( ( $edited || ! $seeded ) && ! $force ) {
			return $existing->ID; // Edited by a person (or not ours) — leave it.
		}
		$args['ID'] = $existing->ID;
		wp_update_post( wp_slash( $args ) );
		$id = $existing->ID;
	} else {
		$args += array( 'post_status' => 'publish', 'post_type' => $type );
		$id    = wp_insert_post( wp_slash( $args ), true );
		if ( is_wp_error( $id ) ) {
			WP_CLI::warning( $id->get_error_message() );
			return 0;
		}
	}
	$post = get_post( $id );
	update_post_meta( $id, '_hara_seed_hash', md5( $post->post_content . '|' . $post->post_title . '|' . $post->post_excerpt ) );
	foreach ( $meta as $k => $v ) {
		update_post_meta( $id, $k, $v );
	}
	unset( $hash );
	return $id;
}

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ General settings' );

update_option( 'blogname', 'HaRa Foods Ltd' );
update_option( 'blogdescription', 'Naturally Solar Dried Goodness' );
update_option( 'default_comment_status', 'closed' );
update_option( 'default_ping_status', 'closed' );
update_option( 'posts_per_page', 9 );
update_option( 'start_of_week', 1 );
update_option( 'WPLANG', '' );
update_option( 'uploads_use_yearmonth_folders', 1 );

$settings = get_option( 'hara_settings', array() );
update_option( 'hara_settings', array_merge( array(
	'phone'          => '',
	'whatsapp'       => '',
	'email'          => 'harafoodsltd@gmail.com',
	'address'        => "Bole\nSavannah Region, Ghana",
	'map_query'      => 'Bole, Savannah Region, Ghana',
	'hours'          => '',
	'whatsapp_text'  => 'Hello HaRa Foods, I would like to know more about your products.',
	'instagram'      => 'https://www.instagram.com/harafoods_ltd/',
	'linkedin'       => 'https://www.linkedin.com/company/hara-foods-ltd/',
	'facebook'       => '',
	'tiktok'         => '',
	'youtube'        => '',
	'announcement'   => 'Solar-dried in Bole, Savannah Region · Delivery across Ghana · Pay with Mobile Money or card',
	'enquiry_emails' => 'harafoodsltd@gmail.com',
), array_filter( (array) $settings ) ) );

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ WooCommerce store settings' );

if ( ! class_exists( 'WooCommerce' ) ) {
	WP_CLI::error( 'WooCommerce is not active.' );
}

WC_Install::create_pages();

$wc_options = array(
	'woocommerce_store_address'                        => 'Bole',
	'woocommerce_store_address_2'                      => '',
	'woocommerce_store_city'                           => 'Bole',
	'woocommerce_default_country'                      => 'GH:SV',
	'woocommerce_store_postcode'                       => '',
	'woocommerce_allowed_countries'                    => 'specific',
	'woocommerce_specific_allowed_countries'           => array( 'GH' ),
	'woocommerce_ship_to_countries'                    => '',
	'woocommerce_default_customer_address'             => 'base',
	'woocommerce_currency'                             => 'GHS',
	'woocommerce_currency_pos'                         => 'left',
	'woocommerce_price_thousand_sep'                   => ',',
	'woocommerce_price_decimal_sep'                    => '.',
	'woocommerce_price_num_decimals'                   => '2',
	'woocommerce_weight_unit'                          => 'g',
	'woocommerce_dimension_unit'                       => 'cm',
	'woocommerce_calc_taxes'                           => 'no',
	'woocommerce_enable_reviews'                       => 'yes',
	'woocommerce_review_rating_verification_required'  => 'yes',
	'woocommerce_enable_guest_checkout'                => 'yes',
	'woocommerce_enable_checkout_login_reminder'       => 'yes',
	'woocommerce_enable_signup_and_login_from_checkout' => 'yes',
	'woocommerce_enable_myaccount_registration'        => 'yes',
	'woocommerce_registration_generate_password'       => 'yes',
	'woocommerce_manage_stock'                         => 'yes',
	'woocommerce_notify_low_stock_amount'              => '10',
	'woocommerce_hold_stock_minutes'                   => '60',
	'woocommerce_coming_soon'                          => 'no',
	'woocommerce_store_pages_only'                     => 'no',
	'woocommerce_show_marketplace_suggestions'         => 'no',
	'woocommerce_allow_tracking'                       => 'no',
	'woocommerce_task_list_hidden'                     => 'yes',
	'woocommerce_task_list_complete'                   => 'yes',
	'woocommerce_extended_task_list_hidden'            => 'yes',
	'woocommerce_onboarding_profile'                   => array( 'skipped' => true ),
	'woocommerce_email_from_name'                      => 'HaRa Foods Ltd',
	'woocommerce_email_from_address'                   => 'harafoodsltd@gmail.com',
	'woocommerce_email_header_image'                   => get_theme_file_uri( 'assets/img/logo-email.png' ),
	'woocommerce_email_base_color'                     => '#1F6B2A',
	'woocommerce_email_background_color'               => '#FFF8EC',
	'woocommerce_email_body_background_color'          => '#FFFFFF',
	'woocommerce_email_text_color'                     => '#1D2B1F',
	'woocommerce_email_footer_text'                    => 'HaRa Foods Ltd · Bole, Savannah Region, Ghana · Naturally Solar Dried Goodness',
	'woocommerce_thumbnail_cropping'                   => '1:1',
	'woocommerce_checkout_phone_field'                 => 'required',
	'woocommerce_checkout_company_field'               => 'optional',
	'woocommerce_checkout_address_2_field'             => 'optional',
);
foreach ( $wc_options as $key => $value ) {
	update_option( $key, $value );
}

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Shipping zones (fees are placeholders — confirm with HaRa Foods)' );

$zones = array(
	array(
		'name'      => 'Bole & Savannah Region',
		'locations' => array( 'GH:SV' ),
		'flat'      => array( 'title' => 'Delivery within Savannah Region', 'cost' => '20' ),
		'pickup'    => true,
	),
	array(
		'name'      => 'Northern Ghana',
		'locations' => array( 'GH:NP', 'GH:NE', 'GH:UE', 'GH:UW', 'GH:BE', 'GH:BO' ),
		'flat'      => array( 'title' => 'Delivery to Northern Ghana', 'cost' => '40' ),
		'pickup'    => true,
	),
	array(
		'name'      => 'Rest of Ghana',
		'locations' => array( 'GH' ),
		'flat'      => array( 'title' => 'Delivery across Ghana (bus courier)', 'cost' => '60' ),
		'pickup'    => true,
	),
);

$existing_zones = wp_list_pluck( WC_Shipping_Zones::get_zones(), 'zone_name', 'id' );
foreach ( $zones as $order => $z ) {
	if ( in_array( $z['name'], $existing_zones, true ) ) {
		continue;
	}
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( $z['name'] );
	$zone->set_zone_order( $order );
	foreach ( $z['locations'] as $loc ) {
		$zone->add_location( $loc, false === strpos( $loc, ':' ) ? 'country' : 'state' );
	}
	$zone->save();

	$instance = $zone->add_shipping_method( 'flat_rate' );
	update_option( 'woocommerce_flat_rate_' . $instance . '_settings', array(
		'title'      => $z['flat']['title'],
		'tax_status' => 'none',
		'cost'       => $z['flat']['cost'],
	) );

	if ( $z['pickup'] ) {
		$pickup = $zone->add_shipping_method( 'local_pickup' );
		update_option( 'woocommerce_local_pickup_' . $pickup . '_settings', array(
			'title'      => 'Pick up from HaRa Foods, Bole (free)',
			'tax_status' => 'none',
			'cost'       => '',
		) );
	}
	hara_log( 'Zone: ' . $z['name'] );
}

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Payment methods' );

update_option( 'woocommerce_cod_settings', array_merge( (array) get_option( 'woocommerce_cod_settings', array() ), array(
	'enabled'            => 'yes',
	'title'              => 'Pay on delivery (cash or Mobile Money)',
	'description'        => 'Pay the rider in cash or by Mobile Money when your order arrives. Available for deliveries and pickups in Ghana.',
	'instructions'       => 'Please have cash or your Mobile Money wallet ready when your order arrives. We will call or WhatsApp you to arrange delivery.',
	'enable_for_methods' => array(),
	'enable_for_virtual' => 'yes',
) ) );

// Paystack: Mobile Money (MTN, Telecel, AirtelTigo) + Visa/Mastercard.
// Disabled until HaRa Foods adds its API keys (Paystack Dashboard → Settings → API Keys & Webhooks).
$paystack = (array) get_option( 'woocommerce_paystack_settings', array() );
update_option( 'woocommerce_paystack_settings', array_merge( array(
	'enabled'                    => 'no',
	'testmode'                   => 'yes',
	'test_secret_key'            => '',
	'test_public_key'            => '',
	'live_secret_key'            => '',
	'live_public_key'            => '',
	'payment_page'               => 'redirect',
	'autocomplete_order'         => 'no',
	'remove_cancel_order_button' => 'no',
	'saved_cards'                => 'no',
), $paystack, array(
	'title'       => 'Mobile Money or card (Paystack)',
	'description' => 'Pay securely with MTN MoMo, Telecel Cash, AirtelTigo Money, Visa or Mastercard.',
) ) );

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Pages' );

// Remove WordPress/WooCommerce demo content before seeding (the default privacy and
// refund drafts would otherwise block our slugs).
foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
	$p = get_page_by_path( $slug, OBJECT, $type );
	if ( $p ) {
		wp_delete_post( $p->ID, true );
	}
}
foreach ( get_posts( array( 'post_type' => 'page', 'post_status' => 'draft', 'numberposts' => 20 ) ) as $p ) {
	if ( in_array( $p->post_name, array( 'privacy-policy', 'refund_returns' ), true ) && ! get_post_meta( $p->ID, '_hara_seed_hash', true ) ) {
		wp_delete_post( $p->ID, true );
	}
}

$page_ids = array();
foreach ( hara_pages() as $slug => $page ) {
	$page_ids[ $slug ] = hara_seed_post( array(
		'post_type'    => 'page',
		'post_name'    => $slug,
		'post_title'   => $page['title'],
		'post_excerpt' => $page['excerpt'] ?? '',
		'post_content' => $page['content'],
		'menu_order'   => $page['order'] ?? 0,
	), $force );
	hara_log( $page['title'] );
}

// WooCommerce page titles/excerpts.
foreach ( array( 'shop' => 'Shop', 'cart' => 'Cart', 'checkout' => 'Checkout', 'myaccount' => 'My account' ) as $wc_page => $title ) {
	$id = wc_get_page_id( $wc_page );
	if ( $id > 0 ) {
		$page_ids[ 'wc_' . $wc_page ] = $id;
		wp_update_post( array( 'ID' => $id, 'post_title' => $title ) );
	}
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_ids['home'] );
update_option( 'page_for_posts', $page_ids['news'] );
update_option( 'wp_page_for_privacy_policy', $page_ids['privacy-policy'] );
update_option( 'woocommerce_terms_page_id', $page_ids['terms'] );
update_option( 'woocommerce_refund_returns_page_id', $page_ids['delivery-returns'] );


/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Product categories & sample products' );
hara_seed_products( $force );

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Blog posts & testimonials' );
hara_seed_posts( $force );

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Menus' );

function hara_build_menu( $name, $location, array $items ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( $menu ) {
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations[ $location ] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
		return; // Don't overwrite a menu someone may have edited.
	}
	$menu_id = wp_create_nav_menu( $name );
	foreach ( $items as $pos => $item ) {
		$args = array(
			'menu-item-title'    => $item[0],
			'menu-item-status'   => 'publish',
			'menu-item-position' => $pos + 1,
		);
		if ( is_int( $item[1] ) ) {
			$args['menu-item-object-id'] = $item[1];
			$args['menu-item-object']    = 'page';
			$args['menu-item-type']      = 'post_type';
		} else {
			$args['menu-item-url']  = $item[1];
			$args['menu-item-type'] = 'custom';
		}
		wp_update_nav_menu_item( $menu_id, 0, $args );
	}
	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	hara_log( $name );
}

hara_build_menu( 'Main menu', 'primary', array(
	array( 'Shop', $page_ids['wc_shop'] ),
	array( 'About', $page_ids['about'] ),
	array( 'Our Impact', $page_ids['impact'] ),
	array( 'Wholesale', $page_ids['wholesale'] ),
	array( 'News', $page_ids['news'] ),
	array( 'FAQ', $page_ids['faq'] ),
	array( 'Contact', $page_ids['contact'] ),
) );
hara_build_menu( 'Footer: company', 'footer', array(
	array( 'About us', $page_ids['about'] ),
	array( 'Our impact', $page_ids['impact'] ),
	array( 'Wholesale & partners', $page_ids['wholesale'] ),
	array( 'News & stories', $page_ids['news'] ),
	array( 'Contact', $page_ids['contact'] ),
) );
hara_build_menu( 'Footer: help & legal', 'legal', array(
	array( 'FAQ', $page_ids['faq'] ),
	array( 'Delivery & returns', $page_ids['delivery-returns'] ),
	array( 'My account', $page_ids['wc_myaccount'] ),
	array( 'Terms & conditions', $page_ids['terms'] ),
	array( 'Privacy policy', $page_ids['privacy-policy'] ),
) );

/* ------------------------------------------------------------------ */
WP_CLI::log( '→ Site icon' );
if ( ! get_option( 'site_icon' ) ) {
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	$src = get_theme_file_path( 'assets/img/site-icon.png' );
	$tmp = wp_tempnam( 'site-icon.png' );
	copy( $src, $tmp );
	$att = media_handle_sideload( array( 'name' => 'hara-site-icon.png', 'tmp_name' => $tmp ), 0, 'HaRa Foods icon' );
	if ( ! is_wp_error( $att ) ) {
		update_option( 'site_icon', $att );
	}
}

flush_rewrite_rules();
WP_CLI::success( 'HaRa Foods provisioned.' );
