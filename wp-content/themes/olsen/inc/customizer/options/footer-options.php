<?php
$wpc->add_setting(
	'footer_tagline',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'footer_tagline',
	array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => __( 'Show tagline.', 'olsen' ),
	)
);

$wpc->add_setting(
	'footer_socials',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'footer_socials',
	array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => __( 'Show social icons.', 'olsen' ),
	)
);

$wpc->add_setting(
	'footer_logo_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_hex_color',
	)
);
$wpc->add_control(
	new WP_Customize_Color_Control(
		$wpc,
		'footer_logo_color',
		array(
			'section' => 'footer',
			'label'   => __( 'Footer logo color', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'footer_logo_font_size',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'footer_logo_font_size',
	array(
		'type'    => 'number',
		'section' => 'footer',
		'label'   => __( 'Footer logo font size', 'olsen' ),
	)
);

$wpc->add_setting(
	'footer_logo_letter_spacing',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'footer_logo_letter_spacing',
	array(
		'type'    => 'number',
		'section' => 'footer',
		'label'   => __( 'Footer logo letter spacing', 'olsen' ),
	)
);

$wpc->add_setting(
	'footer_copy',
	array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wpc->add_control(
	'footer_copy',
	array(
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __( 'Footer copyright notice', 'olsen' ),
	)
);

if ( class_exists( 'Wpzoom_Instagram_Widget' ) ) {
	$wpc->add_setting(
		'instagram_auto',
		array(
			'default'           => 1,
			'sanitize_callback' => 'olsen_sanitize_checkbox',
		)
	);
	$wpc->add_control(
		'instagram_auto',
		array(
			'type'    => 'checkbox',
			'section' => 'footer',
			'label'   => __( 'Enable Instagram Slideshow.', 'olsen' ),
		)
	);

	$wpc->add_setting(
		'instagram_speed',
		array(
			'default'           => 300,
			'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
		)
	);
	$wpc->add_control(
		'instagram_speed',
		array(
			'type'    => 'number',
			'section' => 'footer',
			'label'   => __( 'Instagram Slideshow Speed.', 'olsen' ),
		)
	);
}