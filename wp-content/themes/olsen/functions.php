<?php
add_action( 'after_setup_theme', 'olsen_setup' );
if ( ! function_exists( 'olsen_setup' ) ) :
	function olsen_setup() {

		$GLOBALS['content_width'] = apply_filters( 'olsen_content_width', 665 );

		if ( ! defined( 'OLSEN_NAME' ) ) {
			define( 'OLSEN_NAME', 'olsen' );
		}
		if ( ! defined( 'OLSEN_WHITELABEL' ) ) {
			// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
			define( 'OLSEN_WHITELABEL', false );
		}

		load_theme_textdomain( 'olsen', get_template_directory() . '/languages' );

		/*
		 * Theme supports.
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'post-formats',
			array(
				'image',
				'gallery',
				'audio',
				'video',
			)
		);
		add_theme_support(
			'custom-background',
			array(
				'wp-head-callback' => 'olsen_custom_background_cb',
			)
		);

		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width'         => 750,
				'single_image_width'            => 750,
				'gallery_thumbnail_image_width' => 200,

				'product_grid'                  => array(
					'default_rows'    => 3,
					'min_rows'        => 2,
					'max_rows'        => 8,
					'default_columns' => 4,
					'min_columns'     => 2,
					'max_columns'     => 4,
				),
			)
		);

		/*
		 * Image sizes.
		 */
		set_post_thumbnail_size( 720, 471, true );
		add_image_size( 'ci_masonry', 665 );
		add_image_size( 'ci_slider', 1110, 600, true );
		add_image_size( 'ci_slider_fullwidth', 1920, 600, true );
		add_image_size( 'ci_wide', 0, 260, false );
		add_image_size( 'ci_tall', 750, 1000, true );
		add_image_size( 'ci_square', 200, 200, true );

		/*
		 * Navigation menus.
		 */
		register_nav_menus(
			array(
				'main_menu'   => esc_html__( 'Main Menu', 'olsen' ),
				'top_menu'    => esc_html__( 'Top Menu', 'olsen' ),
				'footer_menu' => esc_html__( 'Footer Menu', 'olsen' ),
				'mobile_menu' => esc_html__( 'Mobile Menu', 'olsen' ),
			)
		);

		/*
		 * Default hooks
		 */
		// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
		add_action( 'admin_footer', 'olsen_print_inline_js' );
		add_action( 'wp_footer', 'olsen_print_inline_js' );

		// Handle the dismissible sample content notice.
		add_action( 'wp_ajax_olsen_dismiss_sample_content', 'olsen_ajax_dismiss_sample_content' );

		// Wraps post counts in span.ci-count
		// Needed for the default widgets, however more appropriate filters don't exist.
		add_filter( 'get_archives_link', 'olsen_wrap_archive_widget_post_counts_in_span', 10, 2 );
		add_filter( 'wp_list_categories', 'olsen_wrap_category_widget_post_counts_in_span', 10, 2 );
	}
endif;

/**
 * Theme scripts and styles.
 */
require_once get_theme_file_path( '/inc/scripts-styles.php' );

/**
 * Sidebars and widgets.
 */
require_once get_theme_file_path( '/inc/sidebars-widgets.php' );

/**
 * Default theme hooks.
 */
require_once get_theme_file_path( '/inc/default-hooks.php' );

/**
 * Customizer related functionality.
 */
require_once get_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * WooCommerce integration.
 */
require_once get_theme_file_path( '/inc/woocommerce.php' );

/**
 * Theme Elements
 */
require_once get_theme_file_path( 'inc/elementor/elementor.php' );

/**
 * Theme helper functions.
 */
require_once get_theme_file_path( '/inc/helpers.php' );

/**
 * Theme layout functions.
 */
require_once get_theme_file_path( '/inc/layout.php' );

/**
 * Sanitization functions.
 */
require_once get_theme_file_path( '/inc/sanitization.php' );

/**
 * Post custom field functions.
 */
require_once get_theme_file_path( '/inc/custom-fields-post.php' );

/**
 * Page custom field functions.
 */
require_once get_theme_file_path( '/inc/custom-fields-page.php' );

/**
 * Custom user meta fields.
 */
require_once get_theme_file_path( '/inc/user-meta.php' );

/**
 * Metabox related functions.
 */
require_once get_theme_file_path( '/inc/helpers-post-meta.php' );

/**
 * Brand post taxonomy.
 */
require_once get_theme_file_path( '/inc/custom-taxonomy-brand.php' );

/**
 * Data upgrade.
 */
require_once get_theme_file_path( '/inc/upgrade.php' );

/**
 * User onboarding.
 */
require_once get_theme_file_path( '/inc/onboarding/onboarding.php' );
