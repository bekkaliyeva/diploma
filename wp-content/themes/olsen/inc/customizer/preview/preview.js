/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview changes asynchronously.
 *
 * https://developer.wordpress.org/themes/customize-api/tools-for-improved-user-experience/#using-postmessage-for-improved-setting-previewing
 */

(function ( $ ) {
	var OLSEN_PREVIEW_SCRIPTS = {
		/**
		 * The available breakpoints.
		 *
		 * @enum breakpoints
		 */
		breakpoints: {
			'desktop': '',
			'tablet': 991,
			'mobile': 575,
		},

		/**
		 * Checks if a value is undefined, null, or empty string.
		 *
		 * @param {*} value - The value.
		 * @returns {boolean}
		 */
		isNil: function ( value ) {
			return value == null || value === '';
		},

		/**
		 * Injects a namespaced stylesheet in the <body> element of the document
		 * or replaces its contents with the provided styles if it already exists.
		 *
		 * @param {string} settingName - The setting's name.
		 * @param {string} styles - A string of generated styles.
		 */
		injectStylesheet: function ( settingName, styles ) {
			var $stylesheet = $( 'style.' + settingName );

			if ( $stylesheet.length ) {
				$stylesheet.text( styles );
			} else {
				$( '<style />', {
					class: settingName,
				} ).text( styles ).appendTo( 'body' );
			}
		},

		/**
		 * Wraps a set of style rules in a breakpoint media query (if necessary).
		 *
		 * @param {breakpoints} breakpoint - A breakpoint.
		 * @param {string} styles - The CSS rules (styles).
		 * @returns {string} - The CSS rules optionally wrapped in a media query.
		 */
		wrapMediaQuery: function ( breakpoint, styles ) {
			if (breakpoint === 'desktop') {
				return styles;
			}

			return '@media (max-width: ' + this.breakpoints[breakpoint] + 'px) { ' + styles + ' }';
		},

		/**
		 * Wraps a set of style rules in a breakpoint media query that applies
		 * only the the particular media query.
		 *
		 * @param {breakpoints} breakpoint - A breakpoint.
		 * @param {string} styles - The CSS rules (styles).
		 * @returns {string} - The CSS rules optionally wrapped in a media query.
		 */
		wrapMediaQueryOnly: function ( breakpoint, styles ) {
			var desktopMin = this.breakpoints['tablet'] + 1;
			var tabletMax = this.breakpoints['tablet'];
			var tabletMin = this.breakpoints['mobile'] + 1;
			var mobileMax = this.breakpoints['mobile'];

			if (breakpoint === 'desktop') {
				return '@media (min-width: ' + desktopMin + 'px) { ' + styles + ' }';
			}

			if (breakpoint === 'tablet') {
				return '@media (min-width: ' + tabletMin + 'px) and (max-width: ' + tabletMax + 'px) { ' + styles + ' }';
			}

			if (breakpoint === 'mobile') {
				return '@media (max-width: ' + mobileMax + 'px) { ' + styles + ' }';
			}
		},

		/**
		 * Generates spacing rules.
		 *
		 * @param {string} mode - The rule mode (padding, margin, or position).
		 * @param {object} values - The control's values.
		 * @return {string} - The CSS rules.
		 */
		generateSpacingRules: function ( mode, values ) {
			var that  = this;
			var rules = {};
			var keys  = [ 'top', 'right', 'bottom', 'left' ];

			keys.forEach( function ( key ) {
				if ( that.isNil( values[ key ] ) ) {
					return;
				}

				var property = mode === 'position' ? key : mode + '-' + key;

				rules[ property ] = values[ key ] + 'px';
			} );

			return _.reduce( rules, function ( css, value, key ) {
				return css + ' ' + key + ':' + value + ';';
			}, '' );
		},

		/**
		 * Generates stylesheet for the spacing control.
		 *
		 * @param {string} settingName - The setting's name.
		 * @param {string} selectors - The selectors to apply the styles to.
		 * @param {string} mode - The rule mode (padding or margin).
		 * @param {object} values - The control's values.
		 */
		createSpacingControlStyles: function ( settingName, selectors, mode, values ) {
			values     = typeof values === 'string' ? JSON.parse( values ) : values;
			var that   = this;
			var styles = _.reduce( values, function ( styles, value, breakpoint ) {
				return styles + ' ' + that.wrapMediaQuery(
					breakpoint,
					selectors + ' { ' + that.generateSpacingRules( mode, value ) + ' } ',
				);
			}, '' );

			this.injectStylesheet( settingName, styles );
		},

		/**
		 * Creates styles for the range customizer control and injects the stylesheet.
		 *
		 * @param {string} settingName - The setting's name.
		 * @param {string} rules - The CSS rules (accepts underscore templating).
		 * @param {Object} values - The values as returned from the range control.
		 * @param {boolean} breakpointLimit - If the styles should be limited per breakpoint and not overflow.
		 * @param {Object[]} [edgeRules] - Optional CSS rules to apply for specific values.
		 */
		createRangeControlStyles: function ( settingName, rules, values, breakpointLimit, edgeRules ) {
			values   = typeof values === 'string' ? JSON.parse( values ) : values;
			edgeRules = edgeRules || [];
			var that = this;

			_.templateSettings = {
				interpolate: /\{\{(.+?)\}\}/g
			};


			var styles = _.reduce( values, function ( styles, value, breakpoint ) {
				if ( that.isNil( value ) ) {
					return styles;
				}

				var edgeValue = edgeRules.find( function ( edgeRule ) {
					return edgeRule.value == value;
				} );

				var template = _.template( edgeValue ? edgeValue.rules : rules );
				var rulesTemplate = template( { value: value } );

				if (breakpointLimit) {
					return styles + ' ' + that.wrapMediaQueryOnly( breakpoint, rulesTemplate );
				} else {
					return styles + ' ' + that.wrapMediaQuery( breakpoint, rulesTemplate );
				}
			}, '' );

			this.injectStylesheet( settingName, styles );
		},

		/**
		 * Given a font variant (as defined in fonts.json) returns the font weight.
		 *
		 * @param {string} variant - The font variant setting.
		 * @return {string} - The font weight.
		 */
		getFontWeightFromVariant: function ( variant ) {
			if ( !variant ) {
				return;
			}

			if ( variant === 'regular' || variant === 'italic' ) {
				return '400';
			}

			var matches = variant.match( /\d+/g );
			if ( matches && matches[0] ) {
				return matches[0];
			}
		},

		/**
		 * Given a font variant (as defined in fonts.json) returns the font style.
		 *
		 * @param {string} variant - The font variant setting.
		 * @return {string} - The font style.
		 */
		getFontStyleFromVariant: function ( variant ) {
			if ( !variant ) {
				return;
			}

			if ( variant.indexOf( 'italic' ) > -1 ) {
				return 'italic';
			}

			return 'normal';
		},

		/**
		 * Generates a string of CSS rules for the typography control.
		 *
		 * @param {Object} values - The typography values as returned from the typography control.
		 * @returns {string}
		 */
		generateTypographyRules: function ( values ) {
			var rules = [];

			if ( ! this.isNil( values.family ) ) {
				var fonts = values.family
					.split( ',' )
					.map( function ( s ) {
						var trimmed = s.trim();

						if ( trimmed.indexOf( ' ' ) > - 1 ) {
							return '"' + trimmed + '"';
						}

						return trimmed;
					} )
					.join( ', ' );

				rules.push( 'font-family: ' + fonts + ';' );
			}

			if ( ! this.isNil( values.variant ) ) {
				var weight = this.getFontWeightFromVariant( values.variant );
				var style = this.getFontStyleFromVariant( values.variant );

				if ( weight ) {
					rules.push( 'font-weight: ' + weight + ';' );
				}

				if ( style ) {
					rules.push( 'font-style: ' + style + ';' );
				}
			}

			if ( ! this.isNil( values.size ) ) {
				rules.push( 'font-size: ' + values.size + 'px;' );
			}

			if ( ! this.isNil( values.lineHeight ) ) {
				rules.push( 'line-height: ' + values.lineHeight + ';' )
			}

			if ( ! this.isNil( values.transform ) ) {
				rules.push( 'text-transform: ' + values.transform + ';' );
			}

			if ( ! this.isNil( values.spacing ) ) {
				rules.push( 'letter-spacing: ' + values.spacing + 'px;' );
			}

			return rules.join( ' ' );
		},

		/**
		 * Creates all typography styles and injects the stylesheet.
		 *
		 * @param {string} settingName - The setting's name.
		 * @param {string} selectors - The CSS selectors.
		 * @param {Object} values - The values as returned from the typography control.
		 */
		createTypographyStyles: function (settingName, selectors, values) {
			values     = typeof values === 'string' ? JSON.parse( values ) : values;
			var that   = this;
			var styles = _.reduce( values, function ( styles, value, breakpoint ) {
				return styles + ' ' + that.wrapMediaQuery(
					breakpoint,
					selectors + ' { ' + that.generateTypographyRules( value ) + ' } ',
				);
			}, '' );

			this.injectStylesheet( settingName, styles );
		},

		/**
		 * Creates and injects stylesheet for the background image control.
		 *
		 * @param {string} settingName - The setting's name.
		 * @param {string} selector - The CSS selector.
		 * @param {Object} values - The background image values.
		 */
		createBackgroundImageStyles: function (settingName, selector, values) {
			var rules = [];

			if ( ! this.isNil( values.image_url ) ) {
				rules.push( 'background-image: url(' + values.image_url + ');' );
			} else {
				rules.push( 'background-image: none;' );
			}

			if ( ! this.isNil( values.repeat ) ) {
				rules.push( 'background-repeat: ' + values.repeat + ';' );
			}

			if ( ! this.isNil( values.position ) ) {
				rules.push( 'background-position: ' + values.position + ';' );
			}

			if ( ! this.isNil( values.attachment ) ) {
				rules.push( 'background-attachment: ' + values.attachment + ';' );
			}

			if ( ! this.isNil( values.size ) ) {
				rules.push( 'background-size: ' + values.size + ';' );
			}

			var styles = selector + ' { ' + rules.join( ' ' ) + ' } ';
			this.injectStylesheet( settingName, styles );
		},

		/**
		 * Creates namespaced inline styles in the <body> element.
		 *
		 * @param {string} settingName - The setting name.
		 * @param {Array<Object>} styles - The style rules.
		 */
		createStyleSheet: function ( settingName, styles ) {
			var $styleElement;

			style = '<style class="' + settingName + '">';
			style += styles.reduce( function ( rules, style ) {
				rules += style.selectors + '{' + style.property + ':' + style.value + ';} ';
				return rules;
			}, '' );
			style += '</style>';

			$styleElement = $( '.' + settingName );

			if ( $styleElement.length ) {
				$styleElement.replaceWith( style );
			} else {
				$( 'body' ).append( style );
			}
		},
	};

	if ( ! window.OLSEN_PREVIEW_SCRIPTS ) {
		window.OLSEN_PREVIEW_SCRIPTS = OLSEN_PREVIEW_SCRIPTS;
	}
})( jQuery );
