<?php
/**
 * Tiny helpers that output block markup exactly as the block editor saves it,
 * so seeded pages open cleanly (no "invalid block" warnings) and stay editable.
 */

function hb_attrs( array $attrs ) {
	$attrs = array_filter( $attrs, function ( $v ) { return null !== $v && '' !== $v && array() !== $v; } );
	return $attrs ? ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : '';
}

function hb_class( array $classes ) {
	$classes = array_filter( $classes );
	return $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';
}

function hb_p( $html, $class = '', $align = '' ) {
	$classes = array( $align ? 'has-text-align-' . $align : '', $class );
	return "<!-- wp:paragraph" . hb_attrs( array( 'align' => $align, 'className' => $class ) ) . " -->\n<p" . hb_class( $classes ) . ">{$html}</p>\n<!-- /wp:paragraph -->\n\n";
}

function hb_h( $html, $level = 2, $class = '', $align = '' ) {
	$attrs = array( 'textAlign' => $align, 'level' => 2 === $level ? null : $level, 'className' => $class );
	$classes = array( 'wp-block-heading', $align ? 'has-text-align-' . $align : '', $class );
	return "<!-- wp:heading" . hb_attrs( $attrs ) . " -->\n<h{$level}" . hb_class( $classes ) . ">{$html}</h{$level}>\n<!-- /wp:heading -->\n\n";
}

function hb_group( $inner, $class = '', $full = false ) {
	$attrs   = array( 'align' => $full ? 'full' : '', 'className' => $class );
	$classes = array( 'wp-block-group', $full ? 'alignfull' : '', $class );
	return "<!-- wp:group" . hb_attrs( $attrs ) . " -->\n<div" . hb_class( $classes ) . ">{$inner}</div>\n<!-- /wp:group -->\n\n";
}

function hb_section( $inner, $extra_class = '' ) {
	return hb_group( $inner, trim( 'hara-section ' . $extra_class ), true );
}

/**
 * @param array  $cols  Each item: string inner, or array( inner, width e.g. '55%' ).
 */
function hb_columns( array $cols, $class = '', $valign = '' ) {
	$out = '';
	foreach ( $cols as $col ) {
		$inner = is_array( $col ) ? $col[0] : $col;
		$width = is_array( $col ) ? $col[1] : '';
		$out  .= "<!-- wp:column" . hb_attrs( array( 'width' => $width ) ) . " -->\n<div class=\"wp-block-column\"" . ( $width ? ' style="flex-basis:' . esc_attr( $width ) . '"' : '' ) . ">{$inner}</div>\n<!-- /wp:column -->\n\n";
	}
	$classes = array( 'wp-block-columns', $valign ? 'are-vertically-aligned-' . $valign : '', $class );
	return "<!-- wp:columns" . hb_attrs( array( 'verticalAlignment' => $valign, 'className' => $class ) ) . " -->\n<div" . hb_class( $classes ) . ">{$out}</div>\n<!-- /wp:columns -->\n\n";
}

/** @param array $buttons Each: array( text, url, outline bool ) */
function hb_buttons( array $buttons, $align = '' ) {
	$out = '';
	foreach ( $buttons as $b ) {
		$outline = ! empty( $b[2] );
		$out    .= "<!-- wp:button" . hb_attrs( array( 'className' => $outline ? 'is-style-outline' : '' ) ) . " -->\n<div class=\"wp-block-button" . ( $outline ? ' is-style-outline' : '' ) . "\"><a class=\"wp-block-button__link wp-element-button\" href=\"" . esc_url( $b[1] ) . "\">" . esc_html( $b[0] ) . "</a></div>\n<!-- /wp:button -->\n\n";
	}
	$attrs = $align ? array( 'layout' => array( 'type' => 'flex', 'justifyContent' => $align ) ) : array();
	return "<!-- wp:buttons" . hb_attrs( $attrs ) . " -->\n<div class=\"wp-block-buttons\">{$out}</div>\n<!-- /wp:buttons -->\n\n";
}

function hb_shortcode( $code ) {
	return "<!-- wp:shortcode -->\n{$code}\n<!-- /wp:shortcode -->\n\n";
}

function hb_list( array $items, $ordered = false ) {
	$tag = $ordered ? 'ol' : 'ul';
	$out = '';
	foreach ( $items as $item ) {
		$out .= "<!-- wp:list-item -->\n<li>{$item}</li>\n<!-- /wp:list-item -->\n\n";
	}
	return "<!-- wp:list" . hb_attrs( array( 'ordered' => $ordered ? true : null ) ) . " -->\n<{$tag} class=\"wp-block-list\">{$out}</{$tag}>\n<!-- /wp:list -->\n\n";
}

function hb_details( $summary, $inner_html ) {
	return "<!-- wp:details -->\n<details class=\"wp-block-details\"><summary>{$summary}</summary>{$inner_html}</details>\n<!-- /wp:details -->\n\n";
}

function hb_separator() {
	return "<!-- wp:separator -->\n<hr class=\"wp-block-separator has-alpha-channel-opacity\"/>\n<!-- /wp:separator -->\n\n";
}

/** Small helper to build a "section head" (eyebrow + heading + lead). */
function hb_head( $eyebrow, $title, $lead = '', $center = false ) {
	$inner = ( $eyebrow ? hb_p( $eyebrow, 'hara-eyebrow' ) : '' ) . hb_h( $title ) . ( $lead ? hb_p( $lead, 'hara-lead' ) : '' );
	return hb_group( $inner, 'hara-section__head' . ( $center ? ' hara-center' : '' ) );
}
