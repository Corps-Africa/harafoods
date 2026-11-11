<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'hara-article' ); ?>>
		<header class="hara-banner hara-banner--article">
			<div class="hara-container hara-container--narrow">
				<p class="hara-eyebrow"><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">← <?php esc_html_e( 'News & stories', 'hara' ); ?></a></p>
				<h1 class="hara-banner__title"><?php the_title(); ?></h1>
				<?php hara_posted_on(); ?>
			</div>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="hara-container hara-container--narrow hara-article__hero"><?php the_post_thumbnail( 'large' ); ?></div>
		<?php endif; ?>
		<div class="hara-container hara-container--narrow hara-prose">
			<?php the_content(); ?>
		</div>
		<footer class="hara-container hara-container--narrow hara-article__footer">
			<?php the_tags( '<p class="hara-tags">', '', '</p>' ); ?>
			<nav class="hara-post-nav" aria-label="<?php esc_attr_e( 'More posts', 'hara' ); ?>">
				<?php previous_post_link( '<span>%link</span>', '← %title' ); ?>
				<?php next_post_link( '<span>%link</span>', '%title →' ); ?>
			</nav>
		</footer>
	</article>
	<?php
endwhile;
get_footer();
