<?php
function olsen_wrap_archive_widget_post_counts_in_span( $output ) {
	$output = preg_replace_callback( '#(<li>.*?<a.*?>.*?</a>.*&nbsp;)(\(.*?\))(.*?</li>)#', 'olsen_replace_archive_widget_post_counts_in_span', $output );

	return $output;
}

function olsen_replace_archive_widget_post_counts_in_span( $matches ) {
	return sprintf( '%s<span class="ci-count">%s</span>%s',
		$matches[1],
		$matches[2],
		$matches[3]
	);
}

function olsen_wrap_category_widget_post_counts_in_span( $output, $args ) {
	if ( ! isset( $args['show_count'] ) || $args['show_count'] == 0 ) {
		return $output;
	}
	$output = preg_replace_callback( '#(<a.*?>\s*)(\(.*?\))#', 'olsen_replace_category_widget_post_counts_in_span', $output );

	return $output;
}

function olsen_replace_category_widget_post_counts_in_span( $matches ) {
	return sprintf( '%s<span class="ci-count">%s</span>',
		$matches[1],
		$matches[2]
	);
}


/**
 * Returns the appropriate page(d) query variable to use in custom loops (needed for pagination).
 *
 * @uses get_query_var()
 *
 * @param int $default_return The default page number to return, if no query vars are set.
 * @return int The appropriate paged value if found, else 0.
 */
function olsen_get_page_var( $default_return = 0 ) {
	$paged = get_query_var( 'paged', false );
	$page  = get_query_var( 'page', false );

	if ( $paged === false && $page === false ) {
		return $default_return;
	}

	return max( $paged, $page );
}

/**
 * Returns just the URL of an image attachment.
 *
 * @param int $image_id The Attachment ID of the desired image.
 * @param string $size The size of the image to return.
 * @return bool|string False on failure, image URL on success.
 */
function olsen_get_image_src( $image_id, $size = 'full' ) {
	$img_attr = wp_get_attachment_image_src( intval( $image_id ), $size );
	if ( ! empty( $img_attr[0] ) ) {
		return $img_attr[0];
	}
}

/**
 * Returns the n-th first characters of a string.
 * Uses substr() so return values are the same.
 *
 * @param string $string The string to get the characters from.
 * @param string $length The number of characters to return.
 * @return string
 */
function olsen_substr_left( $string, $length ) {
	return substr( $string, 0, $length );
}

/**
 * Returns the n-th last characters of a string.
 * Uses substr() so return values are the same.
 *
 * @param string $string The string to get the characters from.
 * @param string $length The number of characters to return.
 * @return string
 */
function olsen_substr_right( $string, $length ) {
	return substr( $string, - $length, $length );
}

if ( ! function_exists( 'ci_get_related_posts' ) ):
/**
 * Returns a set of related posts, or the arguments needed for such a query.
 *
 * @uses wp_parse_args()
 * @uses get_post_type()
 * @uses get_post()
 * @uses get_object_taxonomies()
 * @uses get_the_terms()
 * @uses wp_list_pluck()
 *
 * @param int $post_id A post ID to get related posts for.
 * @param int $related_count The number of related posts to return.
 * @param array $args Array of arguments to change the default behavior.
 * @return object|array A WP_Query object with the results, or an array with the query arguments.
 */
function ci_get_related_posts( $post_id, $related_count, $args = array() ) {
	$args = wp_parse_args( (array) $args, array(
		'orderby' => 'rand',
		'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array)
	) );

	$post_type = get_post_type( $post_id );
	$post      = get_post( $post_id );

	$term_list  = array();
	$query_args = array();
	$tax_query  = array();
	$taxonomies = get_object_taxonomies( $post, 'names' );

	foreach ( $taxonomies as $taxonomy ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( is_array( $terms ) and count( $terms ) > 0 ) {
			$term_list = wp_list_pluck( $terms, 'slug' );
			$term_list = array_values( $term_list );
			if ( ! empty( $term_list ) ) {
				$tax_query['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term_list
				);
			}
		}
	}

	if ( count( $taxonomies ) > 1 ) {
		$tax_query['tax_query']['relation'] = 'OR';
	}

	$query_args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $related_count,
		'post_status'    => 'publish',
		'post__not_in'   => array( $post_id ),
		'orderby'        => $args['orderby']
	);

	if ( $args['return'] == 'query' ) {
		return new WP_Query( array_merge( $query_args, $tax_query ) );
	} else {
		return array_merge( $query_args, $tax_query );
	}
}
endif;



$olsen_glob_inline_js = array();
if ( ! function_exists( 'ci_add_inline_js' ) ):
/**
 * Registers an inline JS script.
 * The script will be printed on the footer of the current request's page, either on the front or the back end.
 * Inline scripts are printed inside a jQuery's ready() event handler, and $ is available.
 * Passing a $handle allows to reference and/or overwrite specific inline scripts.
 *
 * @param string $script A JS script to be printed.
 * @param string $handle An optional handle by which the script is referenced.
 */
function olsen_add_inline_js( $script, $handle = false ) {
	global $olsen_glob_inline_js;

	$handle = sanitize_key( $handle );

	if ( ( $handle !== false ) and ( $handle != '' ) ) {
		$olsen_glob_inline_js[ $handle ] = "\n" . $script . "\n";
	} else {
		$olsen_glob_inline_js[] = "\n" . $script . "\n";
	}
}
endif;

if ( ! function_exists( 'ci_get_inline_js' ) ):
/**
 * Retrieves the inline JS scripts that are registered for printing.
 *
 * @return array The inline JS scripts queued for printing.
 */
function olsen_get_inline_js() {
	global $olsen_glob_inline_js;

	return $olsen_glob_inline_js;
}
endif;

if ( ! function_exists( 'ci_print_inline_js' ) ):
/**
 * Prints the inline JS scripts that are registered for printing, and removes them from the queue.
 */
function olsen_print_inline_js() {
	global $olsen_glob_inline_js;

	if ( empty( $olsen_glob_inline_js ) ) {
		return;
	}

	$sanitized = array();

	foreach ( $olsen_glob_inline_js as $handle => $script ) {
		$sanitized[ $handle ] = wp_check_invalid_utf8( $script );
	}

	echo '<script type="text/javascript">' . "\n";
	echo "\t" . 'jQuery(document).ready(function($){' . "\n";

	foreach ( $sanitized as $handle => $script ) {
		echo "\n/* --- CI Theme Inline script ($handle) --- */\n";
		echo $script;
	}

	echo "\t" . '});' . "\n";
	echo '</script>' . "\n";

	$olsen_glob_inline_js = array();
}
endif;

if ( ! function_exists( 'olsen_inflect' ) ):
	/**
	 * Returns a string depending on the value of $num.
	 *
	 * When $num equals zero, string $none is returned.
	 * When $num equals one, string $one is returned.
	 * When $num is any other number, string $many is returned.
	 *
	 * @access public
	 *
	 * @param int $num
	 * @param string $none
	 * @param string $one
	 * @param string $many
	 *
	 * @return string
	 */
	function olsen_inflect( $num, $none, $one, $many ) {
		if ( $num == 0 ) {
			return $none;
		} elseif ( $num == 1 ) {
			return $one;
		} else {
			return $many;
		}
	}
endif;

if ( ! function_exists( 'olsen_e_inflect' ) ):
	/**
	 * Echoes a string depending on the value of $num.
	 *
	 * When $num equals zero, string $none is echoed.
	 * When $num equals one, string $one is echoed.
	 * When $num is any other number, string $many is echoed.
	 *
	 * @access public
	 *
	 * @param int $num
	 * @param string $none
	 * @param string $one
	 * @param string $many
	 *
	 * @return void
	 */
	function olsen_e_inflect( $num, $none, $one, $many ) {
		echo olsen_inflect( $num, $none, $one, $many );
	}
endif;

if ( ! function_exists( 'olsen_merge_wp_queries' ) ):
/**
 * Merges multiple WP_Queries by accepting any number of valid, discreet parameter arrays.
 * It runs each query individually, merges the (unique) post IDs, and re-queries the DB for those IDs, respecting their order.
 * Uses WP_Query() so parameters and return values are the same.
 *
 * @param array ... Unlimited WP_Query() parameter arrays.
 * @return WP_Query object
 */
function olsen_merge_wp_queries() {
	$args = func_get_args();

	if ( $args < 2 ) {
		return new WP_Query();
	}

	$merged         = array();
	$post_types     = array();
	$all_post_types = array(); // Will not be reset on iterations, so that there is a record of all post types needed.

	// Let's handle each query.
	foreach ( $args as $arg ) {
		// How many posts to get
		$numberposts = - 1;
		if ( ! empty( $arg['posts_per_page'] ) ) {
			$numberposts = $arg['posts_per_page'];
		} elseif ( ! empty( $arg['numberposts'] ) ) {
			$numberposts = $arg['numberposts'];
		} elseif ( ! empty( $arg['showposts'] ) ) {
			$numberposts = $arg['showposts'];
		}

		$arg['posts_per_page'] = $numberposts;

		// Make sure only IDs will be returned. We want the query to be lightweight.
		$arg['fields'] = 'ids';

		// What post types to retrieve
		if ( ! empty( $arg['post_type'] ) ) {
			$post_types = $arg['post_type'];

			// Keep the post type(s) for later use.
			if ( is_array( $post_types ) ) {
				$all_post_types = array_merge( $all_post_types, $post_types );
			} else {
				$all_post_types[] = $post_types;
			}
		}

		$this_posts = new WP_Query( $arg );

		foreach ( $this_posts->posts as $p ) {
			$merged[] = $p;
		}

		wp_reset_postdata();
	}

	$all_post_types = array_unique( $all_post_types );

	$merged = array_unique( $merged );

	if ( 0 === count( $merged ) ) {
		$merged[] = 0;
	}

	$params = array(
		'post__in'        => $merged,
		'post_type'       => $all_post_types,
		'posts_per_page'  => - 1,
		'suppress_filter' => false,
		'orderby'         => 'post__in'
	);

	$params = apply_filters( 'olsen_merge_wp_queries', $params, $args );

	$merged_query = new WP_Query( $params );

	return $merged_query;
}
endif;

if ( ! function_exists( 'olsen_dropdown_posts' ) ):
/**
 * Retrieve or display list of posts as a dropdown (select list).
 *
 * @since 2.1.0
 *
 * @param array|string $args Optional. Override default arguments.
 * @param string $name Optional. Name of the select box.
 * @return string HTML content, if not displaying.
 */
function olsen_dropdown_posts( $args = '', $name = 'post_id' ) {
	$defaults = array(
		'depth'                 => 0,
		'post_parent'           => 0,
		'selected'              => 0,
		'echo'                  => 1,
		//'name'                  => 'page_id', // With this line, get_posts() doesn't work properly.
		'id'                    => '',
		'class'                 => '',
		'show_option_none'      => '',
		'show_option_no_change' => '',
		'option_none_value'     => '',
		'post_type'             => 'post',
		'post_status'           => 'publish',
		'suppress_filters'      => false,
		'numberposts'           => -1,
		'select_even_if_empty'  => false, // If no posts are found, an empty <select> will be returned/echoed.
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$hierarchical_post_types = get_post_types( array( 'hierarchical' => true ) );
	if ( in_array( $r['post_type'], $hierarchical_post_types ) ) {
		$pages = get_pages($r);
	} else {
		$pages = get_posts($r);
	}

	$output = '';
	// Back-compat with old system where both id and name were based on $name argument
	if ( empty($id) )
		$id = $name;

	if ( ! empty($pages) || $select_even_if_empty == true ) {
		$output = "<select name='" . esc_attr( $name ) . "' id='" . esc_attr( $id ) . "' class='" . esc_attr( $class ) . "'>\n";
		if ( $show_option_no_change ) {
			$output .= "\t<option value=\"-1\">$show_option_no_change</option>";
		}
		if ( $show_option_none ) {
			$output .= "\t<option value=\"" . esc_attr( $option_none_value ) . "\">$show_option_none</option>\n";
		}
		if ( ! empty($pages) ) {
			$output .= walk_page_dropdown_tree($pages, $depth, $r);
		}
		$output .= "</select>\n";
	}

	$output = apply_filters( 'olsen_dropdown_posts', $output, $name, $r );

	if ( $echo )
		echo $output;

	return $output;
}
endif;

/**
 * Determine whether a plugin is active.
 *
 * @param string $plugin The path to the plugin file, relative to the plugins directory.
 * @return bool True if plugin is active, false otherwise.
 */
function olsen_can_use_plugin( $plugin ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	return is_plugin_active( $plugin );
}

/**
 * Outputs a preconnect link that helps performance of Google Fonts.
 * Hooked conditionally on 'wp_head'.
 */
function olsen_head_preconnect_google_fonts() {
	?>
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<?php
}

// Make sure this function is defined, even if the plugin is disabled.
if ( ! function_exists( 'olsen_documentation_url' ) ) {
	/**
	 * Returns the URL to the theme's documentation page.
	 *
	 * @return string
	 */
	function olsen_documentation_url() {
		$url = 'https://www.cssigniter.com/docs/olsen/';

		return apply_filters( 'olsen_documentation_url', $url );
	}
}

if ( ! function_exists( 'olsen_color_luminance' ) ) :
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.
	 *
	 * @see https://gist.github.com/stephenharris/5532899
	 *
	 * @param string $color Hexadecimal color value. May be 3 or 6 digits, with an optional leading # sign.
	 * @param float $percent Decimal (0.2 = lighten by 20%, -0.4 = darken by 40%)
	 *
	 * @return string Lightened/Darkened colour as hexadecimal (with hash)
	 */
	function olsen_color_luminance( $color, $percent ) {
		// Remove # if provided
		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		// Validate hex string.
		$hex     = preg_replace( '/[^0-9a-f]/i', '', $color );
		$new_hex = '#';

		$percent = floatval( $percent );

		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}

		// Convert to decimal and change luminosity.
		for ( $i = 0; $i < 3; $i ++ ) {
			$dec = hexdec( substr( $hex, $i * 2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 );
			$new_hex .= str_pad( dechex( $dec ), 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}
endif;

if ( ! function_exists( 'olsen_hex2rgba' ) ) :
	/**
	 * Converts hexadecimal color value to rgb(a) format.
	 *
	 * @param string $color Hexadecimal color value. May be 3 or 6 digits, with an optional leading # sign.
	 * @param float|bool $opacity Opacity level 0-1 (decimal) or false to disable.
	 *
	 * @return string
	 */
	function olsen_hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		// Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		// Remove # if provided
		$color = ltrim( $color, '#' );

		// Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) === 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) === 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb = array_map( 'hexdec', $hex );

		if ( false !== $opacity ) {
			$opacity = abs( floatval( $opacity ) );
			if ( $opacity > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		return $output;
	}
endif;

if ( ! function_exists( 'olsen_pagination' ) ) :
	/**
	 * Echoes pagination links if applicable. Output depends on pagination method selected from the customizer.
	 *
	 * @param array $args An array of arguments to change default behavior.
	 * @param object|bool $query A WP_Query object to paginate. Defaults to boolean false and uses the global $wp_query
	 *
	 * @return void
	 */
	function olsen_pagination( $args = array(), $query = false ) {
		$args = wp_parse_args( $args, apply_filters( 'olsen_pagination_default_args', array(
			'container_id'        => 'paging',
			'container_class'     => 'group',
			'prev_text'           => __( 'Previous page', 'olsen' ),
			'next_text'           => __( 'Next page', 'olsen' ),
			'paginate_links_args' => array()
		) ) );

		if ( 'object' != gettype( $query ) || 'WP_Query' != get_class( $query ) ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set things up for paginate_links()
		$unreal_pagenum = 999999999;
		$permastruct    = get_option( 'permalink_structure' );

		$paginate_links_args = wp_parse_args( $args['paginate_links_args'], array(
			'base'    => str_replace( $unreal_pagenum, '%#%', esc_url( get_pagenum_link( $unreal_pagenum ) ) ),
			'format'  => empty( $permastruct ) ? '&page=%#%' : 'page/%#%/',
			'total'   => $query->max_num_pages,
			'current' => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
		) );

		$method = get_theme_mod( 'pagination_method', 'numbers' );

		if ( $query->max_num_pages > 1 ) {
			?>
			<div
			<?php echo empty( $args['container_id'] ) ? '' : 'id="' . esc_attr( $args['container_id'] ) . '"'; ?>
			<?php echo empty( $args['container_class'] ) ? '' : 'class="' . esc_attr( $args['container_class'] ) . '"'; ?>
			><?php

			switch ( $method ) {
				case 'text':
					previous_posts_link( $args['prev_text'] );
					next_posts_link( $args['next_text'], $query->max_num_pages );
					break;
				case 'numbers':
				default:
					echo paginate_links( $paginate_links_args );
					break;
			}

			?></div><?php
		}

	}
endif;

if ( ! function_exists( 'olsen_has_more_tag' ) ) :
	function olsen_has_more_tag( $post = null ) {
		$post = get_post( $post );
		if ( preg_match( '/<!--more(.*?)?-->/', $post->post_content, $matches ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Conditionally returns a Javascript/CSS asset's version number.
 *
 * When the site is in debug mode, the normal asset's version is returned.
 * When it's not in debug mode, the theme's version is returned, so that caches can be invalidated on theme updates.
 *
 * @param bool $version The version string of the asset.
 *
 * @return false|string Theme version if SCRIPT_DEBUG or WP_DEBUG are enabled. Otherwise, $version is returned.
 */
function olsen_asset_version( $version = false ) {
	static $theme_version = false;

	if ( ! $theme_version ) {
		$theme = wp_get_theme();

		if ( is_child_theme() ) {
			$theme_version = $theme->parent()->get( 'Version' ) . '-' . $theme->get( 'Version' );
		} else {
			$theme_version = $theme->get( 'Version' );
		}
	}

	if ( $version ) {
		if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ||
			( defined( 'WP_DEBUG' ) && WP_DEBUG )
		) {
			return $version;
		}
	}

	return $theme_version;
}

if ( ! function_exists( 'olsen_get_social_networks' ) ) {
	function olsen_get_social_networks() {
		return array(
			array(
				'name'  => 'facebook',
				'label' => __( 'Facebook', 'olsen' ),
				'icon'  => 'fa-facebook',
			),
			array(
				'name'  => 'twitter',
				'label' => __( 'Twitter', 'olsen' ),
				'icon'  => 'fa-twitter',
			),
			array(
				'name'  => 'pinterest',
				'label' => __( 'Pinterest', 'olsen' ),
				'icon'  => 'fa-pinterest',
			),
			array(
				'name'  => 'instagram',
				'label' => __( 'Instagram', 'olsen' ),
				'icon'  => 'fa-instagram',
			),
			array(
				'name'  => 'linkedin',
				'label' => __( 'LinkedIn', 'olsen' ),
				'icon'  => 'fa-linkedin',
			),
			array(
				'name'  => 'tumblr',
				'label' => __( 'Tumblr', 'olsen' ),
				'icon'  => 'fa-tumblr',
			),
			array(
				'name'  => 'flickr',
				'label' => __( 'Flickr', 'olsen' ),
				'icon'  => 'fa-flickr',
			),
			array(
				'name'  => 'bloglovin',
				'label' => __( 'Bloglovin', 'olsen' ),
				'icon'  => 'fa-heart',
			),
			array(
				'name'  => 'youtube',
				'label' => __( 'YouTube', 'olsen' ),
				'icon'  => 'fa-youtube',
			),
			array(
				'name'  => 'vimeo',
				'label' => __( 'Vimeo', 'olsen' ),
				'icon'  => 'fa-vimeo',
			),
			array(
				'name'  => 'dribbble',
				'label' => __( 'Dribbble', 'olsen' ),
				'icon'  => 'fa-dribbble',
			),
			array(
				'name'  => 'wordpress',
				'label' => __( 'WordPress', 'olsen' ),
				'icon'  => 'fa-wordpress',
			),
			array(
				'name'  => '500px',
				'label' => __( '500px', 'olsen' ),
				'icon'  => 'fa-500px',
			),
			array(
				'name'  => 'soundcloud',
				'label' => __( 'Soundcloud', 'olsen' ),
				'icon'  => 'fa-soundcloud',
			),
			array(
				'name'  => 'spotify',
				'label' => __( 'Spotify', 'olsen' ),
				'icon'  => 'fa-spotify',
			),
			array(
				'name'  => 'vine',
				'label' => __( 'Vine', 'olsen' ),
				'icon'  => 'fa-vine',
			),
			array(
				'name'  => 'tripadvisor',
				'label' => __( 'Trip Advisor', 'olsen' ),
				'icon'  => 'fa-tripadvisor',
			),
			array(
				'name'  => 'telegram',
				'label' => __( 'Telegram', 'olsen' ),
				'icon'  => 'fa-telegram',
			),
		);
	}
}

add_filter( 'stylesheet_uri', 'olsen_stylesheet_uri', 10, 2 );
if ( ! function_exists( 'olsen_stylesheet_uri' ) ) {
	function olsen_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {
		if ( ! is_child_theme() ) {
			$suffix         = olsen_scripts_styles_suffix();
			$stylesheet_uri = preg_replace( '/\.css$/', "{$suffix}.css", $stylesheet_uri );
		}

		return $stylesheet_uri;
	}
}

if ( ! function_exists( 'olsen_scripts_styles_suffix' ) ) {
	function olsen_scripts_styles_suffix() {
		$suffix = '.min';

		if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ||
			( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
			$suffix = '';
		}

		return apply_filters( 'olsen_scripts_styles_suffix', $suffix );
	}
}
