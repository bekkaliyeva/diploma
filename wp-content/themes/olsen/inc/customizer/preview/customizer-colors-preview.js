/**
 * Base Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Base Theme Customizer preview reload changes asynchronously.
 *
 * https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/#using-postmessage-for-improved-setting-previewing
 */

(function ($) {
	function createStyleSheet(settingName, styles) {
		var $styleElement;

		style = '<style class="' + settingName + '">';
		style += styles.reduce(function (rules, style) {
			rules += style.selectors + '{' + style.property + ':' + style.value + ';} ';
			return rules;
		}, '');
		style += '</style>';

		$styleElement = $('.' + settingName);

		if ($styleElement.length) {
			$styleElement.replaceWith(style);
		} else {
			$('head').append(style);
		}
	}

	//
	// Global Colors
	//

	wp.customize('site_text_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_text_color', [
				{
					property: 'color',
					value: to,
					selectors: 'body, .tagline'
				},
			]);
		});
	});

	wp.customize('site_headings_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_headings_color', [
				{
					property: 'color',
					value: to,
					selectors: 'h1, h2, h3, h4, h5, h6,.entry-title,.entry-title a'
				},
				{
					property: 'background-color',
					value: to,
					selectors: '.entry-title:after'
				}
			]);
		});
	});

	wp.customize('site_link_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_link_color', [
				{
					property: 'color',
					value: to,
					selectors: 'a'
				},
			]);
		});
	});

	wp.customize('site_link_color_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_link_color_hover', [
				{
					property: 'color',
					value: to,
					selectors: 'a:hover,.entry-title a:hover,.socials li a:hover,.entry-utils .socials a:hover'
				},
			]);
		});
	});

	wp.customize('site_accent_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_accent_color', [
				{
					property: 'background-color',
					value: to,
					selectors: '.onsale,.woocommerce-product-gallery__trigger,.price_slider .ui-slider-handle'
				},
				{
					property: 'color',
					value: to,
					selectors: 'a:hover,a:focus,.read-more,.button,.tns-outer button,.entry-title a:hover,.entry-meta a,.entry-tags a:hover,.navigation > li:hover > a,.navigation > li > a:focus,.navigation > .current-menu-item > a,.navigation > .current-menu-parent > a,.navigation > .current-menu-ancestor > a,.navigation > .current_page_item > a,.navigation > .current_page_ancestor > a,.navigation li li:hover > a,.navigation li li > a:focus,.navigation li .current-menu-item > a,.navigation li .current-menu-parent > a,.navigation li .current-menu-ancestor > a,.navigation li .current_page_item > a,.navigation li .current_page_ancestor > a'
				},
				{
					property: 'border-color',
					value: to,
					selectors: '.read-more:hover,.button:hover'
				},
			]);
		});
	});

	wp.customize('site_accent_color_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_accent_color_hover', [
				{
					property: 'background-color',
					value: to,
					selectors: '#paging a:hover,#paging a:hover,#paging .current'
				},
				{
					property: 'color',
					value: to,
					selectors: '.entry-meta a:hover,.read-more:hover,.button:hover'
				},
			]);
		});
	});

	wp.customize('site_border_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('site_border_color', [
				{
					property: 'border-top-color',
					value: to,
					selectors: '.site-bar,.top-bar,.home #site-content,#footer'
				},
				{
					property: 'border-bottom-color',
					value: to,
					selectors: '.site-bar,.top-bar,.widget,.widget_meta ul li a,.widget_pages ul li a,.widget_categories ul li a,.widget_archive ul li a,.widget_nav_menu ul li a,.widget_recent_entries ul li a,.widget_recent_comments ul li'
				},
				{
					property: 'border-right-color',
					value: to,
					selectors: '#paging a,#paging > span,#paging li span'
				},
				{
					property: 'border-left-color',
					value: to,
					selectors: 'blockquote'
				},
				{
					property: 'border-color',
					value: to,
					selectors: '.read-more,.button,.entry-content .entry-counter-list li,#paging'
				},
				{
					property: 'background-color',
					value: to,
					selectors: '.entry-utils:before,.navigation ul'
				},
			]);
		});
	});

	wp.customize('button_text', function (value) {
		value.bind(function (to) {
			createStyleSheet('button_text', [
				{
					property: 'color',
					value: to,
					selectors: '.btn,.comment-reply-link,input[type="button"],input[type="submit"],button[type="submit"],input[type="reset"],button.button'
				},
			]);
		});
	});

	wp.customize('button_bg', function (value) {
		value.bind(function (to) {
			createStyleSheet('button_bg', [
				{
					property: 'background-color',
					value: to,
					selectors: '.btn,.comment-reply-link,input[type="button"],input[type="submit"],button[type="submit"],input[type="reset"],button.button,.zoom-instagram-widget .zoom-instagram-widget__follow-me a'
				},
			]);
		});
	});

	wp.customize('button_text_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('button_text_hover', [
				{
					property: 'color',
					value: to,
					selectors: '.btn:hover,.comment-reply-link:hover,input[type="button"]:hover,input[type="submit"]:hover,button[type="submit"]:hover,input[type="reset"]:hover,button.button:hover'
				},
			]);
		});
	});

	wp.customize('button_bg_hover', function (value) {
		value.bind(function (to) {
			createStyleSheet('button_bg_hover', [
				{
					property: 'background-color',
					value: to,
					selectors: '.btn:hover,.comment-reply-link:hover,input[type="button"]:hover,input[type="submit"]:hover,button[type="submit"]:hover,input[type="reset"]:hover,button.button:hover, .zoom-instagram-widget .zoom-instagram-widget__follow-me a:hover'
				},
			]);
		});
	});
	//
	// Header Colors
	//
	wp.customize('header_bg_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_bg_color', [
				{
					property: 'background-color',
					value: to,
					selectors: '#masthead .site-logo'
				},
			]);
		});
	});

	wp.customize('header_logo_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('header_logo_color', [
				{
					property: 'color',
					value: to,
					selectors: '.site-header .site-logo a,.site-header .site-logo a:hover'
				},
			]);
		});
	});

	//
	// Sidebar Colors
	//
	wp.customize('sidebar_bg_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('sidebar_bg_color', [
				{
					property: 'background-color',
					value: to,
					selectors: '.sidebar'
				},
			]);
		});
	});

	wp.customize('widgets_border_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_border_color', [
				{
					property: 'border-color',
					value: to,
					selectors: '.sidebar .widget,.widget_meta ul li a,.widget_pages ul li a,.widget_categories ul li a,.widget_archive ul li a,.widget_nav_menu ul li a,.widget_recent_entries ul li a,.widget_recent_comments ul li'
				},
			]);
		});
	});

	wp.customize('widgets_title_bg_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_title_bg_color', [
				{
					property: 'background-color',
					value: to,
					selectors: '.sidebar .widget-title'
				},
			]);
		});
	});

	wp.customize('widgets_title_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_title_color', [
				{
					property: 'color',
					value: to,
					selectors: '.sidebar .widget-title'
				},
				{
					property: 'background-color',
					value: to,
					selectors: '.sidebar .widget-title:after'
				}
			]);
		});
	});

	wp.customize('widgets_text_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_text_color', [
				{
					property: 'color',
					value: to,
					selectors: '.sidebar .widget'
				},
			]);
		});
	});

	wp.customize('widgets_link_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_link_color', [
				{
					property: 'color',
					value: to,
					selectors: '.sidebar .widget a'
				},
			]);
		});
	});

	wp.customize('widgets_hover_color', function (value) {
		value.bind(function (to) {
			createStyleSheet('widgets_hover_color', [
				{
					property: 'color',
					value: to,
					selectors: '.sidebar .widget a:hover'
				},
			]);
		});
	});


})(jQuery);
