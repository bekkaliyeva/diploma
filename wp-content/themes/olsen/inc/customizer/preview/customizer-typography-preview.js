/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview changes asynchronously.
 *
 * https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/#using-postmessage-for-improved-setting-previewing
 */

(function ( $ ) {
	//
	// Typography
	//
	wp.customize( 'global_typo_body', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_body',
				'body',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_secondary', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_secondary',
				'.site-logo > div, .entry-content .opening p:first-child:first-letter',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h1', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h1',
				'h1, .site-logo > div',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h2', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h2',
				'h2',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h3', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h3',
				'h3',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h4', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h4',
				'h4',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h5', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h5',
				'h5',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_h6', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_h6',
				'h6',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_form_labels', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_form_labels',
				'form label, form .label',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_form_text', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_form_text',
				'input, textarea, select',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_buttons', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_buttons',
				'btn,.button,.ci-item-btn,button[type="submit"],input[type="submit"],input[type="reset"],input[type="button"],button,#paging,.read-more,.comment-reply-link, .zoom-instagram-widget .zoom-instagram-widget__follow-me a',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_widget_titles', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_widget_titles',
				'.widget-title',
				to,
			);
		} );
	} );

	wp.customize( 'global_typo_widget_text', function ( value ) {
		value.bind( function ( to ) {
			OLSEN_PREVIEW_SCRIPTS.createTypographyStyles(
				'global_typo_widget_text',
				'.widget',
				to,
			);
		} );
	} );

})( jQuery );
