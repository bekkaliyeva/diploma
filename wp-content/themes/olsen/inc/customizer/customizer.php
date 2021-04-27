<?php
add_action( 'customize_register', 'olsen_customize_register', 100 );
/**
 * Registers all theme-related options to the Customizer.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function olsen_customize_register( $wpc ) {

		// Partial for various settings that affect the customizer styles, but can't have a dedicated icon, e.g. typography controls.
		$wpc->selective_refresh->add_partial(
			'theme_style',
			array(
				'selector'            => '#ci-style-inline-css',
				'render_callback'     => 'olsen_get_all_customizer_css',
				'settings'            => array_keys( olsen_get_registered_typography_controls() ),
				'container_inclusive' => false,
			)
		);

		$wpc->selective_refresh->add_partial(
			'theme_gfonts',
			array(
				'selector'            => '#olsen-user-google-fonts-css',
				'render_callback'     => 'olsen_customize_preview_google_fonts',
				'settings'            => array_keys( olsen_get_registered_typography_controls() ),
				'container_inclusive' => true,
			)
		);

	$wpc->add_section(
		'top-bar',
		array(
			'title'       => _x( 'Top Bar Options', 'customizer section title', 'olsen' ),
			'description' => __( 'To show/hide the top bar set/unset the menu in the top bar menu location.', 'olsen' ),
			'priority'    => 5,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/top-bar-options.php' );

	$wpc->add_panel(
		'header',
		array(
			'title'    => _x( 'Header Options', 'customizer section title', 'olsen' ),
			'priority' => 10,
		)
	);

	$wpc->add_section(
		'header_layout',
		array(
			'title'    => esc_html_x( 'Header Layout', 'customizer section title', 'olsen' ),
			'panel'    => 'header',
			'priority' => 10,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/header-layout.php' );

	$wpc->add_section(
		'header_colors',
		array(
			'title'    => esc_html_x( 'Header Colors', 'customizer section title', 'olsen' ),
			'panel'    => 'header',
			'priority' => 20,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/header-colors.php' );

	$wpc->get_panel( 'nav_menus' )->priority = 15;

	require_once get_theme_file_path( 'inc/customizer/options/site-identity.php' );

	$wpc->add_section(
		'layout',
		array(
			'title'    => _x( 'Layout Options', 'customizer section title', 'olsen' ),
			'priority' => 25,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/layout-options.php' );

	$wpc->add_section(
		'homepage',
		array(
			'title'    => _x( 'Front Page Carousel', 'customizer section title', 'olsen' ),
			'priority' => 25,
		)
	);

	$wpc->add_section(
		'typography',
		array(
			'title'    => _x( 'Typography Options', 'customizer section title', 'olsen' ),
			'priority' => 30,
		)
	);
	require_once get_theme_file_path( '/inc/customizer/options/typography.php' );

	$wpc->get_section( 'colors' )->title    = __( 'Global Colors', 'olsen' );
	$wpc->get_section( 'colors' )->priority = 40;

	require_once get_theme_file_path( 'inc/customizer/options/global-colors.php' );

	$wpc->add_section(
		'sidebar',
		array(
			'title'       => _x( 'Sidebar Colors', 'customizer section title', 'olsen' ),
			'description' => __( 'These options affect your sidebar (when visible).', 'olsen' ),
			'priority'    => 50,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/sidebar-colors.php' );

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'widgets' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	// $wpc->get_panel( 'widgets' )->priority = 55;
	$panel_widgets           = (object) $wpc->get_panel( 'widgets' );
	$panel_widgets->priority = 55;

	$wpc->add_section(
		'social',
		array(
			'title'       => _x( 'Social Networks', 'customizer section title', 'olsen' ),
			'description' => __( 'Enter your social network URLs. Leaving a URL empty will hide its respective icon.', 'olsen' ),
			'priority'    => 60,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/social-options.php' );

	$wpc->add_section(
		'single_post',
		array(
			'title'       => _x( 'Posts Options', 'customizer section title', 'olsen' ),
			'description' => __( 'These options affect your individual posts.', 'olsen' ),
			'priority'    => 70,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/single-post.php' );

	$wpc->add_section(
		'single_page',
		array(
			'title'       => _x( 'Pages Options', 'customizer section title', 'olsen' ),
			'description' => __( 'These options affect your individual pages.', 'olsen' ),
			'priority'    => 80,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/single-page.php' );

	$wpc->add_section(
		'footer',
		array(
			'title'    => _x( 'Footer Options', 'customizer section title', 'olsen' ),
			'priority' => 100,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/footer-options.php' );

	// Section 'static_front_page' is not defined when there are no pages.
	if ( get_pages() ) {
		$wpc->get_section( 'static_front_page' )->priority = 110;
	}

	$wpc->add_section(
		'other',
		array(
			'title'       => _x( 'Other', 'customizer section title', 'olsen' ),
			'description' => __( 'Other options affecting the whole site.', 'olsen' ),
			'priority'    => 120,
		)
	);

	require_once get_theme_file_path( 'inc/customizer/options/other.php' );


	//
	// Homepage
	//
	$wpc->add_control(
		new Olsen_Customize_Slick_Control(
			$wpc,
			'home_slider',
			array(
				'section'     => 'homepage',
				'label'       => __( 'Home Slider', 'olsen' ),
				'description' => __( 'Fine-tune the homepage slider.', 'olsen' ),
			),
			array(
				'taxonomy' => 'category',
			)
		)
	);


	//
	// WooCommerce
	//
	require_once get_theme_file_path( 'inc/customizer/options/woocommerce.php' );
}


add_action( 'customize_register', 'olsen_customize_register_custom_controls', 9 );
/**
 * Registers custom Customizer controls.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function olsen_customize_register_custom_controls( $wpc ) {
	require get_template_directory() . '/inc/customizer/controls/slick.php';

	require_once get_theme_file_path( '/inc/customizer/controls/typography/typography.php' );
	$wpc->register_control_type( 'Olsen_Customize_Typography_Control' );
}

add_action( 'customize_preview_init', 'olsen_customize_preview_js' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function olsen_customize_preview_js() {
	// Generic preview code.
	wp_enqueue_script( 'olsen-customizer-preview', get_theme_file_uri( '/inc/customizer/preview/preview.js' ), array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_style( 'olsen-customizer-preview', get_theme_file_uri( '/inc/customizer/preview/preview.css' ), array(), wp_get_theme()->get( 'Version' ) );

	// Options-specific preview code.
	wp_enqueue_script( 'olsen-customizer-preview-typography', get_theme_file_uri( '/inc/customizer/preview/customizer-typography-preview.js' ), array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'olsen-customizer-preview-colors', get_theme_file_uri( '/inc/customizer/preview/customizer-colors-preview.js' ), array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
}


add_action( 'customize_controls_enqueue_scripts', 'olsen_customize_controls_js' );
/**
 * Registers/Enqueues styles and scripts for customizer controls.
 */
function olsen_customize_controls_js() {
	wp_enqueue_style( 'olsen-customizer-controls', get_theme_file_uri( '/inc/customizer/controls/style.css' ), array(), wp_get_theme()->get( 'Version' ) );
}


/**
 * Helpers
 */
function olsen_typography_control_defaults_empty_breakpoints( $override_breakpoints = array() ) {
	$defaults = array(
		'desktop' => array(
			'family'     => '',
			'variant'    => '',
			'size'       => '',
			'lineHeight' => '',
			'transform'  => '',
			'spacing'    => '',
			'is_gfont'   => false,
		),
		'tablet'  => array(
			'family'     => '',
			'variant'    => '',
			'size'       => '',
			'lineHeight' => '',
			'transform'  => '',
			'spacing'    => '',
			'is_gfont'   => false,
		),
		'mobile'  => array(
			'family'     => '',
			'variant'    => '',
			'size'       => '',
			'lineHeight' => '',
			'transform'  => '',
			'spacing'    => '',
			'is_gfont'   => false,
		),
	);

	$return = array();
	foreach ( $defaults as $breakpoint => $values ) {
		if ( isset( $override_breakpoints[ $breakpoint ] ) && is_array( $override_breakpoints[ $breakpoint ] ) ) {
			$return[ $breakpoint ] = array_merge( $values, $override_breakpoints[ $breakpoint ] );
		} else {
			$return[ $breakpoint ] = $values;
		}
	}

	return $return;
}

function olsen_sanitize_typography_control_breakpoints( $values ) {
	$defaults = olsen_typography_control_defaults_empty_breakpoints();

	if ( ! empty( $values ) && is_string( $values ) ) {
		$values = json_decode( $values, true );
	}

	if ( ! is_array( $values ) ) {
		return $defaults;
	}

	$values = wp_parse_args( $values, $defaults );

	foreach ( $values as $breakpoint => $value ) {
		if ( ! array_key_exists( $breakpoint, $defaults ) ) {
			unset( $values[ $breakpoint ] );
		}
	}

	$new_values = array();

	foreach ( $values as $breakpoint => $breakpoint_values ) {
		if ( array_key_exists( $breakpoint, $defaults ) ) {
			$new_breakpoint_values = wp_parse_args( $breakpoint_values, $defaults[ $breakpoint ] );

			$new_breakpoint_values['family']     = sanitize_text_field( $new_breakpoint_values['family'] );
			$new_breakpoint_values['variant']    = sanitize_text_field( $new_breakpoint_values['variant'] );
			$new_breakpoint_values['size']       = olsen_sanitize_intval_or_empty( $new_breakpoint_values['size'] );
			$new_breakpoint_values['lineHeight'] = olsen_sanitize_floatval_or_empty( $new_breakpoint_values['lineHeight'] );
			$new_breakpoint_values['transform']  = sanitize_text_field( $new_breakpoint_values['transform'] );
			$new_breakpoint_values['spacing']    = olsen_sanitize_floatval_or_empty( $new_breakpoint_values['spacing'] );
			$new_breakpoint_values['is_gfont']   = (bool) intval( $new_breakpoint_values['is_gfont'] );

			$new_values[ $breakpoint ] = $new_breakpoint_values;
		}
	}

	return $new_values;
}

/**
 * Customizer defaults.
 */
require_once get_theme_file_path( '/inc/customizer/defaults.php' );

/**
 * Customizer partial callbacks.
 */
require_once get_theme_file_path( '/inc/customizer/partial-callbacks.php' );

/**
 * Fonts list.
 */
require_once get_theme_file_path( '/inc/customizer/class-fonts-list.php' );

/**
 * CSS Generator.
 */
require_once get_theme_file_path( '/inc/customizer/class-olsen-customizer-css-generator.php' );

/**
 * Customizer generated styles.
 */
require_once get_theme_file_path( '/inc/customizer/style-generator.php' );
