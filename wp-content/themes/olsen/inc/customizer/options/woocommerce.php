<?php
if ( class_exists( 'WooCommerce' ) ) {
	$wpc->add_section(
		'theme_woocommerce',
		array(
			'title'    => esc_html_x( 'Theme Options', 'customizer section title', 'olsen' ),
			'panel'    => 'woocommerce',
			'priority' => 115,
		)
	);

	$wpc->add_setting(
		'olsen_woo_sidebar',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);
	$wpc->add_control(
		'olsen_woo_sidebar',
		array(
			'type'    => 'checkbox',
			'section' => 'theme_woocommerce',
			'label'   => __( 'Enable the sidebar on product listings.', 'olsen' ),
		)
	);
}