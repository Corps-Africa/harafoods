<?php
/**
 * WooCommerce presentation for the HaRa theme.
 */

defined( 'ABSPATH' ) || exit;

// Our banner shows the title and description; avoid duplicates from woocommerce_content().
add_filter( 'woocommerce_show_page_title', '__return_false' );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

// Branded placeholder until real product photos are uploaded.
add_filter( 'woocommerce_placeholder_img_src', function () {
	return get_theme_file_uri( 'assets/img/product-placeholder.svg' );
} );

// Live cart count in the header after AJAX add-to-cart.
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['a.hara-cart-link'] = hara_cart_link();
	return $fragments;
} );

// Category "chips" above the product grid.
add_action( 'woocommerce_before_shop_loop', function () {
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
		'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
	) );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return;
	}
	$current = is_product_category() ? get_queried_object_id() : 0;
	echo '<nav class="hara-chips" aria-label="' . esc_attr__( 'Product categories', 'hara' ) . '"><ul>';
	printf( '<li><a href="%s"%s>%s</a></li>', esc_url( wc_get_page_permalink( 'shop' ) ), $current ? '' : ' aria-current="page"', esc_html__( 'All products', 'hara' ) );
	foreach ( $terms as $term ) {
		printf( '<li><a href="%s"%s>%s</a></li>', esc_url( get_term_link( $term ) ), $current === $term->term_id ? ' aria-current="page"' : '', esc_html( $term->name ) );
	}
	echo '</ul></nav>';
}, 5 );

// Breadcrumb on single product pages (woocommerce_content() skips the default one).
add_action( 'woocommerce_before_single_product', function () {
	woocommerce_breadcrumb( array(
		'wrap_before' => '<nav class="hara-breadcrumb" aria-label="Breadcrumb">',
		'wrap_after'  => '</nav>',
		'delimiter'   => '<span aria-hidden="true"> / </span>',
	) );
}, 5 );

// Reassurance + wholesale prompt under the add-to-cart button.
add_action( 'woocommerce_single_product_summary', function () {
	?>
	<ul class="hara-assurance">
		<li><?php esc_html_e( 'Solar-dried in Bole, Savannah Region', 'hara' ); ?></li>
		<li><?php esc_html_e( 'Delivery across Ghana', 'hara' ); ?></li>
		<li><?php esc_html_e( 'Pay securely with Mobile Money or card', 'hara' ); ?></li>
	</ul>
	<?php
	$wholesale = get_page_by_path( 'wholesale' );
	if ( $wholesale ) {
		printf(
			'<p class="hara-wholesale-note">%s <a href="%s">%s</a></p>',
			esc_html__( 'Buying for a shop, school, hotel or distributor?', 'hara' ),
			esc_url( get_permalink( $wholesale ) ),
			esc_html__( 'Request wholesale prices →', 'hara' )
		);
	}
}, 32 );

add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

add_filter( 'loop_shop_columns', function () { return 4; } );

// Sale badge wording.
add_filter( 'woocommerce_sale_flash', function () {
	return '<span class="onsale">' . esc_html__( 'Offer', 'hara' ) . '</span>';
} );
