<?php
/**
 * Sample blog posts and testimonials. They show how the News and Testimonials sections look.
 * Replace them with HaRa Foods' real stories and real customer quotes before launch.
 */

function hara_seed_posts( $force = false ) {
	$sample = hb_p( '<em>Sample post for the website preview — replace with HaRa Foods’ own story.</em>' );

	$posts = array(
		array(
			'slug'     => 'why-we-dry-with-the-sun',
			'title'    => 'Why we dry our food with the sun',
			'category' => 'Behind the scenes',
			'excerpt'  => 'Solar drying is one of the oldest ways to preserve food. Here’s how we use modern solar dehydrators to keep produce fresh for months.',
			'content'  => $sample
				. hb_p( 'Drying is one of the oldest ways people have preserved food. By removing most of the water from fruits and vegetables, it slows the processes that make fresh produce spoil.' )
				. hb_p( 'Traditional open-air drying can expose food to dust, insects and rain. A solar dehydrator keeps food enclosed while it uses the sun’s heat to dry it, so it is cleaner and dries more evenly.' )
				. hb_h( 'Why it matters in the Savannah Region' )
				. hb_p( 'Our region gets plenty of sunshine for much of the year. Using it to dry produce means we don’t rely on firewood or expensive electricity — good for our costs and for the environment.' )
				. hb_p( '[Add details about HaRa Foods’ own dryers, capacity and process.]' ),
		),
		array(
			'slug'     => 'reducing-post-harvest-losses',
			'title'    => 'Reducing post-harvest losses, one harvest at a time',
			'category' => 'Impact',
			'excerpt'  => 'When harvests come in all at once, a lot of good food never reaches a plate. Here’s how processing helps farmers and families.',
			'content'  => $sample
				. hb_p( 'Many crops in Northern Ghana are harvested within a few short weeks. Markets get flooded, prices drop and some produce spoils before it can be sold or eaten.' )
				. hb_p( 'By buying produce at harvest time and drying it, HaRa Foods gives farmers another market for their crops and keeps nutritious food available later in the year.' )
				. hb_p( '[Add a story from a partner farmer, with their permission.]' ),
		),
		array(
			'slug'     => 'cooking-with-tomato-powder',
			'title'    => 'Three easy ways to cook with tomato powder',
			'category' => 'Recipes',
			'excerpt'  => 'Tomato powder is a handy store-cupboard ingredient. Try it in stew, jollof and soups.',
			'content'  => $sample
				. hb_p( 'Tomato powder is a handy store-cupboard ingredient — especially when fresh tomatoes are scarce or expensive.' )
				. hb_list( array(
					'<strong>Stew:</strong> stir a few spoonfuls into your base with a little water to build a rich tomato flavour.',
					'<strong>Jollof:</strong> add with your spices for colour and depth.',
					'<strong>Soups:</strong> sprinkle into light soup or groundnut soup as it simmers.',
				) )
				. hb_p( '[Add HaRa Foods’ recommended quantities and a photo.]' ),
		),
	);

	foreach ( $posts as $i => $p ) {
		$cat = get_term_by( 'name', $p['category'], 'category' );
		$cat_id = $cat ? $cat->term_id : wp_insert_term( $p['category'], 'category' )['term_id'];
		$id = hara_seed_post( array(
			'post_type'     => 'post',
			'post_name'     => $p['slug'],
			'post_title'    => $p['title'],
			'post_excerpt'  => $p['excerpt'],
			'post_content'  => $p['content'],
			'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( '-' . ( $i * 9 + 2 ) . ' days' ) ),
			'post_category' => array( $cat_id ),
		), $force );
		if ( $id ) {
			hara_log( $p['title'] );
		}
	}

	$testimonials = array(
		array( 'slug' => 'sample-testimonial-1', 'name' => '[Customer name]', 'role' => 'Sample — replace with a real customer', 'quote' => 'The tomato powder has made cooking so much easier, especially when fresh tomatoes are expensive. [Replace with a real customer quote.]' ),
		array( 'slug' => 'sample-testimonial-2', 'name' => '[Shop owner name]', 'role' => 'Sample — replace with a real retailer', 'quote' => 'Our customers keep asking for the dried mango. Deliveries are always on time. [Replace with a real retailer quote.]' ),
		array( 'slug' => 'sample-testimonial-3', 'name' => '[Partner farmer name]', 'role' => 'Sample — replace with a real farmer', 'quote' => 'Now I have a buyer for my produce at harvest time, so less of it goes to waste. [Replace with a real farmer quote.]' ),
	);
	foreach ( $testimonials as $i => $t ) {
		hara_seed_post( array(
			'post_type'    => 'hara_testimonial',
			'post_name'    => $t['slug'],
			'post_title'   => $t['name'],
			'post_content' => $t['quote'],
			'menu_order'   => $i,
			'meta'         => array( 'hara_role' => $t['role'] ),
		), $force );
	}
}
