<?php
$wpc->add_setting(
	'topbar_socials',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'topbar_socials',
	array(
		'type'    => 'checkbox',
		'section' => 'top-bar',
		'label'   => __( 'Show social icons.', 'olsen' ),
	)
);

$wpc->add_setting(
	'topbar_searchform',
	array(
		'default'           => 0,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'topbar_searchform',
	array(
		'type'    => 'checkbox',
		'section' => 'top-bar',
		'label'   => __( 'Show search form.', 'olsen' ),
	)
);