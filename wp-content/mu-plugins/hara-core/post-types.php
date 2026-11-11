<?php
/**
 * Testimonials (shown on Home and Impact pages) and Enquiries (form submissions, admin-only).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	register_post_type( 'hara_testimonial', array(
		'labels'        => array(
			'name'          => 'Testimonials',
			'singular_name' => 'Testimonial',
			'add_new_item'  => 'Add testimonial',
			'edit_item'     => 'Edit testimonial',
			'menu_name'     => 'Testimonials',
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-format-quote',
		'menu_position' => 26,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'enter_title_here' => 'Person or organisation name',
	) );

	register_post_meta( 'hara_testimonial', 'hara_role', array(
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function () { return current_user_can( 'edit_posts' ); },
	) );

	register_post_type( 'hara_enquiry', array(
		'labels'          => array(
			'name'          => 'Enquiries',
			'singular_name' => 'Enquiry',
			'menu_name'     => 'Enquiries',
			'edit_item'     => 'Enquiry',
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_rest'    => false,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 27,
		'supports'        => array( 'title' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

add_filter( 'enter_title_here', function ( $title, $post ) {
	return 'hara_testimonial' === $post->post_type ? 'Person or organisation name' : $title;
}, 10, 2 );

/* ---------- Testimonial "role" meta box (classic, works with block editor too) ---------- */

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'hara_role', 'Role / location', function ( $post ) {
		wp_nonce_field( 'hara_role', 'hara_role_nonce' );
		printf(
			'<input type="text" name="hara_role" value="%s" class="widefat" placeholder="e.g. Shop owner, Tamale"><p class="description">Shown under the name.</p>',
			esc_attr( get_post_meta( $post->ID, 'hara_role', true ) )
		);
	}, 'hara_testimonial', 'side' );

	add_meta_box( 'hara_enquiry_details', 'Details', 'hara_render_enquiry_box', 'hara_enquiry', 'normal', 'high' );
} );

add_action( 'save_post_hara_testimonial', function ( $post_id ) {
	if ( ! isset( $_POST['hara_role_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hara_role_nonce'] ), 'hara_role' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'hara_role', sanitize_text_field( wp_unslash( $_POST['hara_role'] ?? '' ) ) );
} );

/* ---------- Enquiry admin view ---------- */

function hara_render_enquiry_box( $post ) {
	$fields = get_post_meta( $post->ID, 'hara_fields', true );
	if ( ! is_array( $fields ) ) {
		echo '<p>No details stored.</p>';
		return;
	}
	echo '<table class="widefat striped"><tbody>';
	foreach ( $fields as $label => $value ) {
		printf( '<tr><th style="width:30%%">%s</th><td>%s</td></tr>', esc_html( $label ), nl2br( esc_html( $value ) ) );
	}
	echo '</tbody></table>';
	$email = get_post_meta( $post->ID, 'hara_email', true );
	if ( $email ) {
		printf( '<p><a class="button button-primary" href="mailto:%1$s">Reply to %1$s</a></p>', esc_attr( $email ) );
	}
}

add_filter( 'manage_hara_enquiry_posts_columns', function ( $cols ) {
	return array(
		'cb'         => $cols['cb'],
		'title'      => 'From',
		'hara_type'  => 'Type',
		'hara_email' => 'Email',
		'hara_phone' => 'Phone',
		'date'       => 'Received',
	);
} );

add_action( 'manage_hara_enquiry_posts_custom_column', function ( $col, $post_id ) {
	if ( 'hara_type' === $col ) {
		echo esc_html( ucfirst( (string) get_post_meta( $post_id, 'hara_type', true ) ) );
	} elseif ( 'hara_email' === $col ) {
		echo esc_html( (string) get_post_meta( $post_id, 'hara_email', true ) );
	} elseif ( 'hara_phone' === $col ) {
		echo esc_html( (string) get_post_meta( $post_id, 'hara_phone', true ) );
	}
}, 10, 2 );

// Unread badge on the Enquiries menu.
add_action( 'admin_menu', function () {
	global $menu;
	$count = (int) wp_count_posts( 'hara_enquiry' )->pending;
	if ( ! $count ) {
		return;
	}
	foreach ( $menu as $i => $item ) {
		if ( 'edit.php?post_type=hara_enquiry' === $item[2] ) {
			$menu[ $i ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
		}
	}
}, 99 );

// Opening an enquiry marks it as read (pending → private).
add_action( 'load-post.php', function () {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( $post_id && 'hara_enquiry' === get_post_type( $post_id ) && 'pending' === get_post_status( $post_id ) ) {
		wp_update_post( array( 'ID' => $post_id, 'post_status' => 'private' ) );
	}
} );
