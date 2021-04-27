<?php
$wpc->add_setting(
	'page_signature',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'page_signature',
	array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => __( 'Show signature.', 'olsen' ),
	)
);

$wpc->add_setting(
	'page_social_sharing',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'page_social_sharing',
	array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => __( 'Show social sharing buttons.', 'olsen' ),
	)
);
