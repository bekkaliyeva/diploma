<?php

require_once get_theme_file_path( '/inc/customizer/generated-styles/colors.php' );

function olsen_include_generated_styles_files() {
	require_once get_theme_file_path( '/inc/customizer/generated-styles/typography.php' );
}

function olsen_get_registered_typography_controls() {

	$controls = array(
		'global_typo_body'          => olsen_customizer_defaults( 'global_typo_body' ),
		'global_typo_secondary'     => olsen_customizer_defaults( 'global_typo_secondary' ),
		'global_typo_h1'            => olsen_customizer_defaults( 'global_typo_h1' ),
		'global_typo_h2'            => olsen_customizer_defaults( 'global_typo_h2' ),
		'global_typo_h3'            => olsen_customizer_defaults( 'global_typo_h3' ),
		'global_typo_h4'            => olsen_customizer_defaults( 'global_typo_h4' ),
		'global_typo_h5'            => olsen_customizer_defaults( 'global_typo_h5' ),
		'global_typo_h6'            => olsen_customizer_defaults( 'global_typo_h6' ),
		'global_typo_form_labels'   => olsen_customizer_defaults( 'global_typo_form_labels' ),
		'global_typo_form_text'     => olsen_customizer_defaults( 'global_typo_form_text' ),
		'global_typo_buttons'       => olsen_customizer_defaults( 'global_typo_buttons' ),
		'global_typo_widget_titles' => olsen_customizer_defaults( 'global_typo_widget_titles' ),
		'global_typo_widget_text'   => olsen_customizer_defaults( 'global_typo_widget_text' ),
	);

	return apply_filters( 'olsen_registered_typography_controls', $controls );
}

function olsen_enqueue_google_fonts() {
	$css = Olsen_Customizer_CSS_Generator::get_instance();

	if ( is_customize_preview() ) {
		$css->register_typography_control( 'placeholder_preview_font', olsen_typography_control_defaults_empty_breakpoints( array(
			'desktop' => array(
				'family'     => 'Open Sans',
				'variant'    => 'regular',
				'size'       => '',
				'lineHeight' => '',
				'transform'  => '',
				'spacing'    => '',
				'is_gfont'   => true,
			),
		) ) );
	}

	foreach ( olsen_get_registered_typography_controls() as $option => $default ) {
		$css->register_typography_control( $option, $default );
	}

	$url = $css->get_google_fonts_url();
	if ( ! empty( $url ) && ! has_action( 'wp_head', 'olsen_head_preconnect_google_fonts' ) ) {
		add_action( 'wp_head', 'olsen_head_preconnect_google_fonts' );
	}

	wp_enqueue_style( 'olsen-user-google-fonts', $url, array(), wp_get_theme()->get( 'Version' ) );
}

add_filter( 'olsen_customizer_css_generator_add_font_to_url', 'olsen_disable_gfonts_add_font_to_url', 10, 3 );
function olsen_disable_gfonts_add_font_to_url( $add, $option_name, $default ) {
	// Don't fiddle with the value if it isn't directly affected by this options.
	if ( get_theme_mod( 'global_typo_disable_google_fonts', olsen_customizer_defaults( 'global_typo_disable_google_fonts' ) ) ) {
		$add = false;
	}

	return $add;
}

add_filter( 'olsen_customizer_css_generator_generate_typography_stack', 'olsen_disable_gfonts_font_family', 10, 3 );
function olsen_disable_gfonts_font_family( $stack, $values, $fallback_stack ) {
	if ( ! get_theme_mod( 'global_typo_disable_google_fonts', olsen_customizer_defaults( 'global_typo_disable_google_fonts' ) ) ) {
		return $stack;
	}

	if ( array_key_exists( 'is_gfont', $values ) && true === $values['is_gfont'] ) {
		// Remove the first font from the stack. Assumes that gfont stacks are made up of one gfont and 0 or more non-gfont fonts.
		$first = array_shift( $stack );

		if ( is_null( $first ) ) {
			$stack = array();
		}
	}

	return $stack;
}

/**
 * Generates CSS based on customizer settings.
 *
 * @return string
 */
function olsen_get_customizer_css() {
	olsen_include_generated_styles_files();

	$generator = Olsen_Customizer_CSS_Generator::get_instance();

	$css = '';

	$breakpoints = array(
		'desktop' => '',
		'tablet'  => 991,
		'mobile'  => 575,
	);

	$desktop_min = $breakpoints['tablet'] + 1;
	$tablet_min  = $breakpoints['mobile'] + 1;


	$breakpoint_css = $generator->get( 'desktop' );
	if ( trim( $breakpoint_css ) ) {
		$css .= $breakpoint_css . PHP_EOL;
	}

	$breakpoint_css = $generator->get( 'tablet' );
	if ( trim( $breakpoint_css ) ) {
		$css .= "@media (max-width: {$breakpoints['tablet']}px) {
			{$breakpoint_css}
		}" . PHP_EOL;
	}

	$breakpoint_css = $generator->get( 'desktop-only' );
	if ( trim( $breakpoint_css ) ) {
		$css .= "@media (min-width: {$desktop_min}px) {
			{$breakpoint_css}
		}" . PHP_EOL;
	}

	$breakpoint_css = $generator->get( 'tablet-only' );
	if ( trim( $breakpoint_css ) ) {
		$css .= "@media (min-width: {$tablet_min}px) and (max-width: {$breakpoints['tablet']}px) {
			{$breakpoint_css}
		}" . PHP_EOL;
	}

	// 'mobile' breakpoint only applies to mobile aanyway, but we have 'mobile-only' as well, for completeness.
	// Merge the two under one media query.
	$breakpoint_css  = $generator->get( 'mobile' );
	$breakpoint_css .= $generator->get( 'mobile-only' );
	if ( trim( $breakpoint_css ) ) {
		$css .= "@media (max-width: {$breakpoints['mobile']}px) {
			{$breakpoint_css}
		}" . PHP_EOL;
	}

	return apply_filters( 'olsen_customizer_css', $css );
}

function olsen_get_all_customizer_css() {
	$styles = array(
		'customizer' => olsen_get_customizer_css(),
	);

	$styles = apply_filters( 'olsen_all_customizer_css', $styles );

	if ( is_customize_preview() ) {
		$styles[] = '/* Placeholder for preview. */';
	}

	return implode( PHP_EOL, $styles );
}


add_filter( 'olsen_customizer_css', 'olsen_minimize_css' );
function olsen_minimize_css( $css ) {
	$css = preg_replace( '/\s+/', ' ', $css );
	return $css;
}
