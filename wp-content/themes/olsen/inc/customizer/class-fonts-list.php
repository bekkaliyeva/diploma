<?php
class Olsen_Fonts_List {
	/**
	 * Holds an array of font objects, as retrieved by the fonts.json file.
	 *
	 * @var array
	 */
	private $fonts = array();

	/**
	 * Holds a copy of itself, so it can be referenced by the class name.
	 *
	 * @var Olsen_Fonts_List
	 */
	public static $instance;

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return Olsen_Fonts_List
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$font_path = '/inc/customizer/fonts.json';

		$body = false;

		// Try to fetch the file locally.
		$font_file = get_theme_file_path( $font_path );
		if ( is_readable( $font_file ) && is_file( $font_file ) ) {
			// Since file_get_contents() is not allowed, and WP_Filesystem is an overkill for our needs (which
			// does a file_get_contents() itself anyway), we use file() instead. It is no different than require()ing
			// or include()ing the file and saving its contents into an output buffer.
			// Related slack discussion: https://wordpress.slack.com/archives/C02RP4Y3K/p1538832288000100
			$body = implode( '', file( $font_file ) );
		}

		// Failed. Try with a remote request.
		if ( false === $body ) {
			$font_file = get_theme_file_uri( $font_path );
			$request   = wp_safe_remote_get( $font_file );

			if ( is_wp_error( $request ) ) {
				return false;
			}

			$body = wp_remote_retrieve_body( $request );
		}

		if ( empty( $body ) ) {
			return false;
		}

		$content = json_decode( $body );

		if ( ! is_null( $content ) ) {
			$this->fonts = $content->items;
		}
	}

	/**
	 * Returns the fonts array, as retrieved from the json file.
	 *
	 * @return array
	 */
	public function get() {
		return $this->fonts;
	}

	/**
	 * Returns an array of fonts divided into groups.
	 *
	 * @return array
	 */
	public function get_font_options() {
		$fonts = array(
			'standard'     => array(
				'label' => esc_html__( 'Standard Fonts', 'olsen' ),
				'fonts' => array(),
			),
			'google_fonts' => array(
				'label' => esc_html__( 'Google Fonts', 'olsen' ),
				'fonts' => array(),
			),
		);

		foreach ( $this->fonts as $font ) {
			if ( isset( $font->kind ) && 'webfonts#webfont' === $font->kind ) {
				array_push( $fonts['google_fonts']['fonts'], $font );
			} else {
				array_push( $fonts['standard']['fonts'], $font );
			}
		}

		return $fonts;
	}

	/**
	 * Echoes the optgroup and option elements required by a <select> dropdown to display the fonts.
	 *
	 * @param string $selected
	 */
	public function echo_font_options( $selected = '' ) {
		$fonts = $this->get_font_options();

		foreach ( $fonts as $optgroup ) {
			?><optgroup label="<?php echo esc_attr( $optgroup['label'] ); ?>"><?php

			foreach ( $optgroup['fonts'] as $font ) {
				$label = isset( $font->label ) ? $font->label : $font->family;
				?>
				<option value="<?php echo esc_attr( $font->family ); ?>" <?php selected( $selected, $font->family ); ?>>
					<?php echo wp_kses( $label, 'strip' ); ?>
				</option>
				<?php
			}

			?></optgroup><?php
		}
	}

	/**
	 * Fetches text transform choices.
	 *
	 * @access public
	 * @return array
	 */
	public function get_transform_choices() {
		return array(
			''          => __( 'Inherit', 'olsen' ),
			'none'      => __( 'None', 'olsen' ),
			'uppercase' => __( 'Uppercase', 'olsen' ),
			'lowercase' => __( 'Lowercase', 'olsen' ),
		);
	}

	/**
	 * Returns font variant labels.
	 *
	 * @access public
	 * @return array
	 */
	public function get_variant_labels() {
		return array(
			'100'       => __( 'Thin 100', 'olsen' ),
			'100italic' => __( 'Thin 100 Italic', 'olsen' ),
			'200'       => __( 'Light 200', 'olsen' ),
			'200italic' => __( 'Light 200 Italic', 'olsen' ),
			'300'       => __( 'Book 300', 'olsen' ),
			'300italic' => __( 'Book 300 Italic', 'olsen' ),
			'regular'   => __( 'Normal 400', 'olsen' ),
			'400'       => __( 'Normal 400', 'olsen' ),
			'italic'    => __( 'Normal 400 Italic', 'olsen' ),
			'400italic' => __( 'Normal 400 Italic', 'olsen' ),
			'500'       => __( 'Medium 500', 'olsen' ),
			'500italic' => __( 'Medium 500 Italic', 'olsen' ),
			'600'       => __( 'Semibold 600', 'olsen' ),
			'600italic' => __( 'Semibold 600 Italic', 'olsen' ),
			'700'       => __( 'Bold 700', 'olsen' ),
			'700italic' => __( 'Bold 700 Italic', 'olsen' ),
			'800'       => __( 'Extra Bold 800', 'olsen' ),
			'800italic' => __( 'Extra Bold 800 Italic', 'olsen' ),
			'900'       => __( 'Heavy 900', 'olsen' ),
			'900italic' => __( 'Heavy 900 Italic', 'olsen' ),
		);
	}
}
