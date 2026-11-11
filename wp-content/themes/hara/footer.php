<?php defined( 'ABSPATH' ) || exit; ?>
</main>

<footer class="hara-footer">
	<div class="hara-container hara-footer__grid">
		<div class="hara-footer__brand">
			<span class="hara-footer__logo"><?php hara_logo( 170 ); ?></span>
			<p><?php esc_html_e( 'Nutritious, solar-dried foods made from produce grown by farmers in Ghana\'s Savannah Region.', 'hara' ); ?></p>
			<?php echo function_exists( 'hara_social_links_html' ) ? hara_social_links_html( 'hara-social hara-social--light' ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>

		<nav class="hara-footer__col" aria-label="<?php esc_attr_e( 'Company', 'hara' ); ?>">
			<h2 class="hara-footer__title"><?php esc_html_e( 'Company', 'hara' ); ?></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'hara-footer__menu', 'depth' => 1, 'fallback_cb' => false ) ); ?>
		</nav>

		<nav class="hara-footer__col" aria-label="<?php esc_attr_e( 'Help', 'hara' ); ?>">
			<h2 class="hara-footer__title"><?php esc_html_e( 'Help', 'hara' ); ?></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'legal', 'container' => false, 'menu_class' => 'hara-footer__menu', 'depth' => 1, 'fallback_cb' => false ) ); ?>
		</nav>

		<div class="hara-footer__col">
			<h2 class="hara-footer__title"><?php esc_html_e( 'Get in touch', 'hara' ); ?></h2>
			<?php echo do_shortcode( '[hara_contact_details]' ); ?>
		</div>
	</div>

	<div class="hara-footer__bottom">
		<div class="hara-container">
			<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> HaRa Foods Ltd. <?php esc_html_e( 'Proudly made in Bole, Ghana.', 'hara' ); ?></p>
			<p class="hara-footer__pay"><?php esc_html_e( 'Secure payment by Mobile Money and card via Paystack', 'hara' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
