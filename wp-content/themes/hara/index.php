<?php
/**
 * Blog index, archives and search results.
 */
defined( 'ABSPATH' ) || exit;
get_header();

if ( is_home() ) {
	$posts_page = get_option( 'page_for_posts' );
	hara_page_banner( $posts_page ? get_the_title( $posts_page ) : __( 'News & stories', 'hara' ), $posts_page && has_excerpt( $posts_page ) ? get_the_excerpt( $posts_page ) : __( 'Updates from our team, our farmers and our community in the Savannah Region.', 'hara' ) );
} elseif ( is_search() ) {
	/* translators: %s: search query */
	hara_page_banner( sprintf( __( 'Search results for “%s”', 'hara' ), esc_html( get_search_query() ) ), '' );
} else {
	hara_page_banner( get_the_archive_title(), wp_strip_all_tags( get_the_archive_description() ) );
}
?>
<div class="hara-container hara-section-pad">
	<?php if ( have_posts() ) : ?>
		<div class="hara-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				echo hara_post_card( get_post() ); // phpcs:ignore WordPress.Security.EscapeOutput
			endwhile;
			?>
		</div>
		<?php
		the_posts_pagination( array(
			'prev_text' => '← ' . __( 'Newer', 'hara' ),
			'next_text' => __( 'Older', 'hara' ) . ' →',
			'class'     => 'hara-pagination',
		) );
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found here yet.', 'hara' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>
<?php
get_footer();
