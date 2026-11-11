<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'hara', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 190, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 480,
		'single_image_width'    => 800,
		'product_grid'          => array( 'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 4 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_editor_style( 'assets/css/editor.css' );

	// Brand palette in the block editor colour picker.
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => 'Leaf green', 'slug' => 'leaf', 'color' => '#1F6B2A' ),
		array( 'name' => 'Deep green', 'slug' => 'forest', 'color' => '#123F1B' ),
		array( 'name' => 'Harvest orange', 'slug' => 'harvest', 'color' => '#E3600B' ),
		array( 'name' => 'Sun yellow', 'slug' => 'sun', 'color' => '#F6B42C' ),
		array( 'name' => 'Cream', 'slug' => 'cream', 'color' => '#FFF8EC' ),
		array( 'name' => 'Ink', 'slug' => 'ink', 'color' => '#1D2B1F' ),
		array( 'name' => 'White', 'slug' => 'white', 'color' => '#FFFFFF' ),
	) );
	add_theme_support( 'disable-custom-colors' );

	register_nav_menus( array(
		'primary' => __( 'Main menu', 'hara' ),
		'footer'  => __( 'Footer: company', 'hara' ),
		'legal'   => __( 'Footer: help & legal', 'hara' ),
	) );

	add_image_size( 'hara-card', 640, 480, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'hara-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&display=swap', array(), null );
	wp_enqueue_style( 'hara-main', get_theme_file_uri( 'assets/css/main.css' ), array(), HARA_THEME_VERSION );
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'hara-shop', get_theme_file_uri( 'assets/css/shop.css' ), array( 'hara-main' ), HARA_THEME_VERSION );
	}
	wp_enqueue_script( 'hara-main', get_theme_file_uri( 'assets/js/main.js' ), array(), HARA_THEME_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}, 10, 2 );

add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name'          => __( 'Blog sidebar', 'hara' ),
		'id'            => 'blog',
		'before_widget' => '<section class="hara-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="hara-widget__title">',
		'after_title'   => '</h2>',
	) );
} );

// Favicon fallback when no Site Icon is set in the Customizer.
add_action( 'wp_head', function () {
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( get_theme_file_uri( 'assets/img/site-icon.png' ) ) . '">' . "\n";
	}
	echo '<meta name="theme-color" content="#1F6B2A">' . "\n";
}, 5 );

add_filter( 'excerpt_length', function () { return 24; } );
add_filter( 'excerpt_more', function () { return '…'; } );

// Pages built from full-width sections don't get the default narrow container.
add_filter( 'body_class', function ( $classes ) {
	if ( is_page() && ! ( function_exists( 'is_woocommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ) {
		$classes[] = 'hara-sections';
	}
	return $classes;
} );
