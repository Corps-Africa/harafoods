<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="hara-404 hara-container">
	<p class="hara-eyebrow">404</p>
	<h1><?php esc_html_e( 'This page has dried up', 'hara' ); ?></h1>
	<p><?php esc_html_e( 'We couldn’t find what you were looking for. Try the shop, or search below.', 'hara' ); ?></p>
	<p class="hara-404__actions">
		<a class="hara-btn hara-btn--primary" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Visit the shop', 'hara' ); ?></a>
		<a class="hara-btn hara-btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'hara' ); ?></a>
	</p>
	<?php get_search_form(); ?>
</section>
<?php
get_footer();
