<?php
add_action( 'admin_enqueue_scripts', 'olsen_admin_register_post_meta_scripts' );
function olsen_admin_register_post_meta_scripts( $hook ) {
	$theme = wp_get_theme();

	wp_register_style( 'olsen-post-meta', get_template_directory_uri() . '/inc/css/post-meta.css', array(), $theme->get( 'Version' ) );
	wp_register_script( 'olsen-post-meta', get_template_directory_uri() . '/inc/js/post-meta.js', array(
		'media-editor',
		'jquery',
		'jquery-ui-sortable'
	), $theme->get( 'Version' ) );

	$settings = array(
		'ajaxurl'             => admin_url( 'admin-ajax.php' ),
		'tSelectFile'         => __( 'Select file', 'olsen' ),
		'tSelectFiles'        => __( 'Select files', 'olsen' ),
		'tUseThisFile'        => __( 'Use this file', 'olsen' ),
		'tUseTheseFiles'      => __( 'Use these files', 'olsen' ),
		'tUpdateGallery'      => __( 'Update gallery', 'olsen' ),
		'tLoading'            => __( 'Loading...', 'olsen' ),
		'tPreviewUnavailable' => __( 'Gallery preview not available.', 'olsen' ),
		'tRemoveImage'        => __( 'Remove image', 'olsen' ),
		'tRemoveFromGallery'  => __( 'Remove from gallery', 'olsen' ),
	);
	wp_localize_script( 'olsen-post-meta', 'olsen_PostMeta', $settings );
}

add_action( 'wp_enqueue_scripts', 'olsen_enqueue_scripts' );
function olsen_enqueue_scripts() {
	$suffix = olsen_scripts_styles_suffix();
	/*
	 * Styles
	 */
	$theme = wp_get_theme();

	wp_register_style( 'font-awesome', get_template_directory_uri() . "/vendor/FontAwesome/font-awesome{$suffix}.css", array(), '4.7.0' );
	wp_register_style( 'simple-lightbox', get_template_directory_uri() . "/vendor/simple-lightbox/simple-lightbox{$suffix}.css", array(), '2.7.0' );
	wp_register_style( 'olsen-simple-lightbox-theme', get_template_directory_uri() . "/css/simple-lightbox-theme{$suffix}.css", array(), $theme->get( 'Version' ) );
	wp_register_style( 'tiny-slider', get_template_directory_uri() . "/vendor/tiny-slider/tiny-slider{$suffix}.css", array(), '2.9.3' );

	wp_register_style( 'olsen-dependencies', false, array(
		'font-awesome',
		'tiny-slider',
		'simple-lightbox',
		'olsen-simple-lightbox-theme',
	), $theme->get( 'Version' ) );

	$main_dependencies = array(
		'olsen-dependencies',
	);

	if ( is_child_theme() ) {
		wp_enqueue_style( 'olsen-style-parent', get_template_directory_uri() . '/style.css', $main_dependencies, $theme->get( 'Version' ) );
	}

	olsen_enqueue_google_fonts();

	wp_enqueue_style( 'ci-style', get_stylesheet_uri(), $main_dependencies, $theme->get( 'Version' ) );
	wp_add_inline_style( 'ci-style', olsen_get_all_customizer_css() );

	/*
	 * Scripts
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_register_script( 'isotope', get_template_directory_uri() . "/vendor/isotope/isotope{$suffix}.js", array( 'jquery' ), '2.2.2', true );
	wp_register_script( 'simple-lightbox', get_template_directory_uri() . "/vendor/simple-lightbox/simple-lightbox{$suffix}.js", array(), '2.7.0', true );
	wp_register_script( 'tiny-slider', get_template_directory_uri() . "/vendor/tiny-slider/tiny-slider{$suffix}.js", array(), '2.9.3', true );
	wp_register_script( 'imagesLoaded', get_template_directory_uri() . "/vendor/imagesLoaded/imagesloaded.pkgd{$suffix}.js", array(), '4.1.4', true );

	/*
	 * Enqueue
	 */
	wp_enqueue_script(
		'ci-front-scripts',
		get_template_directory_uri() . "/js/scripts{$suffix}.js",
		array(
			'tiny-slider',
			'simple-lightbox',
			'isotope',
			'imagesLoaded',
		),
		$theme->get( 'Version' ),
		true
	);

}

add_action( 'admin_enqueue_scripts', 'olsen_admin_enqueue_scripts' );
function olsen_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */

	/*
	 * Scripts
	 */

	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'olsen-post-meta' );
		wp_enqueue_script( 'olsen-post-meta' );
	}

	if ( in_array( $hook, array( 'profile.php', 'user-edit.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'olsen-post-meta' );
		wp_enqueue_script( 'olsen-post-meta' );
	}

	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'olsen-post-meta' );
		wp_enqueue_script( 'olsen-post-meta' );
	}

}
