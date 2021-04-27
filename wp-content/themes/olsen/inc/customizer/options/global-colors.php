<?php
$wpc->get_control( 'background_image' )->section      = 'colors';
$wpc->get_control( 'background_repeat' )->section     = 'colors';
$wpc->get_control( 'background_attachment' )->section = 'colors';
if ( ! is_null( $wpc->get_control( 'background_position_x' ) ) ) {
	$wpc->get_control( 'background_position_x' )->section = 'colors';
} else {
	$wpc->get_control( 'background_position' )->section = 'colors';
	$wpc->get_control( 'background_preset' )->section   = 'colors';
	$wpc->get_control( 'background_size' )->section     = 'colors';
}

$wpc->add_setting(
	'site_accent_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#b49543',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_accent_color',
		array(
			'section' => 'colors',
			'label'   => __( 'Accent Color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_accent_color_hover',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_accent_color_hover',
		array(
			'section' => 'colors',
			'label'   => __( 'Accent Color Hover', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_text_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#333333',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_text_color',
		array(
			'section' => 'colors',
			'label'   => __( 'Text color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_headings_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#333333',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_headings_color',
		array(
			'section' => 'colors',
			'label'   => __( 'Headings color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_link_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_link_color',
		array(
			'section' => 'colors',
			'label'   => __( 'Link color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_link_color_hover',
	array(
		'transport'         => 'postMessage',
		'default'           => '#b49543',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_link_color_hover',
		array(
			'section' => 'colors',
			'label'   => __( 'Link hover color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'site_border_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#ececec',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'site_border_color',
		array(
			'section' => 'colors',
			'label'   => __( 'Border Color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'button_text',
	array(
		'transport'         => 'postMessage',
		'default'           => '#FFFFFF',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'button_text',
		array(
			'section' => 'colors',
			'label'   => __( 'Button Color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'button_bg',
	array(
		'transport'         => 'postMessage',
		'default'           => '#b49543',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'button_bg',
		array(
			'section' => 'colors',
			'label'   => __( 'Button Background', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'button_text_hover',
	array(
		'transport'         => 'postMessage',
		'default'           => '#FFFFFF',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'button_text_hover',
		array(
			'section' => 'colors',
			'label'   => __( 'Button Color Hover', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'button_bg_hover',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'button_bg_hover',
		array(
			'section' => 'colors',
			'label'   => __( 'Button Background Hover', 'olsen' ),
		)
	)
);