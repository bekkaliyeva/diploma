<?php
$wpc->add_setting(
	'site_socials',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'site_socials',
	array(
		'type'        => 'checkbox',
		'section'     => 'social',
		'label'       => esc_html__( 'Site-wide social icons.', 'olsen' ),
		'description' => esc_html__( 'Shows floating icons on the side of your website. Not visible on mobile devices.', 'olsen' ),
	)
);

$wpc->add_setting(
	'social_target',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'social_target',
	array(
		'type'    => 'checkbox',
		'section' => 'social',
		'label'   => __( 'Open social and sharing links in a new tab.', 'olsen' ),
	)
);

$networks = olsen_get_social_networks();

foreach ( $networks as $network ) {
	$wpc->add_setting(
		'social_' . $network['name'],
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wpc->add_control(
		'social_' . $network['name'],
		array(
			'type'    => 'url',
			'section' => 'social',
			'label'   => sprintf( _x( '%s URL', 'social network url', 'olsen' ), $network['label'] ),
		)
	);
}

$wpc->add_setting(
	'rss_feed',
	array(
		'default'           => get_bloginfo( 'rss2_url' ),
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wpc->add_control(
	'rss_feed',
	array(
		'type'    => 'url',
		'section' => 'social',
		'label'   => __( 'RSS Feed', 'olsen' ),
	)
);