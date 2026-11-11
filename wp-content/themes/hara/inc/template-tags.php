<?php
defined( 'ABSPATH' ) || exit;

function hara_logo( $width = 190 ) {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a class="hara-logo" href="%1$s" rel="home"><img src="%2$s" srcset="%2$s 240w, %3$s 480w" sizes="%4$dpx" width="%4$d" height="%5$d" alt="%6$s"></a>',
		esc_url( home_url( '/' ) ),
		esc_url( get_theme_file_uri( 'assets/img/logo-240.webp' ) ),
		esc_url( get_theme_file_uri( 'assets/img/logo-480.webp' ) ),
		(int) $width,
		(int) round( $width * 564 / 882 ),
		esc_attr__( 'HaRa Foods Ltd — Naturally Solar Dried Goodness', 'hara' )
	);
}

/** Page banner shown on inner pages (title + optional intro from the excerpt). */
function hara_page_banner( $title = null, $intro = null ) {
	$title = null === $title ? get_the_title() : $title;
	if ( null === $intro && is_singular() && has_excerpt() ) {
		$intro = get_the_excerpt();
	}
	echo '<header class="hara-banner"><div class="hara-container">';
	if ( function_exists( 'woocommerce_breadcrumb' ) && ! is_front_page() ) {
		woocommerce_breadcrumb( array(
			'wrap_before' => '<nav class="hara-breadcrumb" aria-label="Breadcrumb">',
			'wrap_after'  => '</nav>',
			'delimiter'   => '<span aria-hidden="true"> / </span>',
		) );
	}
	echo '<h1 class="hara-banner__title">' . wp_kses_post( $title ) . '</h1>';
	if ( $intro ) {
		echo '<p class="hara-banner__intro">' . esc_html( $intro ) . '</p>';
	}
	echo '</div></header>';
}

function hara_cart_link() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return '';
	}
	$count = WC()->cart->get_cart_contents_count();
	return sprintf(
		'<a class="hara-cart-link" href="%1$s" aria-label="%2$s"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 6h15l-1.5 9h-12z"/><path d="M6 6 5 2H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/></svg><span class="hara-cart-count%3$s">%4$d</span></a>',
		esc_url( wc_get_cart_url() ),
		/* translators: %d: items in cart */
		esc_attr( sprintf( _n( 'Cart, %d item', 'Cart, %d items', $count, 'hara' ), $count ) ),
		$count ? '' : ' is-empty',
		(int) $count
	);
}

function hara_account_link() {
	if ( ! function_exists( 'wc_get_page_permalink' ) ) {
		return '';
	}
	return sprintf(
		'<a class="hara-account-link" href="%1$s" aria-label="%2$s"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg></a>',
		esc_url( wc_get_page_permalink( 'myaccount' ) ),
		esc_attr( is_user_logged_in() ? __( 'My account', 'hara' ) : __( 'Sign in', 'hara' ) )
	);
}

/** Fallback menu so the header isn't empty before menus are configured. */
function hara_menu_fallback() {
	echo '<ul class="hara-menu">';
	foreach ( array( 'shop' => 'Shop', 'about' => 'About', 'impact' => 'Our Impact', 'wholesale' => 'Wholesale', 'news' => 'News', 'contact' => 'Contact' ) as $slug => $label ) {
		echo '<li><a href="' . esc_url( home_url( '/' . $slug . '/' ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

function hara_posted_on() {
	printf(
		'<p class="hara-meta"><time datetime="%1$s">%2$s</time>%3$s</p>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		get_the_category_list( ', ' ) ? ' · ' . get_the_category_list( ', ' ) : '' // phpcs:ignore WordPress.Security.EscapeOutput
	);
}
