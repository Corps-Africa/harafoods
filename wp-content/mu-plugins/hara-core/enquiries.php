<?php
/**
 * Contact and wholesale/partnership enquiry forms.
 * Every submission is saved under Admin → Enquiries (so nothing is lost if email fails)
 * and emailed to the addresses in HaRa Settings.
 *
 * Shortcodes: [hara_contact_form]  [hara_wholesale_form]
 */

defined( 'ABSPATH' ) || exit;

function hara_form_definitions() {
	return array(
		'contact'   => array(
			'title'  => 'Contact message',
			'submit' => 'Send message',
			'fields' => array(
				'name'    => array( 'label' => 'Your name', 'required' => true ),
				'email'   => array( 'label' => 'Email', 'type' => 'email', 'required' => true ),
				'phone'   => array( 'label' => 'Phone / WhatsApp', 'type' => 'tel' ),
				'subject' => array(
					'label'   => 'What is this about?',
					'type'    => 'select',
					'options' => array( 'Product question', 'Order or delivery', 'Partnership', 'Media', 'Something else' ),
				),
				'message' => array( 'label' => 'Message', 'type' => 'textarea', 'required' => true ),
			),
		),
		'wholesale' => array(
			'title'  => 'Wholesale / partnership enquiry',
			'submit' => 'Send enquiry',
			'fields' => array(
				'organisation' => array( 'label' => 'Business or organisation', 'required' => true ),
				'name'         => array( 'label' => 'Contact person', 'required' => true ),
				'org_type'     => array(
					'label'    => 'Type of organisation',
					'type'     => 'select',
					'required' => true,
					'options'  => array( 'Retailer / supermarket', 'Distributor', 'Restaurant / hotel', 'School', 'Healthcare facility', 'NGO / development partner', 'Investor', 'Farmer / cooperative', 'Other' ),
				),
				'email'        => array( 'label' => 'Email', 'type' => 'email', 'required' => true ),
				'phone'        => array( 'label' => 'Phone / WhatsApp', 'type' => 'tel', 'required' => true ),
				'location'     => array( 'label' => 'Town / region' ),
				'products'     => array( 'label' => 'Products you are interested in', 'type' => 'textarea' ),
				'volume'       => array(
					'label'   => 'Estimated monthly volume',
					'type'    => 'select',
					'options' => array( 'Not sure yet', 'Under 50 kg', '50–200 kg', '200–1,000 kg', 'Over 1,000 kg', 'Not applicable (partnership / investment)' ),
				),
				'message'      => array( 'label' => 'Tell us more', 'type' => 'textarea' ),
			),
		),
	);
}

function hara_render_form( $form_id ) {
	$forms = hara_form_definitions();
	if ( ! isset( $forms[ $form_id ] ) ) {
		return '';
	}
	$form   = $forms[ $form_id ];
	$status = isset( $_GET['hara_sent'] ) && sanitize_key( $_GET['hara_sent'] ) === $form_id ? 'sent' : '';
	$error  = isset( $_GET['hara_error'] ) && sanitize_key( $_GET['hara_error'] ) === $form_id;

	ob_start();
	echo '<div class="hara-form-wrap" id="hara-form-' . esc_attr( $form_id ) . '">';
	if ( 'sent' === $status ) {
		echo '<div class="hara-notice hara-notice--success" role="status"><strong>Thank you!</strong> We have received your message and will get back to you within 1–2 working days.</div>';
	} elseif ( $error ) {
		echo '<div class="hara-notice hara-notice--error" role="alert">Please fill in all required fields with a valid email address and try again.</div>';
	}
	?>
	<form class="hara-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="hara_enquiry">
		<input type="hidden" name="hara_form" value="<?php echo esc_attr( $form_id ); ?>">
		<input type="hidden" name="hara_return" value="<?php echo esc_url( get_permalink() ); ?>">
		<?php wp_nonce_field( 'hara_enquiry_' . $form_id, 'hara_nonce' ); ?>
		<div class="hara-hp" aria-hidden="true"><label>Leave this empty <input type="text" name="hara_website" tabindex="-1" autocomplete="off"></label></div>
		<div class="hara-form__grid">
		<?php
		foreach ( $form['fields'] as $key => $field ) :
			$type     = isset( $field['type'] ) ? $field['type'] : 'text';
			$required = ! empty( $field['required'] );
			$id       = 'hara-' . $form_id . '-' . $key;
			$wide     = in_array( $type, array( 'textarea' ), true ) ? ' hara-field--wide' : '';
			?>
			<p class="hara-field<?php echo esc_attr( $wide ); ?>">
				<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field['label'] ); ?><?php echo $required ? ' <span class="hara-req" aria-hidden="true">*</span>' : ''; ?></label>
				<?php if ( 'textarea' === $type ) : ?>
					<textarea id="<?php echo esc_attr( $id ); ?>" name="hara[<?php echo esc_attr( $key ); ?>]" rows="5" <?php echo $required ? 'required' : ''; ?>></textarea>
				<?php elseif ( 'select' === $type ) : ?>
					<select id="<?php echo esc_attr( $id ); ?>" name="hara[<?php echo esc_attr( $key ); ?>]" <?php echo $required ? 'required' : ''; ?>>
						<option value="">Choose…</option>
						<?php foreach ( $field['options'] as $opt ) : ?>
							<option><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
					</select>
				<?php else : ?>
					<input id="<?php echo esc_attr( $id ); ?>" type="<?php echo esc_attr( $type ); ?>" name="hara[<?php echo esc_attr( $key ); ?>]" <?php echo $required ? 'required' : ''; ?> <?php echo 'email' === $type ? 'autocomplete="email"' : ( 'tel' === $type ? 'autocomplete="tel"' : ( 'name' === $key ? 'autocomplete="name"' : '' ) ); ?>>
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
		</div>
		<p class="hara-form__actions"><button type="submit" class="hara-btn hara-btn--primary"><?php echo esc_html( $form['submit'] ); ?></button></p>
	</form>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'hara_contact_form', function () { return hara_render_form( 'contact' ); } );
add_shortcode( 'hara_wholesale_form', function () { return hara_render_form( 'wholesale' ); } );

add_action( 'admin_post_hara_enquiry', 'hara_handle_enquiry' );
add_action( 'admin_post_nopriv_hara_enquiry', 'hara_handle_enquiry' );

function hara_handle_enquiry() {
	$forms   = hara_form_definitions();
	$form_id = isset( $_POST['hara_form'] ) ? sanitize_key( $_POST['hara_form'] ) : '';
	$return  = isset( $_POST['hara_return'] ) ? esc_url_raw( wp_unslash( $_POST['hara_return'] ) ) : home_url( '/' );
	$return  = wp_validate_redirect( $return, home_url( '/' ) );

	if ( ! isset( $forms[ $form_id ] ) || ! isset( $_POST['hara_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hara_nonce'] ), 'hara_enquiry_' . $form_id ) ) {
		wp_safe_redirect( $return );
		exit;
	}

	// Honeypot: bots fill every field. Pretend success.
	if ( ! empty( $_POST['hara_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'hara_sent', $form_id, $return ) . '#hara-form-' . $form_id );
		exit;
	}

	$raw    = isset( $_POST['hara'] ) && is_array( $_POST['hara'] ) ? wp_unslash( $_POST['hara'] ) : array();
	$values = array();
	$valid  = true;
	foreach ( $forms[ $form_id ]['fields'] as $key => $field ) {
		$type  = isset( $field['type'] ) ? $field['type'] : 'text';
		$value = isset( $raw[ $key ] ) ? (string) $raw[ $key ] : '';
		$value = 'textarea' === $type ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
		if ( 'email' === $type ) {
			$value = sanitize_email( $value );
			if ( $value && ! is_email( $value ) ) {
				$value = '';
			}
		}
		if ( 'select' === $type && $value && ! in_array( $value, $field['options'], true ) ) {
			$value = '';
		}
		if ( ! empty( $field['required'] ) && '' === $value ) {
			$valid = false;
		}
		$values[ $key ] = mb_substr( $value, 0, 5000 );
	}

	if ( ! $valid ) {
		wp_safe_redirect( add_query_arg( 'hara_error', $form_id, $return ) . '#hara-form-' . $form_id );
		exit;
	}

	// Labelled copy for the admin screen and email.
	$labelled = array();
	foreach ( $forms[ $form_id ]['fields'] as $key => $field ) {
		$labelled[ $field['label'] ] = $values[ $key ];
	}

	$who   = ! empty( $values['organisation'] ) ? $values['organisation'] . ' — ' . $values['name'] : $values['name'];
	$title = ucfirst( $form_id ) . ': ' . $who;

	$post_id = wp_insert_post( array(
		'post_type'   => 'hara_enquiry',
		'post_status' => 'pending',
		'post_title'  => $title,
	) );
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, 'hara_type', $form_id );
		update_post_meta( $post_id, 'hara_fields', $labelled );
		update_post_meta( $post_id, 'hara_email', $values['email'] ?? '' );
		update_post_meta( $post_id, 'hara_phone', $values['phone'] ?? '' );
	}

	$to = array_filter( array_map( 'trim', explode( ',', hara_opt( 'enquiry_emails', get_option( 'admin_email' ) ) ) ), 'is_email' );
	if ( $to ) {
		$body = '';
		foreach ( $labelled as $label => $value ) {
			$body .= $label . ":\n" . ( '' === $value ? '—' : $value ) . "\n\n";
		}
		if ( $post_id ) {
			$body .= 'View in WordPress: ' . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . "\n";
		}
		$headers = array();
		if ( ! empty( $values['email'] ) ) {
			$headers[] = 'Reply-To: ' . str_replace( array( "\r", "\n" ), '', $values['name'] ) . ' <' . $values['email'] . '>';
		}
		wp_mail( $to, '[HaRa Foods website] ' . $forms[ $form_id ]['title'] . ' from ' . $who, $body, $headers );
	}

	wp_safe_redirect( add_query_arg( 'hara_sent', $form_id, remove_query_arg( 'hara_error', $return ) ) . '#hara-form-' . $form_id );
	exit;
}
