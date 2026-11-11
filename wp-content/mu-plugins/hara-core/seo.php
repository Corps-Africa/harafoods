<?php
/**
 * Lightweight SEO: meta description, Open Graph tags and LocalBusiness structured data.
 * Steps aside automatically if a dedicated SEO plugin (Yoast, Rank Math, SEOPress, AIOSEO) is installed.
 */

defined( 'ABSPATH' ) || exit;

function hara_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function hara_meta_description() {
	$default = 'HaRa Foods Ltd turns fresh produce from farmers in Ghana\'s Savannah Region into nutritious, solar-dried foods — reducing post-harvest losses and creating opportunities for women and young people.';
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( function_exists( 'is_product' ) && is_product() ) {
			$product = wc_get_product( $post->ID );
			$text    = $product ? $product->get_short_description() : '';
		} else {
			$text = has_excerpt( $post ) ? $post->post_excerpt : '';
		}
		if ( ! $text && ! is_front_page() ) {
			$text = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		}
		if ( $text ) {
			return wp_trim_words( wp_strip_all_tags( $text ), 28, '…' );
		}
	} elseif ( is_category() || is_tax() ) {
		$desc = term_description();
		if ( $desc ) {
			return wp_trim_words( wp_strip_all_tags( $desc ), 28, '…' );
		}
	}
	return $default;
}

add_action( 'wp_head', function () {
	if ( hara_seo_plugin_active() ) {
		return;
	}
	$desc  = hara_meta_description();
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
	$image = get_theme_file_uri( 'assets/img/og-default.jpg' );
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	}
	$type = ( function_exists( 'is_product' ) && is_product() ) ? 'product' : ( is_single() ? 'article' : 'website' );

	echo "\n" . '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	echo '<meta property="og:locale" content="en_GH">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}, 2 );

add_action( 'wp_head', function () {
	if ( ! is_front_page() && ! is_page( 'contact' ) ) {
		return;
	}
	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => array( 'LocalBusiness', 'FoodEstablishment' ),
		'@id'         => home_url( '/#business' ),
		'name'        => 'HaRa Foods Ltd',
		'slogan'      => 'Naturally Solar Dried Goodness',
		'description' => hara_meta_description(),
		'url'         => home_url( '/' ),
		'logo'        => get_theme_file_uri( 'assets/img/logo-480.webp' ),
		'image'       => get_theme_file_uri( 'assets/img/og-default.jpg' ),
		'email'       => hara_opt( 'email', get_option( 'admin_email' ) ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Bole',
			'addressRegion'   => 'Savannah Region',
			'addressCountry'  => 'GH',
		),
		'areaServed'  => 'GH',
	);
	if ( hara_opt( 'phone' ) ) {
		$data['telephone'] = hara_opt( 'phone' );
	}
	$same = wp_list_pluck( hara_social_profiles(), 'url' );
	if ( $same ) {
		$data['sameAs'] = array_values( $same );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
} );
