<?php
$wpc->add_setting(
	'logo',
	array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wpc->add_control(
	new WP_Customize_Image_Control(
		$wpc,
		'logo',
		array(
			'section'     => 'title_tagline',
			'label'       => __( 'Logo', 'olsen' ),
			'description' => __( 'If an image is selected, it will replace the default textual logo (site name) on the header.', 'olsen' ),
		)
	)
);

$wpc->add_setting(
	'logo_padding_top',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'logo_padding_top',
	array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => __( 'Logo top padding', 'olsen' ),
	)
);

$wpc->add_setting(
	'logo_padding_bottom',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'logo_padding_bottom',
	array(
		'type'    => 'number',
		'section' => 'title_tagline',
		'label'   => __( 'Logo bottom padding', 'olsen' ),
	)
);

$wpc->add_setting(
	'footer_logo',
	array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wpc->add_control(
	new WP_Customize_Image_Control(
		$wpc,
		'footer_logo',
		array(
			'section'     => 'title_tagline',
			'label'       => __( 'Footer logo', 'olsen' ),
			'description' => __( 'If an image is selected, it will replace the default textual logo (site name) on the footer.', 'olsen' ),
		)
	)
);