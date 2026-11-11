<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	hara_page_banner();
	?>
	<div class="hara-content">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;
get_footer();
