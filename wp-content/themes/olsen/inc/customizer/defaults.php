<?php
function olsen_customizer_defaults( $setting = false ) {
	$theme = wp_get_theme();

	// Font family values should match fonts.json 'family' field.
	$primary_font   = 'Lato';
	$secondary_font = 'Lora';

	// phpcs:disable WordPress.Arrays.MultipleStatementAlignment.DoubleArrowNotAligned
	$defaults = apply_filters(
		'olsen_customizer_defaults',
		array(
			'global_typo_disable_google_fonts' => 0,

			'global_typo_body' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => 'regular',
						'size'       => 13,
						'lineHeight' => 1.626,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_secondary' => olsen_typography_control_defaults_empty_breakpoints( array(
				'desktop' => array(
					'family'     => $secondary_font,
					'is_gfont'   => true,
				),
			) ),
			'global_typo_h1' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 26,
						'lineHeight' => 1.2,
						'transform'  => 'uppercase',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_h2' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 24,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_h3' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 22,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_h4' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 20,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_h5' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 18,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_h6' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $secondary_font,
						'variant'    => 'regular',
						'size'       => 16,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_form_labels' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => 'regular',
						'size'       => 13,
						'lineHeight' => 1.626,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_form_text' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => 'regular',
						'size'       => 13,
						'lineHeight' => 1.2,
						'transform'  => '',
						'spacing'    => 2,
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_buttons' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => 'regular',
						'size'       => 11,
						'lineHeight' => 1.2,
						'transform'  => 'uppercase',
						'spacing'    => 2,
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_widget_titles' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => '700',
						'size'       => 11,
						'lineHeight' => 1.2,
						'transform'  => 'uppercase',
						'spacing'    => 1,
						'is_gfont'   => true,
					),
				)
			),
			'global_typo_widget_text' => olsen_typography_control_defaults_empty_breakpoints(
				array(
					'desktop' => array(
						'family'     => $primary_font,
						'variant'    => 'regular',
						'size'       => 13,
						'lineHeight' => 1.626,
						'transform'  => '',
						'spacing'    => '',
						'is_gfont'   => true,
					),
				)
			),
		)
	);
	// phpcs:enable

	if ( ! empty( $setting ) && array_key_exists( $setting, $defaults ) ) {
		return apply_filters( 'olsen_customizer_default', $defaults[ $setting ], $setting );
	}

	return $defaults;
}