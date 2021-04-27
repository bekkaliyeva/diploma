<?php
if ( class_exists( 'WooCommerce' ) ) :
	add_action( 'init', 'olsen_woocommerce_integration' );
	function olsen_woocommerce_integration() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	}

	// Change posts_per_page on upsell products
	add_filter( 'woocommerce_upsells_total', 'ci_woocommerce_upsells_total' );
	if ( ! function_exists( 'ci_woocommerce_upsells_total' ) ) :
		function ci_woocommerce_upsells_total( $limit ) {
			$limit = 4;
			return $limit;
		}
	endif;

	// Change posts_per_page on related products
	add_filter( 'woocommerce_output_related_products_args', 'ci_output_related_products_args' );
	if ( ! function_exists( 'ci_output_related_products_args' ) ) :
		function ci_output_related_products_args( $args ) {
			$args['posts_per_page'] = 4;
			return $args;
		}
	endif;

	// Change posts_per_page on cross sells
	add_filter( 'woocommerce_cross_sells_total', 'ci_woocommerce_cross_sells_total' );
	if ( ! function_exists( 'ci_woocommerce_cross_sells_total' ) ) :
		function ci_woocommerce_cross_sells_total( $limit ) {
			$limit = 4;
			return $limit;
		}
	endif;

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );

endif;