<?php
/**
 * Home page: renders the page set as "Homepage" in Settings → Reading.
 * All sections are editable blocks in that page.
 */
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	?>
	<div class="hara-content hara-content--home">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;
get_footer();
