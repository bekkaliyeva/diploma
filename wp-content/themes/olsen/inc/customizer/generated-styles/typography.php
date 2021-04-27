<?php
	$css = Olsen_Customizer_CSS_Generator::get_instance();

	//
	// Typography
	//
	$value = get_theme_mod( 'global_typo_body', olsen_customizer_defaults( 'global_typo_body' ) );
	$css->add_typography( $value, '', 'body { %s }' );

	$value = get_theme_mod( 'global_typo_secondary', olsen_customizer_defaults( 'global_typo_secondary' ) );
	$css->add_typography( $value, '', '
		.site-logo > div,
		.entry-content .opening p:first-child:first-letter { %s }' );

	$value = get_theme_mod( 'global_typo_h1', olsen_customizer_defaults( 'global_typo_h1' ) );
	$css->add_typography( $value, '', 'h1 { %s }' );

	$value = get_theme_mod( 'global_typo_h2', olsen_customizer_defaults( 'global_typo_h2' ) );
	$css->add_typography( $value, '', 'h2 { %s }' );

	$value = get_theme_mod( 'global_typo_h3', olsen_customizer_defaults( 'global_typo_h3' ) );
	$css->add_typography( $value, '', 'h3 { %s }' );

	$value = get_theme_mod( 'global_typo_h4', olsen_customizer_defaults( 'global_typo_h4' ) );
	$css->add_typography( $value, '', 'h4 { %s }' );

	$value = get_theme_mod( 'global_typo_h5', olsen_customizer_defaults( 'global_typo_h5' ) );
	$css->add_typography( $value, '', 'h5 { %s }' );

	$value = get_theme_mod( 'global_typo_h6', olsen_customizer_defaults( 'global_typo_h6' ) );
	$css->add_typography( $value, '', 'h6 { %s }' );

	$value = get_theme_mod( 'global_typo_form_text', olsen_customizer_defaults( 'global_typo_form_text' ) );
	$css->add_typography( $value, '', 'input, textarea, select { %s }' );

	$value = get_theme_mod( 'global_typo_form_labels', olsen_customizer_defaults( 'global_typo_form_labels' ) );
	$css->add_typography( $value, '', 'form label, form .label { %s }' );

	$value = get_theme_mod( 'global_typo_buttons', olsen_customizer_defaults( 'global_typo_buttons' ) );
	$css->add_typography( $value, '', '
		.btn,
		.button,
		.ci-item-btn,
		button[type="submit"],
		input[type="submit"],
		input[type="reset"],
		input[type="button"],
		button,
		#paging,
		.read-more,
		.comment-reply-link,
		 .zoom-instagram-widget .zoom-instagram-widget__follow-me a {
			%s
		}'
	);

	$value = get_theme_mod( 'global_typo_widget_titles', olsen_customizer_defaults( 'global_typo_widget_titles' ) );
	$css->add_typography( $value, '', '.widget-title { %s }' );

	$value = get_theme_mod( 'global_typo_widget_text', olsen_customizer_defaults( 'global_typo_widget_text' ) );
	$css->add_typography( $value, '', '.widget { %s }' );

