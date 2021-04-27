<?php
	$wpc->add_setting( 'global_typo_disable_google_fonts', array(
		'default'           => olsen_customizer_defaults( 'global_typo_disable_google_fonts' ),
		'sanitize_callback' => 'absint',
	) );
	$wpc->add_control( 'global_typo_disable_google_fonts', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Disable Google Fonts', 'olsen' ),
	) );

	$wpc->add_setting( 'global_typo_body', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_body' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_body', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Body font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_secondary', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_secondary' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_secondary', array(
		'section'             => 'typography',
		'label'               => esc_html__( 'Secondary font', 'olsen' ),
		'font_family_options' => false,
	) ) );

	$wpc->add_setting( 'global_typo_h1', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h1' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h1', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H1 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_h2', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h2' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h2', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H2 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_h3', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h3' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h3', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H3 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_h4', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h4' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h4', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H4 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_h5', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h5' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h5', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H5 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_h6', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_h6' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_h6', array(
		'section' => 'typography',
		'label'   => esc_html__( 'H6 font', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_form_labels', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_form_labels' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_form_labels', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Form labels', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_form_text', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_form_text' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_form_text', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Form text', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_buttons', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_buttons' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_buttons', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Button text', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_widget_titles', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_widget_titles' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_widget_titles', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Widget titles', 'olsen' ),
	) ) );

	$wpc->add_setting( 'global_typo_widget_text', array(
		'transport'         => 'postMessage',
		'default'           => olsen_customizer_defaults( 'global_typo_widget_text' ),
		'sanitize_callback' => 'olsen_sanitize_typography_control_breakpoints',
	) );
	$wpc->add_control( new Olsen_Customize_Typography_Control( $wpc, 'global_typo_widget_text', array(
		'section' => 'typography',
		'label'   => esc_html__( 'Widget text', 'olsen' ),
	) ) );

$wpc->add_setting(
	'menu_text_size',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'menu_text_size',
	array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Menu text size', 'olsen' ),
	)
);

$wpc->add_setting(
	'submenu_text_size',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_intval_or_empty',
	)
);
$wpc->add_control(
	'submenu_text_size',
	array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => __( 'Sub-menu text size', 'olsen' ),
	)
);

$wpc->add_setting(
	'capital_logo',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'capital_logo',
	array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize textual logo and site tagline.', 'olsen' ),
	)
);

$wpc->add_setting(
	'capital_navigation',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'capital_navigation',
	array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize navigation menus.', 'olsen' ),
	)
);

$wpc->add_setting(
	'capital_content_headings',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'capital_content_headings',
	array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize post content headings (H1-H6).', 'olsen' ),
	)
);

$wpc->add_setting(
	'capital_post_titles',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'capital_post_titles',
	array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize post titles.', 'olsen' ),
	)
);

$wpc->add_setting(
	'capital_entry_meta',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'capital_entry_meta',
	array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => __( 'Capitalize entry meta (categories, time, tags).', 'olsen' ),
	)
);