<?php
/**
 * Wrapper for WooCommerce shop, category and product pages.
 */
defined( 'ABSPATH' ) || exit;
get_header();

if ( ! is_product() ) {
	$intro = '';
	if ( is_shop() ) {
		$intro = __( 'Solar-dried fruits, vegetable powders, spices and drink mixes — made in Bole from produce grown by local farmers.', 'hara' );
	} elseif ( is_product_taxonomy() ) {
		$intro = wp_strip_all_tags( term_description() );
	}
	hara_page_banner( woocommerce_page_title( false ), $intro );
}
?>
<div class="hara-container hara-shop<?php echo is_product() ? ' hara-shop--single' : ''; ?>">
	<?php woocommerce_content(); ?>
</div>
<?php
get_footer();
