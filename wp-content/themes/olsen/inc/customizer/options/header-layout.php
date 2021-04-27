<?php
$wpc->add_setting(
	'header_socials',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'header_socials',
	array(
		'type'    => 'checkbox',
		'section' => 'header_layout',
		'label'   => __( 'Show social icons.', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_searchform',
	array(
		'default'           => 0,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'header_searchform',
	array(
		'type'    => 'checkbox',
		'section' => 'header_layout',
		'label'   => __( 'Show search form.', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_sticky_menu',
	array(
		'default'           => 0,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'header_sticky_menu',
	array(
		'type'    => 'checkbox',
		'section' => 'header_layout',
		'label'   => __( 'Sticky menu.', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_padding',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'header_padding',
	array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 0,
			'step' => 1,
		),
		'section'     => 'header_layout',
		'label'       => esc_html__( 'Vertical padding (in pixels)', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_logo_font_size',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'header_logo_font_size',
	array(
		'type'    => 'number',
		'section' => 'header_layout',
		'label'   => __( 'Logo font size', 'olsen' ),
	)
);

$wpc->add_setting(
	'header_logo_letter_spacing',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'header_logo_letter_spacing',
	array(
		'type'    => 'number',
		'section' => 'header_layout',
		'label'   => __( 'Logo letter spacing', 'olsen' ),
	)
);
