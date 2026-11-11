<?php defined( 'ABSPATH' ) || exit; ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="hara-skip" href="#main"><?php esc_html_e( 'Skip to content', 'hara' ); ?></a>

<?php $announcement = function_exists( 'hara_opt' ) ? hara_opt( 'announcement' ) : ''; ?>
<?php if ( $announcement ) : ?>
	<div class="hara-announcement"><div class="hara-container"><?php echo esc_html( $announcement ); ?></div></div>
<?php endif; ?>

<header class="hara-header" id="top">
	<div class="hara-container hara-header__inner">
		<?php hara_logo(); ?>

		<button class="hara-nav-toggle" aria-expanded="false" aria-controls="hara-nav">
			<span class="hara-nav-toggle__bars" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'hara' ); ?></span>
		</button>

		<nav class="hara-nav" id="hara-nav" aria-label="<?php esc_attr_e( 'Main', 'hara' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'hara-menu',
				'fallback_cb'    => 'hara_menu_fallback',
				'depth'          => 2,
			) );
			?>
		</nav>

		<div class="hara-header__actions">
			<?php echo hara_account_link(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo hara_cart_link(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</header>

<main id="main" class="hara-main" tabindex="-1">
