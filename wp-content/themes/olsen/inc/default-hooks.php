<?php
add_filter( 'excerpt_length', 'olsen_excerpt_length' );
function olsen_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}

add_filter( 'previous_posts_link_attributes', 'olsen_previous_posts_link_attributes' );
function olsen_previous_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-older"';
	return $attrs;
}
add_filter( 'next_posts_link_attributes', 'olsen_next_posts_link_attributes' );
function olsen_next_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-newer"';
	return $attrs;
}

add_filter( 'wp_page_menu', 'olsen_wp_page_menu', 10, 2 );
function olsen_wp_page_menu( $menu, $args ) {
	preg_match( '#^<div class="(.*?)">(?:.*?)</div>$#', $menu, $matches );
	$menu = preg_replace( '#^<div class=".*?">#', '', $menu, 1 );
	$menu = preg_replace( '#</div>$#', '', $menu, 1 );
	$menu = preg_replace( '#^<ul>#', '<ul class="' . esc_attr( $args['menu_class'] ) . '">', $menu, 1 );
	return $menu;
}

add_filter( 'the_content', 'olsen_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'olsen_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'olsen_lightbox_rel' );
if ( ! function_exists( 'olsen_lightbox_rel' ) ) :
	function olsen_lightbox_rel( $content ) {
		global $post;

		$data = 'data-lightbox="gal[' . $post->ID . ']"';

		$pattern = '#<a(.*?)>(.*?)</a>#i';
		if ( preg_match_all( $pattern, $content, $matches ) ) {
			foreach ( $matches[0] as $link_html ) {
				if ( strpos( $link_html, $data ) !== false ) {
					continue;
				}

				$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
				$replacement = '<a$1href=$2$3.$4$5 ' . $data . '$6>$7</a>';
				$fixed_html  = preg_replace( $pattern, $replacement, $link_html );
				$content     = str_replace( $link_html, $fixed_html, $content );
			}
		}

		return $content;
	}
endif;

add_action( 'wp_head', 'olsen_print_google_analytics_tracking' );
if ( ! function_exists( 'olsen_print_google_analytics_tracking' ) ) :
	function olsen_print_google_analytics_tracking() {
		if ( is_admin() || ! get_theme_mod( 'google_anaytics_tracking_id' ) ) {
			return;
		}
		?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo get_theme_mod( 'google_anaytics_tracking_id' ); ?>', 'auto');
			ga('send', 'pageview');
		</script>
		<?php
	}
endif;

add_filter( 'wp_link_pages_args', 'olsen_wp_link_pages_args' );
function olsen_wp_link_pages_args( $params ) {
	$params = array_merge(
		$params,
		array(
			'before' => '<p class="link-pages">' . __( 'Pages:', 'olsen' ),
			'after'  => '</p>',
		)
	);

	return $params;
}

//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_layout_blog', 'olsen_handle_url_theme_mod_layout_blog' );
function olsen_handle_url_theme_mod_layout_blog( $value ) {

	if ( ! empty( $_GET['layout_blog'] ) ) {
		$value = olsen_sanitize_blog_terms_layout( $_GET['layout_blog'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_terms', 'olsen_handle_url_theme_mod_layout_terms' );
function olsen_handle_url_theme_mod_layout_terms( $value ) {

	if ( ! empty( $_GET['layout_terms'] ) ) {
		$value = olsen_sanitize_blog_terms_layout( $_GET['layout_terms'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_other', 'olsen_handle_url_theme_mod_layout_other' );
function olsen_handle_url_theme_mod_layout_other( $value ) {

	if ( ! empty( $_GET['layout_other'] ) ) {
		$value = olsen_sanitize_other_layout( $_GET['layout_other'] );
	}
	return $value;
}

add_action( 'pre_get_posts', 'olsen_handle_url_posts_per_page' );
function olsen_handle_url_posts_per_page( $q ) {
	if ( $q->is_main_query() && ! ( is_admin() || $q->is_singular() || isset( $q->query_vars['posts_per_page'] ) ) ) {
		if ( ! empty( $_GET['ppp'] ) && intval( $_GET['ppp'] ) > 0 && intval( $_GET['ppp'] ) <= 100 ) {
			$q->set( 'posts_per_page', intval( $_GET['ppp'] ) );
		}
	}
}

add_filter( 'dynamic_sidebar_params', 'olsen_inset_sidebar_params' );
function olsen_inset_sidebar_params( $params ) {
	$sidebar_id = $params[0]['id'];

	if ( 'frontpage-widgets' === $sidebar_id ) {

		$total_widgets      = wp_get_sidebars_widgets();
		$sidebar_widgets_no = count( $total_widgets[ $sidebar_id ] );
		$class              = '';

		if ( 1 === $sidebar_widgets_no ) {
			$class = 'col-12';
		} elseif ( 0 === $sidebar_widgets_no % 2 && $sidebar_widgets_no < 3 ) {
			$class = 'col-md-6 col-12';
		} else {
			$class = 'col-md-4 col-12';
		}

		$params[0]['before_widget'] = str_replace( 'class="', 'class="' . $class . ' ', $params[0]['before_widget'] );
	}

	return $params;
}

/* Add .opening custom class in TinyMCE */

add_filter( 'tiny_mce_before_init', 'olsen_insert_wp_editor_formats' );
if ( ! function_exists( 'olsen_insert_wp_editor_formats' ) ) :
	function olsen_insert_wp_editor_formats( $init_array ) {
		// Define the style_formats array
		$style_formats = array(
			// Each array child is a format with it's own settings
			array(
				'title'   => esc_html__( 'Opening Paragraph', 'olsen' ),
				'block'   => 'div',
				'classes' => 'opening',
				'wrapper' => true,
			),
		);
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = wp_json_encode( $style_formats );

		return $init_array;
	}
endif;

add_filter( 'mce_buttons_2', 'olsen_mce_buttons_2' );
if ( ! function_exists( 'olsen_mce_buttons_2' ) ) :
	function olsen_mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}
endif;

/**
 * Add wrapper to embedded items to apply responsive styling.
 */
add_filter( 'embed_oembed_html', 'olsen_oembed_responsive_wrapper', 10, 4 );
function olsen_oembed_responsive_wrapper( $cache, $url, $attr, $post_ID ) {
	if ( empty( $cache ) ) {
		return $cache;
	}

	$url_patterns = array(
		'youtube.com',
		'youtu.be',
		'youtube-nocookie.com', // This doesn't seem to embed anything.
		'vimeo.com',
		'dailymotion.com',
		'dai.ly', // This doesn't seem to embed anything.
		'hulu.com',
		'wordpress.tv',
		'slideshare.net',
	);

	$match = false;

	foreach ( $url_patterns as $url_pattern ) {
		$pattern = 'https?://.*?' . preg_quote( $url_pattern, '#' );
		if ( preg_match( '#' . $pattern . '#', $url ) ) {
			$match = true;
			break;
		}
	}

	if ( $match ) {
		$cache = '<div class="olsen-responsive-embed">' . $cache . '</div>';
	}

	return $cache;
}