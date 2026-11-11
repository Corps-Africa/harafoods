<?php
/**
 * Shortcodes used inside page content (add them with a "Shortcode" block in the editor):
 *
 *   [hara_testimonials count="3"]   customer / partner quotes (Admin → Testimonials)
 *   [hara_latest_posts count="3"]   latest news & blog posts
 *   [hara_map]                       Google Map of the location set in HaRa Settings
 *   [hara_contact_details]           phone, WhatsApp, email, address, hours
 *   [hara_social_links]              icon links to the social profiles in HaRa Settings
 *   [hara_whatsapp_button text="…"]  "Chat on WhatsApp" button
 *   [hara_instagram]                 Instagram feed (if the Smash Balloon plugin is set up), otherwise a follow card
 */

defined( 'ABSPATH' ) || exit;

function hara_icon( $name ) {
	static $icons = array(
		'whatsapp'  => '<path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 21.5h-.01a9.45 9.45 0 0 1-4.82-1.32l-.35-.2-3.58.94.96-3.49-.23-.36a9.43 9.43 0 0 1-1.45-5.03c0-5.22 4.25-9.47 9.48-9.47 2.53 0 4.91.99 6.7 2.78a9.41 9.41 0 0 1 2.77 6.7c0 5.23-4.25 9.48-9.47 9.48zm8.06-17.54A11.33 11.33 0 0 0 12.04.62C5.76.62.66 5.72.66 12c0 2.01.52 3.97 1.52 5.69L.56 23.6l6.05-1.59a11.36 11.36 0 0 0 5.43 1.38h.01c6.27 0 11.38-5.1 11.38-11.38 0-3.04-1.18-5.9-3.33-8.05z"/>',
		'instagram' => '<path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.72 3.72 0 0 1-1.38-.9 3.72 3.72 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.3-1.46.72-2.12 1.38A5.86 5.86 0 0 0 .63 4.14C.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.3.79.72 1.46 1.38 2.12a5.86 5.86 0 0 0 2.13 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.86 5.86 0 0 0 2.12-1.38 5.86 5.86 0 0 0 1.38-2.12c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.96s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.86 5.86 0 0 0-1.38-2.13A5.86 5.86 0 0 0 19.86.63C19.1.33 18.22.13 16.95.07 15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.4-11.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/>',
		'linkedin'  => '<path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/>',
		'facebook'  => '<path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.23 2.68.23v2.97h-1.51c-1.49 0-1.96.93-1.96 1.89v2.26h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z"/>',
		'tiktok'    => '<path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>',
		'youtube'   => '<path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.93 24 12 24 12s0-3.93-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/>',
		'phone'     => '<path d="M6.62 10.79a15.15 15.15 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/>',
		'email'     => '<path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>',
		'pin'       => '<path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>',
		'clock'     => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>',
		'quote'     => '<path d="M6 17h3l2-4V7H5v6h3l-2 4zm8 0h3l2-4V7h-6v6h3l-2 4z"/>',
	);
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg class="hara-icon hara-icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
}

add_shortcode( 'hara_testimonials', function ( $atts ) {
	$atts  = shortcode_atts( array( 'count' => 3 ), $atts );
	$items = get_posts( array(
		'post_type'      => 'hara_testimonial',
		'posts_per_page' => max( 1, (int) $atts['count'] ),
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	) );
	if ( ! $items ) {
		return current_user_can( 'edit_posts' ) ? '<p class="hara-empty">Add testimonials under Admin → Testimonials.</p>' : '';
	}
	$out = '<div class="hara-testimonials">';
	foreach ( $items as $item ) {
		$role  = get_post_meta( $item->ID, 'hara_role', true );
		$thumb = get_the_post_thumbnail( $item, 'thumbnail', array( 'class' => 'hara-testimonial__photo', 'loading' => 'lazy' ) );
		$out  .= '<figure class="hara-testimonial">' . hara_icon( 'quote' )
			. '<blockquote>' . wp_kses_post( wpautop( $item->post_content ) ) . '</blockquote>'
			. '<figcaption>' . $thumb . '<span><strong>' . esc_html( get_the_title( $item ) ) . '</strong>'
			. ( $role ? '<small>' . esc_html( $role ) . '</small>' : '' ) . '</span></figcaption></figure>';
	}
	return $out . '</div>';
} );

add_shortcode( 'hara_latest_posts', function ( $atts ) {
	$atts  = shortcode_atts( array( 'count' => 3 ), $atts );
	$posts = get_posts( array( 'posts_per_page' => max( 1, (int) $atts['count'] ), 'ignore_sticky_posts' => true ) );
	if ( ! $posts ) {
		return '';
	}
	$out = '<div class="hara-post-grid">';
	foreach ( $posts as $p ) {
		$out .= hara_post_card( $p );
	}
	return $out . '</div>';
} );

function hara_post_card( $p ) {
	$img = has_post_thumbnail( $p )
		? get_the_post_thumbnail( $p, 'medium_large', array( 'loading' => 'lazy' ) )
		: '<span class="hara-card__placeholder" aria-hidden="true"></span>';
	$cat = get_the_category( $p->ID );
	return '<article class="hara-card hara-card--post"><a class="hara-card__media" href="' . esc_url( get_permalink( $p ) ) . '" tabindex="-1" aria-hidden="true">' . $img . '</a>'
		. '<div class="hara-card__body">'
		. ( $cat ? '<span class="hara-eyebrow">' . esc_html( $cat[0]->name ) . '</span>' : '' )
		. '<h3 class="hara-card__title"><a href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( get_the_title( $p ) ) . '</a></h3>'
		. '<p>' . esc_html( wp_trim_words( get_the_excerpt( $p ), 22 ) ) . '</p>'
		. '<time datetime="' . esc_attr( get_the_date( 'c', $p ) ) . '">' . esc_html( get_the_date( '', $p ) ) . '</time>'
		. '</div></article>';
}

add_shortcode( 'hara_map', function ( $atts ) {
	$atts  = shortcode_atts( array( 'height' => 380 ), $atts );
	$query = hara_opt( 'map_query', 'Bole, Savannah Region, Ghana' );
	$src   = 'https://maps.google.com/maps?q=' . rawurlencode( $query ) . '&z=14&output=embed';
	return '<div class="hara-map"><iframe title="Map showing HaRa Foods location" src="' . esc_url( $src ) . '" height="' . (int) $atts['height'] . '" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>'
		. '<a class="hara-map__link" href="' . esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $query ) ) . '" target="_blank" rel="noopener">Open in Google Maps ↗</a></div>';
} );

add_shortcode( 'hara_contact_details', function () {
	$rows  = array();
	$phone = hara_opt( 'phone' );
	if ( $phone ) {
		$rows[] = array( 'phone', 'Call us', '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>' );
	}
	$wa = hara_whatsapp_url();
	if ( $wa ) {
		$rows[] = array( 'whatsapp', 'WhatsApp', '<a href="' . esc_url( $wa ) . '" target="_blank" rel="noopener">Chat with us</a>' );
	}
	$email = hara_opt( 'email', get_option( 'admin_email' ) );
	$rows[] = array( 'email', 'Email', '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' );
	$rows[] = array( 'pin', 'Visit', nl2br( esc_html( hara_opt( 'address', 'Bole, Savannah Region, Ghana' ) ) ) );
	$hours  = hara_opt( 'hours' );
	if ( $hours ) {
		$rows[] = array( 'clock', 'Hours', nl2br( esc_html( $hours ) ) );
	}
	$out = '<ul class="hara-contact-list">';
	foreach ( $rows as $r ) {
		$out .= '<li><span class="hara-contact-list__icon">' . hara_icon( $r[0] ) . '</span><span><strong>' . esc_html( $r[1] ) . '</strong>' . $r[2] . '</span></li>';
	}
	return $out . '</ul>';
} );

function hara_social_links_html( $class = 'hara-social' ) {
	$profiles = hara_social_profiles();
	if ( ! $profiles ) {
		return '';
	}
	$out = '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $profiles as $key => $p ) {
		$out .= '<li><a href="' . esc_url( $p['url'] ) . '" target="_blank" rel="noopener" aria-label="HaRa Foods on ' . esc_attr( $p['label'] ) . '">' . hara_icon( $key ) . '</a></li>';
	}
	return $out . '</ul>';
}
add_shortcode( 'hara_social_links', function () { return hara_social_links_html(); } );

add_shortcode( 'hara_whatsapp_button', function ( $atts ) {
	$atts = shortcode_atts( array( 'text' => 'Chat on WhatsApp', 'message' => '' ), $atts );
	$url  = hara_whatsapp_url( $atts['message'] );
	if ( ! $url ) {
		return current_user_can( 'manage_options' ) ? '<p class="hara-empty">Set the WhatsApp number in HaRa Settings to show this button.</p>' : '';
	}
	return '<a class="hara-btn hara-btn--whatsapp" href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . hara_icon( 'whatsapp' ) . esc_html( $atts['text'] ) . '</a>';
} );

add_shortcode( 'hara_instagram', function () {
	// Live feed via Smash Balloon "Instagram Feed" plugin once the client connects their account.
	if ( shortcode_exists( 'instagram-feed' ) ) {
		return do_shortcode( '[instagram-feed]' );
	}
	$url = hara_opt( 'instagram', 'https://www.instagram.com/harafoods_ltd/' );
	return '<a class="hara-insta-card" href="' . esc_url( $url ) . '" target="_blank" rel="noopener">'
		. hara_icon( 'instagram' ) . '<span><strong>@harafoods_ltd</strong>See our latest products, behind-the-scenes and community stories on Instagram.</span><span class="hara-insta-card__cta">Follow us ↗</span></a>';
} );
