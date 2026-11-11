<?php
/**
 * SAMPLE catalogue so the shop can be designed and tested before HaRa Foods sends its
 * real product list. Names, sizes and prices are placeholders: replace or delete them
 * in WP Admin → Products. Every sample product has a SKU starting "SAMPLE-".
 */

function hara_product_catalogue() {
	return array(
		'categories' => array(
			'dried-fruits'      => array( 'Dried fruits', 'Sweet, chewy fruit slices dried in the sun — great for snacking, lunchboxes and baking.' ),
			'vegetable-powders' => array( 'Vegetable powders', 'Concentrated vegetable powders that bring colour, flavour and nutrition to soups, stews and sauces.' ),
			'spices'            => array( 'Spices & seasonings', 'Sun-dried spices from the Savannah Region for everyday Ghanaian cooking.' ),
			'drink-mixes'       => array( 'Drink mixes', 'Dried flowers and fruit powders for refreshing, home-made drinks.' ),
			'flours-cereals'    => array( 'Flours & cereals', 'Wholesome flours and porridge mixes made from local grains.' ),
		),
		'products'   => array(
			array( 'sku' => 'SAMPLE-MANGO', 'name' => 'Solar-Dried Mango Slices', 'cat' => 'dried-fruits', 'sizes' => array( '100 g' => 25, '250 g' => 55 ), 'short' => 'Ripe, sweet mango from Northern Ghana, sliced and dried in the sun. A naturally sweet, chewy snack.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-PINE', 'name' => 'Solar-Dried Pineapple', 'cat' => 'dried-fruits', 'sizes' => array( '100 g' => 25, '250 g' => 55 ), 'short' => 'Tangy-sweet pineapple pieces, dried slowly to keep their bright flavour.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-MIX', 'name' => 'Tropical Dried Fruit Mix', 'cat' => 'dried-fruits', 'price' => 45, 'size' => '200 g', 'short' => 'A colourful mix of our solar-dried fruits — perfect for snacking or topping porridge and yoghurt.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-TOM', 'name' => 'Tomato Powder', 'cat' => 'vegetable-powders', 'sizes' => array( '150 g' => 30, '500 g' => 85 ), 'short' => 'Sun-dried tomatoes ground to a fine powder. Stir into stews, soups and jollof for rich tomato flavour all year round.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-OKRA', 'name' => 'Okra Powder', 'cat' => 'vegetable-powders', 'price' => 30, 'size' => '150 g', 'short' => 'Dried, ground okra for quick, smooth okra soup any time of year.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-MOR', 'name' => 'Moringa Leaf Powder', 'cat' => 'vegetable-powders', 'price' => 35, 'size' => '100 g', 'short' => 'Finely ground dried moringa leaves. Add to soups, sauces or smoothies.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-PEP', 'name' => 'Hot Pepper Powder', 'cat' => 'spices', 'price' => 25, 'size' => '100 g', 'short' => 'Fiery red pepper, sun-dried and ground. A little goes a long way.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-GIN', 'name' => 'Ginger Powder', 'cat' => 'spices', 'price' => 28, 'size' => '100 g', 'short' => 'Warm, aromatic ginger for cooking, baking and home-made drinks.' ),
			array( 'sku' => 'SAMPLE-SOB', 'name' => 'Hibiscus (Sobolo) Drink Mix', 'cat' => 'drink-mixes', 'price' => 30, 'size' => '200 g', 'short' => 'Dried hibiscus flowers for making refreshing sobolo at home.', 'featured' => true ),
			array( 'sku' => 'SAMPLE-BAO', 'name' => 'Baobab Fruit Powder', 'cat' => 'drink-mixes', 'price' => 40, 'size' => '200 g', 'short' => 'Tangy baobab fruit powder for drinks, porridge and smoothies.' ),
			array( 'sku' => 'SAMPLE-POR', 'name' => 'Mixed Grain Porridge Flour', 'cat' => 'flours-cereals', 'price' => 35, 'size' => '500 g', 'short' => 'A wholesome blend of local grains for a filling breakfast porridge.' ),
		),
	);
}

function hara_seed_products( $force = false ) {
	$catalogue = hara_product_catalogue();
	$term_ids  = array();
	$order     = 0;

	foreach ( $catalogue['categories'] as $slug => $cat ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( ! $term ) {
			$res  = wp_insert_term( $cat[0], 'product_cat', array( 'slug' => $slug, 'description' => $cat[1] ) );
			$tid  = is_wp_error( $res ) ? 0 : $res['term_id'];
		} else {
			$tid = $term->term_id;
		}
		update_term_meta( $tid, 'order', $order++ );
		$term_ids[ $slug ] = $tid;
	}

	// Keep the default "Uncategorized" category out of sight.
	$default = (int) get_option( 'default_product_cat' );
	if ( $default ) {
		wp_update_term( $default, 'product_cat', array( 'name' => 'Other', 'slug' => 'other' ) );
	}

	$sample_note = '<p><em>Sample product for the website preview — description, size and price to be confirmed by HaRa Foods.</em></p>';

	foreach ( $catalogue['products'] as $i => $p ) {
		$existing_id = wc_get_product_id_by_sku( $p['sku'] );
		if ( ! $existing_id ) {
			// Variations carry suffixed SKUs; look the parent up by meta as a fallback.
			$found       = get_posts( array( 'post_type' => 'product', 'meta_key' => '_sku', 'meta_value' => $p['sku'], 'fields' => 'ids', 'post_status' => 'any', 'numberposts' => 1 ) );
			$existing_id = $found ? $found[0] : 0;
		}
		if ( $existing_id && ! $force ) {
			continue;
		}

		$variable = ! empty( $p['sizes'] );
		$product  = $existing_id ? wc_get_product( $existing_id ) : ( $variable ? new WC_Product_Variable() : new WC_Product_Simple() );

		$long = $sample_note
			. '<h3>About this product</h3><p>' . esc_html( $p['short'] ) . '</p>'
			. '<h3>How to use</h3><p>[Usage suggestions to be supplied by HaRa Foods.]</p>'
			. '<h3>Ingredients</h3><p>[Ingredients to be confirmed.]</p>'
			. '<h3>Storage</h3><p>Store in a cool, dry place away from direct sunlight. Reseal after opening.</p>';

		$product->set_name( $p['name'] );
		$product->set_slug( sanitize_title( $p['name'] ) );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_featured( ! empty( $p['featured'] ) );
		$product->set_short_description( $p['short'] );
		$product->set_description( $long );
		$product->set_category_ids( array( $term_ids[ $p['cat'] ] ) );
		$product->set_menu_order( $i );
		$product->set_reviews_allowed( true );
		$product->set_sku( $p['sku'] );

		if ( $variable ) {
			$attr = new WC_Product_Attribute();
			$attr->set_name( 'Pack size' );
			$attr->set_options( array_keys( $p['sizes'] ) );
			$attr->set_visible( true );
			$attr->set_variation( true );
			$product->set_attributes( array( $attr ) );
			$product->set_default_attributes( array( 'pack-size' => (string) array_key_first( $p['sizes'] ) ) );
			$product_id = $product->save();

			if ( ! $existing_id ) {
				foreach ( $p['sizes'] as $size => $price ) {
					$v = new WC_Product_Variation();
					$v->set_parent_id( $product_id );
					$v->set_attributes( array( 'pack-size' => $size ) );
					$v->set_regular_price( (string) $price );
					$v->set_sku( $p['sku'] . '-' . sanitize_title( $size ) );
					$v->set_manage_stock( true );
					$v->set_stock_quantity( 50 );
					$v->set_weight( (string) (int) $size );
					$v->save();
				}
				WC_Product_Variable::sync( $product_id );
			}
		} else {
			$product->set_regular_price( (string) $p['price'] );
			$product->set_manage_stock( true );
			$product->set_stock_quantity( 50 );
			$product->set_weight( (string) (int) $p['size'] );
			$attr = new WC_Product_Attribute();
			$attr->set_name( 'Pack size' );
			$attr->set_options( array( $p['size'] ) );
			$attr->set_visible( true );
			$attr->set_variation( false );
			$product->set_attributes( array( $attr ) );
			$product->save();
		}
		hara_log( $p['name'] );
	}
}
