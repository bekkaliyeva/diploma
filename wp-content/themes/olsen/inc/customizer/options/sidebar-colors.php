<?php
$wpc->add_setting(
	'sidebar_bg_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'sidebar_bg_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Background color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_border_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#ebebeb',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_border_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget border color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_title_bg_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_title_bg_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget title background color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_title_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#ffffff',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_title_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget title color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_text_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#333333',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_text_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget text color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_link_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_link_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget link color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'widgets_hover_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#b49543',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'widgets_hover_color',
		array(
			'section' => 'sidebar',
			'label'   => __( 'Widget hover color', 'olsen' ),
		)
	)
);
