<?php
/**
 * HaRa Foods theme bootstrap.
 */

defined( 'ABSPATH' ) || exit;

define( 'HARA_THEME_VERSION', '1.0.0' );

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/template-tags.php';
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
