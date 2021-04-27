<?php
if ( ! function_exists( 'olsen_customize_preview_google_fonts' ) ) {
	function olsen_customize_preview_google_fonts( $_this, $container_context ) {
		olsen_enqueue_google_fonts();
		wp_print_styles( 'olsen-user-google-fonts' );
	}
}
