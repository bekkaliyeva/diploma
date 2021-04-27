<?php
/**
 * Olsen onboarding related code.
 */

if ( ! defined( 'OLSEN_WHITELABEL' ) || false === (bool) OLSEN_WHITELABEL ) {
	add_filter( 'pt-ocdi/import_files', 'olsen_ocdi_import_files' );
	add_action( 'pt-ocdi/after_import', 'olsen_ocdi_after_import_setup' );
}

add_filter( 'pt-ocdi/timeout_for_downloading_import_file', 'olsen_ocdi_download_timeout' );
function olsen_ocdi_download_timeout( $timeout ) {
	return 60;
}

function olsen_ocdi_import_files( $files ) {
	if ( ! defined( 'OLSEN_NAME' ) ) {
		define( 'OLSEN_NAME', 'olsen' );
	}

	$demo_dir_url = untrailingslashit( apply_filters( 'olsen_ocdi_demo_dir_url', 'https://www.cssigniter.com/sample_content/' . OLSEN_NAME ) );

	$import_notice = __( 'You need to install and activate all required and recommended plugins for the sample content to be imported successfully.', 'olsen' );

	// When having more that one predefined imports, set a preview image, preview URL, and categories for isotope-style filtering.
	$new_files = array(
		array(
			'import_file_name'           => esc_html__( 'Default', 'olsen' ),
			'import_file_url'            => $demo_dir_url . '/content.xml',
			'import_widget_file_url'     => $demo_dir_url . '/widgets.wie',
			'import_customizer_file_url' => $demo_dir_url . '/customizer.dat',
			'import_notice'              => $import_notice,
			'preview_url'                => 'https://www.cssigniter.com/preview/olsen/',
		),
	);

	return array_merge( $files, $new_files );
}

function olsen_ocdi_after_import_setup() {

	// Set up nav menus.
	$main_menu      = get_term_by( 'name', 'Main', 'nav_menu' );
	$secondary_menu = get_term_by( 'name', 'Footer', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations',
		array(
			'main_menu'   => $main_menu->term_id,
			'footer_menu' => $secondary_menu->term_id,
		)
	);

	update_option( 'show_on_front', 'posts' );

	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {
		$wc_shop_page_id      = get_page_by_title( 'Shop' );
		$wc_cart_page_id      = get_page_by_title( 'Cart' );
		$wc_checkout_page_id  = get_page_by_title( 'Checkout' );
		$wc_myaccount_page_id = get_page_by_title( 'My Account' );

		if ( ! empty( $wc_shop_page_id ) ) {
			update_option( 'woocommerce_shop_page_id', $wc_shop_page_id->ID );
		}
		if ( ! empty( $wc_cart_page_id ) ) {
			update_option( 'woocommerce_cart_page_id', $wc_cart_page_id->ID );
		}
		if ( ! empty( $wc_checkout_page_id ) ) {
			update_option( 'woocommerce_checkout_page_id', $wc_checkout_page_id->ID );
		}
		if ( ! empty( $wc_myaccount_page_id ) ) {
			update_option( 'woocommerce_myaccount_page_id', $wc_myaccount_page_id->ID );
		}
	}

	// Try to force a term recount.
	// wp_defer_term_counting( false ) doesn't work properly as there are post imported from different AJAX requests.
	$taxonomies = get_taxonomies( array(), 'names' );
	foreach ( $taxonomies as $taxonomy ) {
		$terms             = get_terms( $taxonomy, array( 'hide_empty' => false ) );
		$term_taxonomy_ids = wp_list_pluck( $terms, 'term_taxonomy_id' );

		wp_update_term_count( $term_taxonomy_ids, $taxonomy );
	}
}

function olsen_get_theme_required_plugins() {
	return apply_filters( 'olsen_theme_required_plugins', array() );
}

function olsen_get_theme_recommended_plugins() {
	return apply_filters( 'olsen_theme_recommended_plugins', array(
		'gutenbee'              => array(
			'title'       => __( 'GutenBee', 'olsen' ),
			'description' => __( 'Premium blocks for WordPress.', 'olsen' ),
		),
		'woocommerce'           => array(
			'title'              => __( 'WooCommerce', 'olsen' ),
			'description'        => __( 'Sell anything, beautifully.', 'olsen' ),
			'required_by_sample' => true,
		),
		'maxslider'             => array(
			'title'       => __( 'MaxSlider', 'olsen' ),
			'description' => __( 'Add a custom responsive slider to any page of your website.', 'olsen' ),
		),
		'elementor'             => array(
			'title'       => __( 'Elementor', 'olsen' ),
			'description' => __( 'Elementor is a front-end drag & drop page builder for WordPress.', 'olsen' ),
		),
		'audioigniter'          => array(
			'title'       => __( 'AudioIgniter', 'olsen' ),
			'description' => __( 'Probably the most flexible music player plugin for WordPress.', 'olsen' ),
		),
		'wp-smushit'            => array(
			'title'       => __( 'Smush by WPMU DEV', 'olsen' ),
			'description' => __( 'Compress, Optimize and Lazy Load Images.', 'olsen' ),
			'plugin_file' => 'wp-smush.php',
		),
		'wpforms-lite'          => array(
			'title'       => __( 'Contact Form by WPForms', 'olsen' ),
			'description' => __( 'Drag & Drop Form Builder for WordPress.', 'olsen' ),
			'plugin_file' => 'wpforms.php',
			'is_callable' => 'wpforms',
		),
		'one-click-demo-import' => array(
			'title'              => __( 'One Click Demo Import', 'olsen' ),
			'description'        => __( 'Import your demo content, widgets and theme settings with one click.', 'olsen' ),
			'required_by_sample' => true,
		),
	) );
}

add_action( 'init', 'olsen_onboarding_page_init' );
function olsen_onboarding_page_init() {
	$data = array(
		'show_page'                => true,
		'description'              => __( 'Blogging theme for WordPress', 'olsen' ),
		'default_tab'              => 'recommended_plugins',
		'tabs'                     => array(
			'required_plugins'    => '',
			'recommended_plugins' => __( 'Recommended Plugins', 'olsen' ),
			'sample_content'      => __( 'Sample Content', 'olsen' ),
			'support'             => __( 'Support', 'olsen' ),
		),
		'required_plugins_page'    => array(
			'plugins' => olsen_get_theme_required_plugins(),
		),
		'recommended_plugins_page' => array(
			'plugins' => olsen_get_theme_recommended_plugins(),
		),

	);

	$onboarding = new Olsen_Onboarding_Page();
	$onboarding->init( apply_filters( 'olsen_onboarding_page_array', $data ) );
}

/**
 * User onboarding.
 */
require_once get_theme_file_path( '/inc/onboarding/onboarding-page.php' );
