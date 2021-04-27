<?php
$wpc->add_setting(
	'google_anaytics_tracking_id',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wpc->add_control(
	'google_anaytics_tracking_id',
	array(
		'type'        => 'text',
		'section'     => 'other',
		'label'       => esc_html__( 'Google Analytics Tracking ID', 'olsen' ),
		'description' => sprintf( __( 'Tracking is enabled only for the non-admin portion of your website. If you need fine-grained control of the tracking code, you are strongly advised to <a href="%s" target="_blank">use a specialty plugin</a> instead.', 'olsen' ), 'https://wordpress.org/plugins/search.php?q=analytics' ),
	)
);
