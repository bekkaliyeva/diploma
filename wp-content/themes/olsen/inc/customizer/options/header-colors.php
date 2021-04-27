<?php
$wpc->add_setting(
	'header_bg_image',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wpc->add_control(
	new WP_Customize_Image_Control(
		$wpc,
		'header_bg_image',
		array(
			'section' => 'header_colors',
			'label'   => esc_html__( 'Background Image', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'header_bg_image_repeat',
	array(
		'default'           => 'no-repeat',
		'sanitize_callback' => 'olsen_sanitize_image_repeat',
	)
);
$wpc->add_control(
	'header_bg_image_repeat',
	array(
		'type'    => 'select',
		'section' => 'header_colors',
		'label'   => esc_html__( 'Image repeat', 'olsen' ),
		'choices' => olsen_get_image_repeat_choices(),
	)
);

$wpc->add_setting(
	'header_bg_image_position_x',
	array(
		'default'           => 'center',
		'sanitize_callback' => 'olsen_sanitize_image_position_x',
	)
);
$wpc->add_control(
	'header_bg_image_position_x',
	array(
		'type'    => 'select',
		'section' => 'header_colors',
		'label'   => esc_html__( 'Image horizontal position', 'olsen' ),
		'choices' => olsen_get_image_position_x_choices(),
	)
);

$wpc->add_setting(
	'header_bg_image_position_y',
	array(
		'default'           => 'center',
		'sanitize_callback' => 'olsen_sanitize_image_position_y',
	)
);
$wpc->add_control(
	'header_bg_image_position_y',
	array(
		'type'    => 'select',
		'section' => 'header_colors',
		'label'   => esc_html__( 'Image vertical position', 'olsen' ),
		'choices' => olsen_get_image_position_y_choices(),
	)
);

$wpc->add_setting(
	'header_bg_image_attachment',
	array(
		'default'           => 'scroll',
		'sanitize_callback' => 'olsen_sanitize_image_attachment',
	)
);
$wpc->add_control(
	'header_bg_image_attachment',
	array(
		'type'    => 'select',
		'section' => 'header_colors',
		'label'   => esc_html__( 'Image attachment', 'olsen' ),
		'choices' => olsen_get_image_attachment_choices(),
	)
);

$wpc->add_setting(
	'header_bg_image_cover',
	array(
		'default'           => 1,
		'sanitize_callback' => 'absint',
	)
);
$wpc->add_control(
	'header_bg_image_cover',
	array(
		'type'    => 'checkbox',
		'section' => 'header_colors',
		'label'   => esc_html__( 'Scale the image to cover its containing area.', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_bg_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'header_bg_color',
		array(
			'section' => 'header_colors',
			'label'   => esc_html__( 'Background color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'header_logo_color',
	array(
		'transport'         => 'postMessage',
		'default'           => '#161616',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'header_logo_color',
		array(
			'section' => 'header_colors',
			'label'   => __( 'Logo color', 'olsen' ),
		)
	)
);