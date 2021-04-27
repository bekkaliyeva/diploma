<?php
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function olsen_content_width() {
	$content_width = $GLOBALS['content_width'];

	if ( is_page_template( 'template-builder.php' )
		|| is_page_template( 'template-blank.php' )
	) {
		$content_width = 1010;
	} elseif ( is_page_template( 'template-listing-looks.php' ) && '3cols_full' === get_post_meta( get_the_ID(), 'looks_layout', true ) ) {
		$content_width = 1010;
	}

	$GLOBALS['content_width'] = apply_filters( 'olsen_content_width', $content_width );
}
add_action( 'template_redirect', 'olsen_content_width', 0 );

if ( ! function_exists( 'olsen_get_layout_classes' ) ) {
	function olsen_get_layout_classes( $setting ) {
		$layout            = get_theme_mod( $setting, 'classic_2side' );
		$content_col       = '';
		$sidebar_left_col  = '';
		$sidebar_right_col = '';
		$main_class        = 'entries-classic';
		$post_class        = '';
		$post_col          = '';
		$masonry           = false;

		switch ( $layout ) {
			case 'classic_2side':
				$content_col       = 'col-md-6 order-md-1 col-12';
				$sidebar_left_col  = 'col-md-3 order-md-0 col-12';
				$sidebar_right_col = 'col-md-3 order-md-2 col-12';
				break;
			case 'classic_2side_right':
				$content_col       = 'col-md-6 col-12';
				$sidebar_left_col  = 'col-md-3 col-12';
				$sidebar_right_col = 'col-md-3 col-12';
				break;
			case 'classic_1side':
				$content_col       = 'col-md-8 col-12';
				$sidebar_right_col = 'col-md-4 col-12';
				break;
			case 'classic_full':
				$content_col = 'col-md-8 offset-md-2 col-12';
				break;
			case 'small_side':
				$content_col       = 'col-md-8 col-12';
				$sidebar_right_col = 'col-md-4 col-12';
				$main_class        = 'entries-list';
				$post_class        = 'entry-list';
				break;
			case 'small_full_narrow':
				$content_col = 'col-lg-8 offset-lg-2 col-12';
				$main_class  = 'entries-list';
				$post_class  = 'entry-list';
				break;
			case 'small_full':
				$content_col = 'col-12';
				$main_class  = 'entries-list';
				$post_class  = 'entry-list';
				break;
			case '2cols_side':
				$content_col       = 'col-md-8 col-12';
				$sidebar_right_col = 'col-md-4 col-12';
				$main_class        = 'entries-grid';
				$post_class        = 'entry-grid';
				$post_col          = 'col-sm-6 col-12';
				break;
			case '2cols_full':
				$content_col = 'col-md-12 col-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6 col-12';
				break;
			case '2cols_narrow':
				$content_col = 'col-lg-8 offset-lg-2 col-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6 col-12';
				break;
			case '2cols_masonry':
				$content_col       = 'col-md-8 col-12';
				$sidebar_right_col = 'col-md-4 col-12';
				$main_class        = 'entries-grid';
				$post_class        = 'entry-grid';
				$post_col          = 'col-sm-6 col-12';
				$masonry           = true;
				break;
			case '3cols_full':
				$content_col = 'col-md-12 col-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-lg-4 col-md-6 col-12';
				break;
			case '3cols_masonry':
				$content_col = 'col-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-lg-4 col-md-6 col-12';
				$masonry     = true;
				break;
		}

		return array(
			'layout'            => $layout,
			'content_col'       => $content_col,
			'sidebar_right_col' => $sidebar_right_col,
			'sidebar_left_col'  => $sidebar_left_col,
			'main_class'        => $main_class,
			'post_class'        => $post_class,
			'post_col'          => $post_col,
			'masonry'           => $masonry,
		);
	}
}

if ( ! function_exists( 'olsen_get_columns_classes' ) ) {
	/**
	 * Generates column classes to create a grid layout.
	 *
	 * @param int $columns The number of columns.
	 * @return string Classes to generate the columns
	 */
	function olsen_get_columns_classes( $columns ) {
		switch ( $columns ) {
			case 3:
				$classes = 'col-md-4 col-12';
				break;
			case 2:
			default:
				$classes = 'col-md-6 col-12';
				break;
		}

		return $classes;
	}
}
