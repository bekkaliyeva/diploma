<?php
/////////////////////////////////////////////////////////////////////////////////////////
//   Standard sanitization functions.
/////////////////////////////////////////////////////////////////////////////////////////
/**
 * Sanitizes a checkbox value.
 *
 * @param int|string|bool $input Input value to sanitize.
 * @return int|string Returns 1 if $input evaluates to 1, an empty string otherwise.
 */
function olsen_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	}

	return '';
}

/**
 * Sanitizes a checkbox value. Value is passed by reference.
 *
 * Useful when sanitizing form checkboxes. Since browsers don't send any data when a checkbox
 * is not checked, olsen_sanitize_checkbox() throws an error.
 * olsen_sanitize_checkbox_ref() however evaluates &$input as null so no errors are thrown.
 *
 * @param int|string|bool &$input Input value to sanitize.
 * @return int|string Returns 1 if $input evaluates to 1, an empty string otherwise.
 */
function olsen_sanitize_checkbox_ref( &$input ) {
	if ( $input == 1 ) {
		return 1;
	}

	return '';
}


/**
 * Sanitizes the pagination method option.
 *
 * @param string $option Value to sanitize. Either 'numbers' or 'text'.
 * @return string
 */
function olsen_sanitize_pagination_method( $option ) {
	if( in_array( $option, array( 'numbers', 'text' ) ) ) {
		return $option;
	}

	return 'numbers';
}

/**
 * Returns a sanitized hex color code.
 *
 * @param string $str The color string to be sanitized.
 * @param bool $return_hash Whether to return the color code prepended by a hash.
 * @param string $return_fail The value to return on failure.
 * @return string A valid hex color code on success, an empty string on failure.
 */
function olsen_sanitize_hex_color( $str, $return_hash = true, $return_fail = '' ) {
	if( $str === false || empty( $str ) || $str == 'false' ) {
		return $return_fail;
	}

	// Allow keywords and predefined colors
	if ( in_array( $str, array( 'transparent', 'initial', 'inherit', 'black', 'silver', 'gray', 'grey', 'white', 'maroon', 'red', 'purple', 'fuchsia', 'green', 'lime', 'olive', 'yellow', 'navy', 'blue', 'teal', 'aqua', 'orange', 'aliceblue', 'antiquewhite', 'aquamarine', 'azure', 'beige', 'bisque', 'blanchedalmond', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgrey', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkslategrey', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dimgrey', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'greenyellow', 'grey', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightslategrey', 'lightsteelblue', 'lightyellow', 'limegreen', 'linen', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'oldlace', 'olivedrab', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'skyblue', 'slateblue', 'slategray', 'slategrey', 'snow', 'springgreen', 'steelblue', 'tan', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'whitesmoke', 'yellowgreen', 'rebeccapurple' ) ) ) {
		return $str;
	}

	// Include the hash if not there.
	// The regex below depends on in.
	if ( substr( $str, 0, 1 ) != '#' ) {
		$str = '#' . $str;
	}

	preg_match( '/(#)([0-9a-fA-F]{6})/', $str, $matches );

	if ( count( $matches ) == 3 ) {
		if ( $return_hash ) {
			return $matches[1] . $matches[2];
		} else {
			return $matches[2];
		}
	}

	return $return_fail;
}

/**
 * Sanitize user-provided CSS code, as recommended in https://make.wordpress.org/themes/2015/02/10/custom-css-boxes-in-themes/
 *
 * @param string $string The CSS code to sanitize.
 * @return string
 */
function olsen_sanitize_custom_css( $string ) {
	$string = wp_strip_all_tags( $string, false );

	return $string;
}

function olsen_get_image_position_x_choices() {
	return apply_filters( 'olsen_image_position_x_choices', array(
		'left'   => esc_html__( 'Left', 'olsen' ),
		'center' => esc_html__( 'Center', 'olsen' ),
		'right'  => esc_html__( 'Right', 'olsen' ),
	) );
}

function olsen_sanitize_image_position_x( $value ) {
	$choices = olsen_get_image_position_x_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_position_x_default', 'center' );
}

function olsen_get_image_position_y_choices() {
	return apply_filters( 'olsen_image_position_y_choices', array(
		'top'    => esc_html__( 'Top', 'olsen' ),
		'center' => esc_html__( 'Center', 'olsen' ),
		'bottom' => esc_html__( 'Bottom', 'olsen' ),
	) );
}

function olsen_sanitize_image_position_y( $value ) {
	$choices = olsen_get_image_position_y_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_position_y_default', 'center' );
}

/**
 * Sanitizes integer input while differentiating zero from empty string.
 *
 * @param int|string $input Input value to sanitize.
 * @return int|string Integer value, 0, or an empty string otherwise.
 */
function olsen_sanitize_intval_or_empty( $input ) {
	if ( false === $input || '' === $input || is_null( $input ) ) {
		return '';
	}

	if ( 0 === intval( $input ) ) {
		return 0;
	}

	return intval( $input );
}

/**
 * Sanitizes float input while differentiating zero from empty string.
 *
 * @param int|string $input Input value to sanitize.
 * @return int|string Integer value, 0, or an empty string otherwise.
 */
function olsen_sanitize_floatval_or_empty( $input ) {
	if ( false === $input || '' === $input || is_null( $input ) ) {
		return '';
	}

	if ( 0 === floatval( $input ) ) {
		return 0;
	}

	return floatval( $input );
}

/**
 * Return a list of allowed tags and attributes for a given context.
 *
 * @param string $context The context for which to retrieve tags.
 *                        Currently available contexts: guide
 * @return array List of allowed tags and their allowed attributes.
 */
function olsen_get_allowed_tags( $context = '' ) {
	$allowed = array(
		'a'       => array(
			'href'   => true,
			'title'  => true,
			'class'  => true,
			'target' => true,
			'rel'    => true,
		),
		'abbr'    => array( 'title' => true ),
		'acronym' => array( 'title' => true ),
		'b'       => array( 'class' => true ),
		'br'      => array(),
		'code'    => array( 'class' => true ),
		'em'      => array( 'class' => true ),
		'i'       => array( 'class' => true ),
		'img'     => array(
			'alt'    => true,
			'class'  => true,
			'src'    => true,
			'width'  => true,
			'height' => true,
		),
		'li'      => array( 'class' => true ),
		'ol'      => array( 'class' => true ),
		'p'       => array( 'class' => true ),
		'pre'     => array( 'class' => true ),
		'span'    => array( 'class' => true ),
		'strong'  => array( 'class' => true ),
		'ul'      => array( 'class' => true ),
	);

	switch ( $context ) {
		case 'guide':
			unset( $allowed['p'] );
			break;
		default:
			break;
	}

	return apply_filters( 'olsen_get_allowed_tags', $allowed, $context );
}

/**
 * Return a list of allowed tags and attributes, making sure the tags needed for a search form are included.
 *
 * @see wp_kses_post()
 *
 * @return array List of allowed tags and their allowed attributes.
 */
function olsen_get_allowed_tags_search_form() {
	$allowed = array_merge( wp_kses_allowed_html( 'post' ), array(
		'form'  => array(
			'action'         => true,
			'accept'         => true,
			'accept-charset' => true,
			'enctype'        => true,
			'method'         => true,
			'name'           => true,
			'target'         => true,
			'id'             => true,
			'class'          => true,
		),
		'label' => array(
			'for'   => true,
			'class' => true,
		),
		'input' => array(
			'type'        => true,
			'name'        => true,
			'value'       => true,
			'id'          => true,
			'class'       => true,
			'placeholder' => true,
		),
	) );

	return apply_filters( 'olsen_get_allowed_tags_search_form', $allowed );
}

function olsen_get_image_repeat_choices() {
	return apply_filters( 'olsen_image_repeat_choices', array(
		'no-repeat' => esc_html__( 'No repeat', 'olsen' ),
		'repeat'    => esc_html__( 'Tile', 'olsen' ),
		'repeat-x'  => esc_html__( 'Tile Horizontally', 'olsen' ),
		'repeat-y'  => esc_html__( 'Tile Vertically', 'olsen' ),
	) );
}

function olsen_sanitize_image_repeat( $value ) {
	$choices = olsen_get_image_repeat_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_repeat_default', 'no-repeat' );
}

function olsen_get_image_position_choices() {
	return apply_filters( 'olsen_image_position_choices', array(
		'left top'      => esc_html__( 'Top Left', 'olsen' ),
		'center top'    => esc_html__( 'Top Center', 'olsen' ),
		'right top'     => esc_html__( 'Top Right', 'olsen' ),
		'left center'   => esc_html__( 'Center Left', 'olsen' ),
		'center center' => esc_html__( 'Center Center', 'olsen' ),
		'right center'  => esc_html__( 'Center Right', 'olsen' ),
		'left bottom'   => esc_html__( 'Bottom Left', 'olsen' ),
		'center bottom' => esc_html__( 'Bottom Center', 'olsen' ),
		'right bottom'  => esc_html__( 'Bottom Right', 'olsen' ),
	) );
}
function olsen_sanitize_image_position( $value ) {
	$choices = olsen_get_image_position_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_position_default', 'center top' );
}


function olsen_get_image_attachment_choices() {
	return apply_filters( 'olsen_image_attachment_choices', array(
		'scroll' => esc_html__( 'Scroll', 'olsen' ),
		'fixed'  => esc_html__( 'Fixed', 'olsen' ),
	) );
}

function olsen_sanitize_image_attachment( $value ) {
	$choices = olsen_get_image_attachment_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_attachment_default', 'scroll' );
}

function olsen_get_image_size_choices() {
	return apply_filters( 'olsen_image_size_choices', array(
		'cover'   => esc_html__( 'Cover', 'olsen' ),
		'contain' => esc_html__( 'Contain', 'olsen' ),
		'auto'    => esc_html__( 'Auto', 'olsen' ),
	) );
}

function olsen_sanitize_image_size( $value ) {
	$choices = olsen_get_image_size_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_image_size_default', 'cover' );
}

function olsen_sanitize_rgba_color( $str, $return_hash = true, $return_fail = '' ) {
	if ( false === $str || empty( $str ) || 'false' === $str ) {
		return $return_fail;
	}

	// Allow keywords and predefined colors
	if ( in_array( $str, array( 'transparent', 'initial', 'inherit', 'black', 'silver', 'gray', 'grey', 'white', 'maroon', 'red', 'purple', 'fuchsia', 'green', 'lime', 'olive', 'yellow', 'navy', 'blue', 'teal', 'aqua', 'orange', 'aliceblue', 'antiquewhite', 'aquamarine', 'azure', 'beige', 'bisque', 'blanchedalmond', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgrey', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkslategrey', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dimgrey', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'greenyellow', 'grey', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightslategrey', 'lightsteelblue', 'lightyellow', 'limegreen', 'linen', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'oldlace', 'olivedrab', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'skyblue', 'slateblue', 'slategray', 'slategrey', 'snow', 'springgreen', 'steelblue', 'tan', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'whitesmoke', 'yellowgreen', 'rebeccapurple' ), true ) ) {
		return $str;
	}

	preg_match( '/rgba\(\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1,3}\.?\d*\%?)\s*,\s*(\d{1}\.?\d*\%?)\s*\)/', $str, $rgba_matches );
	if ( ! empty( $rgba_matches ) && 5 === count( $rgba_matches ) ) {
		for ( $i = 1; $i < 4; $i++ ) {
			if ( strpos( $rgba_matches[ $i ], '%' ) !== false ) {
				$rgba_matches[ $i ] = olsen_sanitize_0_100_percent( $rgba_matches[ $i ] );
			} else {
				$rgba_matches[ $i ] = olsen_sanitize_0_255( $rgba_matches[ $i ] );
			}
		}
		$rgba_matches[4] = olsen_sanitize_0_1_opacity( $rgba_matches[ $i ] );
		return sprintf( 'rgba(%s, %s, %s, %s)', $rgba_matches[1], $rgba_matches[2], $rgba_matches[3], $rgba_matches[4] );
	}

	// Not a color function either. Let's see if it's a hex color.

	// Include the hash if not there.
	// The regex below depends on in.
	$str = '#' . ltrim( $str, '#' );

	preg_match( '/(#)([0-9a-fA-F]{6})/', $str, $matches );

	if ( 3 === count( $matches ) ) {
		if ( $return_hash ) {
			return $matches[1] . $matches[2];
		} else {
			return $matches[2];
		}
	}

	return $return_fail;
}

function olsen_sanitize_0_100_percent( $val ) {
	$val = str_replace( '%', '', $val );
	if ( floatval( $val ) > 100 ) {
		$val = 100;
	} elseif ( floatval( $val ) < 0 ) {
		$val = 0;
	}

	return floatval( $val ) . '%';
}

function olsen_sanitize_0_255( $val ) {
	if ( intval( $val ) > 255 ) {
		$val = 255;
	} elseif ( intval( $val ) < 0 ) {
		$val = 0;
	}

	return intval( $val );
}

function olsen_sanitize_0_1_opacity( $val ) {
	if ( floatval( $val ) > 1 ) {
		$val = 1;
	} elseif ( floatval( $val ) < 0 ) {
		$val = 0;
	}

	return floatval( $val );
}

function olsen_global_layout_type_choices() {
	$choices = array(
		'full_width' => __( 'Full width', 'olsen' ),
		'boxed'      => __( 'Boxed', 'olsen' ),
	);

	return apply_filters( 'olsen_global_layout_type_choices', $choices );
}

function olsen_global_layout_type_default() {
	return apply_filters( 'olsen_global_layout_type_default', olsen_customizer_defaults( 'global_layout_type' ) );
}

function olsen_sanitize_global_layout_type( $value ) {
	$choices = olsen_global_layout_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_global_layout_type_default();
}



/**
 * Base set of theme's page layouts. Individual options may add/remove elements as needed.
 *
 * @return array
 */
function olsen_get_layout_types() {
	return apply_filters( 'olsen_layout_types', array(
		'content_sidebar'  => __( 'Content / Sidebar', 'olsen' ),
		'sidebar_content'  => __( 'Sidebar / Content', 'olsen' ),
		'fullwidth'        => __( 'Full width', 'olsen' ),
		'fullwidth_narrow' => __( 'Full width narrow', 'olsen' ),
	) );
}



function olsen_global_layout_pages_layout_type_choices() {
	$choices = olsen_get_layout_types();

	return apply_filters( 'olsen_global_layout_pages_layout_type_choices', $choices );
}

function olsen_global_layout_pages_layout_type_default() {
	return apply_filters( 'olsen_global_layout_pages_layout_type_default', olsen_customizer_defaults( 'global_layout_pages_layout_type' ) );
}

function olsen_sanitize_global_layout_pages_layout_type( $value ) {
	$choices = olsen_global_layout_pages_layout_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_global_layout_pages_layout_type_default();
}



function olsen_blog_layout_archives_layout_type_choices() {
	$choices = olsen_get_layout_types();

	return apply_filters( 'olsen_blog_layout_archives_layout_type_choices', $choices );
}

function olsen_blog_layout_archives_layout_type_default() {
	return apply_filters( 'olsen_blog_layout_archives_layout_type_default', olsen_customizer_defaults( 'blog_layout_archives_layout_type' ) );
}

function olsen_sanitize_blog_layout_archives_layout_type( $value ) {
	$choices = olsen_blog_layout_archives_layout_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_blog_layout_archives_layout_type_default();
}



function olsen_blog_layout_posts_layout_type_choices() {
	/* translators: %d is a number of columns. */
	$nooped = _n_noop( '%d Column', '%d Columns', 'olsen' );

	$choices = array(
		'1col-horz' => __( '1 Column horizontal', 'olsen' ),
		'1col'      => sprintf( translate_nooped_plural( $nooped, 1, 'olsen' ), 1 ),
		'2col'      => sprintf( translate_nooped_plural( $nooped, 2, 'olsen' ), 2 ),
		'3col'      => sprintf( translate_nooped_plural( $nooped, 3, 'olsen' ), 3 ),
		'4col'      => sprintf( translate_nooped_plural( $nooped, 4, 'olsen' ), 4 ),
	);

	return apply_filters( 'olsen_blog_layout_posts_layout_type_choices', $choices );
}

function olsen_blog_layout_posts_layout_type_default() {
	return apply_filters( 'olsen_blog_layout_posts_layout_type_default', olsen_customizer_defaults( 'blog_layout_posts_layout_type' ) );
}

function olsen_sanitize_blog_layout_posts_layout_type( $value ) {
	$choices = olsen_blog_layout_posts_layout_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_blog_layout_posts_layout_type_default();
}



function olsen_blog_layout_single_related_columns_choices() {
	/* translators: %d is a number of columns. */
	$nooped = _n_noop( '%d Column', '%d Columns', 'olsen' );

	$choices = array(
		'2' => sprintf( translate_nooped_plural( $nooped, 2, 'olsen' ), 2 ),
		'3' => sprintf( translate_nooped_plural( $nooped, 3, 'olsen' ), 3 ),
		'4' => sprintf( translate_nooped_plural( $nooped, 4, 'olsen' ), 4 ),
	);

	return apply_filters( 'olsen_blog_layout_single_related_columns_choices', $choices );
}

function olsen_blog_layout_single_related_columns_default() {
	return apply_filters( 'olsen_blog_layout_single_related_columns_default', olsen_customizer_defaults( 'blog_layout_single_related_columns' ) );
}

function olsen_sanitize_blog_layout_single_related_columns( $value ) {
	$choices = olsen_blog_layout_single_related_columns_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_blog_layout_single_related_columns_default();
}



function olsen_archives_pagination_choices() {
	$choices = array(
		'numbers'  => _x( 'Numbers', 'pagination method', 'olsen' ),
		'prevnext' => _x( 'Previous / Next', 'pagination method', 'olsen' ),
	);

	return apply_filters( 'olsen_archives_pagination_choices', $choices );
}

function olsen_archives_pagination_default() {
	return apply_filters( 'olsen_archives_pagination_default', olsen_customizer_defaults( 'blog_layout_archives_pagination' ) );
}

function olsen_sanitize_archives_pagination( $value ) {
	$choices = olsen_archives_pagination_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_archives_pagination_default();
}



function olsen_header_layout_menu_type_choices() {
	$choices = array(
		'full_left'            => __( 'Menu Left', 'olsen' ),
		'full_center'          => __( 'Menu Center', 'olsen' ),
		'full_right'           => __( 'Menu Right', 'olsen' ),
		'split'                => __( 'Menu Split', 'olsen' ),
		'navbar_top_left'      => __( 'Menu Top Left', 'olsen' ),
		'navbar_top_center'    => __( 'Menu Top Center', 'olsen' ),
		'navbar_top_right'     => __( 'Menu Top Right', 'olsen' ),
		'navbar_bottom_left'   => __( 'Menu Bottom Left', 'olsen' ),
		'navbar_bottom_center' => __( 'Menu Bottom Center', 'olsen' ),
		'navbar_bottom_right'  => __( 'Menu Bottom Right', 'olsen' ),
	);

	return apply_filters( 'olsen_header_layout_menu_type_choices', $choices );
}

function olsen_sanitize_header_layout_menu_type( $value ) {
	$choices = olsen_header_layout_menu_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_customizer_defaults( 'header_layout_menu_type' );
}



function olsen_devices_visibility_choices() {
	$choices = array(
		'all'        => __( 'All Devices', 'olsen' ),
		'desktop'    => __( 'Desktop Only', 'olsen' ),
		'all_mobile' => __( 'Tablets & Mobile Devices', 'olsen' ),
		'mobile'     => __( 'Mobile Devices', 'olsen' ),
	);

	return apply_filters( 'olsen_devices_visibility_choices', $choices );
}

function olsen_devices_visibility_default() {
	return apply_filters( 'olsen_devices_visibility_default', 'all' );
}

function olsen_sanitize_devices_visibility( $value ) {
	$choices = olsen_devices_visibility_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_devices_visibility_default();
}



function olsen_get_devices_visibility_class( $devices ) {
	$class = '';

	switch ( $devices ) {
		case 'desktop':
			$class = 'hidden-lg-down';
			break;
		case 'all_mobile':
			$class = 'hidden-xl-up';
			break;
		case 'mobile':
			$class = 'hidden-md-up';
			break;
		case 'all':
		default:
			$class = '';
			break;
	}

	return apply_filters( 'olsen_devices_visibility_class', $class, $devices );
}



function olsen_header_layout_type_choices() {
	$choices = array(
		'normal'      => __( 'Normal', 'olsen' ),
		'transparent' => __( 'Transparent', 'olsen' ),
	);

	return apply_filters( 'olsen_header_layout_type_choices', $choices );
}

function olsen_sanitize_header_layout_type( $value ) {
	$choices = olsen_header_layout_type_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_customizer_defaults( 'header_layout_type' );
}



function olsen_text_tag_choices() {
	$choices = array(
		'h1'   => __( 'Heading 1 (h1)', 'olsen' ),
		'h2'   => __( 'Heading 2 (h2)', 'olsen' ),
		'h3'   => __( 'Heading 3 (h3)', 'olsen' ),
		'h4'   => __( 'Heading 4 (h4)', 'olsen' ),
		'h5'   => __( 'Heading 5 (h5)', 'olsen' ),
		'h6'   => __( 'Heading 6 (h6)', 'olsen' ),
		'p'    => __( 'Paragraph (p)', 'olsen' ),
		'span' => __( 'Span (span)', 'olsen' ),
		'div'  => __( 'Division (div)', 'olsen' ),
	);

	return apply_filters( 'olsen_text_tag_choices', $choices );
}

function olsen_text_tag_default() {
	return apply_filters( 'olsen_text_tag_default', 'p' );
}

function olsen_sanitize_text_tag( $value ) {
	$choices = olsen_text_tag_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return olsen_text_tag_default();
}



function olsen_align_horizontal_choices() {
	return apply_filters( 'olsen_align_horizontal_choices', array(
		'left'   => esc_html__( 'Left', 'olsen' ),
		'center' => esc_html__( 'Center', 'olsen' ),
		'right'  => esc_html__( 'Right', 'olsen' ),
	) );
}

function olsen_sanitize_align_horizontal( $value ) {
	$choices = olsen_align_horizontal_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_align_horizontal_default', 'center' );
}



function olsen_align_vertical_choices() {
	return apply_filters( 'olsen_align_vertical_choices', array(
		'top'    => esc_html__( 'Top', 'olsen' ),
		'middle' => esc_html__( 'Middle', 'olsen' ),
		'bottom' => esc_html__( 'Bottom', 'olsen' ),
	) );
}

function olsen_sanitize_align_vertical( $value ) {
	$choices = olsen_align_vertical_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_align_vertical_default', 'center' );
}

function olsen_assets_minify_pack_choices() {
	return apply_filters( 'olsen_assets_minify_pack_choices', array(
		'none'        => esc_html__( 'None', 'olsen' ),
		'minify'      => esc_html__( 'Minify', 'olsen' ),
		'minify_pack' => esc_html__( 'Minify & Pack', 'olsen' ),
	) );
}

function olsen_sanitize_assets_minify_pack( $value ) {
	$choices = olsen_assets_minify_pack_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return apply_filters( 'olsen_sanitize_assets_minify_pack_default', 'minify_pack' );
}

if ( ! function_exists( 'olsen_sanitize_blog_terms_layout' ) ) :
	function olsen_sanitize_blog_terms_layout( $layout ) {
		$layouts = array(
			'classic_2side',
			'classic_2side_right',
			'classic_1side',
			'classic_full',
			'small_side',
			'small_full',
			'small_full_narrow',
			'2cols_side',
			'2cols_full',
			'2cols_narrow',
			'2cols_masonry',
			'3cols_full',
			'3cols_masonry',
		);
		if ( in_array( $layout, $layouts ) ) {
			return $layout;
		}

		return 'classic_1side';
	}
endif;

if ( ! function_exists( 'olsen_sanitize_other_layout' ) ) :
	function olsen_sanitize_other_layout( $layout ) {
		$layouts = array(
			'side',
			'full',
		);
		if ( in_array( $layout, $layouts ) ) {
			return $layout;
		}

		return 'side';
	}
endif;