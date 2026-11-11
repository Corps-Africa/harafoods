<?php
/**
 * "HaRa Settings" admin page: one place for contact details, social links and WhatsApp.
 * Everything on the site that shows a phone number, address or social link reads from here.
 */

defined( 'ABSPATH' ) || exit;

function hara_settings_fields() {
	return array(
		'contact' => array(
			'title'  => __( 'Contact details', 'hara' ),
			'fields' => array(
				'phone'         => array( 'label' => 'Phone number (display)', 'placeholder' => '+233 XX XXX XXXX' ),
				'whatsapp'      => array( 'label' => 'WhatsApp number', 'placeholder' => '233XXXXXXXXX', 'help' => 'International format, digits only — no +, spaces or leading 0. Example: 233241234567' ),
				'email'         => array( 'label' => 'Public email', 'placeholder' => 'harafoodsltd@gmail.com', 'type' => 'email' ),
				'address'       => array( 'label' => 'Address', 'placeholder' => 'Bole, Savannah Region, Ghana', 'type' => 'textarea' ),
				'map_query'     => array( 'label' => 'Google Maps location', 'placeholder' => 'Bole, Savannah Region, Ghana', 'help' => 'An address, a place name or "latitude,longitude". Used for the embedded map.' ),
				'hours'         => array( 'label' => 'Opening hours', 'placeholder' => 'Mon–Fri 8:00–17:00 · Sat 9:00–13:00', 'type' => 'textarea' ),
				'whatsapp_text' => array( 'label' => 'WhatsApp greeting', 'placeholder' => 'Hello HaRa Foods, I would like to know more about your products.', 'type' => 'textarea' ),
			),
		),
		'social'  => array(
			'title'  => __( 'Social media', 'hara' ),
			'fields' => array(
				'instagram' => array( 'label' => 'Instagram URL', 'type' => 'url' ),
				'linkedin'  => array( 'label' => 'LinkedIn URL', 'type' => 'url' ),
				'facebook'  => array( 'label' => 'Facebook URL', 'type' => 'url' ),
				'tiktok'    => array( 'label' => 'TikTok URL', 'type' => 'url' ),
				'youtube'   => array( 'label' => 'YouTube URL', 'type' => 'url' ),
			),
		),
		'site'    => array(
			'title'  => __( 'Site', 'hara' ),
			'fields' => array(
				'announcement'   => array( 'label' => 'Announcement bar', 'placeholder' => 'Delivery across Ghana · Pay with Mobile Money or card', 'help' => 'Short line shown at the very top of every page. Leave empty to hide.' ),
				'enquiry_emails' => array( 'label' => 'Send enquiries to', 'placeholder' => get_option( 'admin_email' ), 'help' => 'Comma-separated emails that receive contact and wholesale form submissions. Defaults to the site admin email.' ),
			),
		),
	);
}

function hara_opt( $key, $default = '' ) {
	$opts = get_option( 'hara_settings', array() );
	return isset( $opts[ $key ] ) && '' !== $opts[ $key ] ? $opts[ $key ] : $default;
}

add_action( 'admin_menu', function () {
	add_menu_page( 'HaRa Settings', 'HaRa Settings', 'manage_options', 'hara-settings', 'hara_render_settings_page', 'dashicons-carrot', 58 );
} );

add_action( 'admin_init', function () {
	register_setting( 'hara_settings', 'hara_settings', array( 'sanitize_callback' => 'hara_sanitize_settings' ) );
	foreach ( hara_settings_fields() as $section_id => $section ) {
		add_settings_section( 'hara_' . $section_id, $section['title'], '__return_null', 'hara-settings' );
		foreach ( $section['fields'] as $key => $field ) {
			add_settings_field( $key, esc_html( $field['label'] ), 'hara_render_settings_field', 'hara-settings', 'hara_' . $section_id, array( 'key' => $key, 'field' => $field, 'label_for' => 'hara_' . $key ) );
		}
	}
} );

function hara_sanitize_settings( $input ) {
	$clean = array();
	foreach ( hara_settings_fields() as $section ) {
		foreach ( $section['fields'] as $key => $field ) {
			$value = isset( $input[ $key ] ) ? $input[ $key ] : '';
			$type  = isset( $field['type'] ) ? $field['type'] : 'text';
			if ( 'whatsapp' === $key ) {
				$value = preg_replace( '/\D+/', '', $value );
				if ( 0 === strpos( $value, '0' ) ) { // Local 0XX… → 233XX…
					$value = '233' . substr( $value, 1 );
				}
			} elseif ( 'url' === $type ) {
				$value = esc_url_raw( trim( $value ) );
			} elseif ( 'email' === $type ) {
				$value = sanitize_email( $value );
			} elseif ( 'textarea' === $type ) {
				$value = sanitize_textarea_field( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
			$clean[ $key ] = $value;
		}
	}
	return $clean;
}

function hara_render_settings_field( $args ) {
	$key   = $args['key'];
	$field = $args['field'];
	$type  = isset( $field['type'] ) ? $field['type'] : 'text';
	$name  = 'hara_settings[' . $key . ']';
	$value = hara_opt( $key );
	$ph    = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
	if ( 'textarea' === $type ) {
		printf( '<textarea id="hara_%1$s" name="%2$s" rows="3" class="large-text" placeholder="%3$s">%4$s</textarea>', esc_attr( $key ), esc_attr( $name ), esc_attr( $ph ), esc_textarea( $value ) );
	} else {
		printf( '<input id="hara_%1$s" type="%2$s" name="%3$s" value="%4$s" class="regular-text" placeholder="%5$s">', esc_attr( $key ), esc_attr( $type ), esc_attr( $name ), esc_attr( $value ), esc_attr( $ph ) );
	}
	if ( ! empty( $field['help'] ) ) {
		echo '<p class="description">' . esc_html( $field['help'] ) . '</p>';
	}
}

function hara_render_settings_page() {
	?>
	<div class="wrap">
		<h1>HaRa Settings</h1>
		<p>Contact details and links used across the website: header, footer, Contact page, WhatsApp button and Google search results.</p>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'hara_settings' );
			do_settings_sections( 'hara-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/** Social profiles that have a URL set, in display order. */
function hara_social_profiles() {
	$labels = array(
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'facebook'  => 'Facebook',
		'tiktok'    => 'TikTok',
		'youtube'   => 'YouTube',
	);
	$out = array();
	foreach ( $labels as $key => $label ) {
		$url = hara_opt( $key );
		if ( $url ) {
			$out[ $key ] = array( 'label' => $label, 'url' => $url );
		}
	}
	return $out;
}

function hara_whatsapp_url( $message = '' ) {
	$number = hara_opt( 'whatsapp' );
	if ( ! $number ) {
		return '';
	}
	$message = $message ? $message : hara_opt( 'whatsapp_text', 'Hello HaRa Foods, I would like to know more about your products.' );
	return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $message );
}
