<div class="sidebar sidebar-right">
	<?php
		if( is_page_template( 'template-listing-looks.php' ) ) {
			dynamic_sidebar( 'blog' );
		} elseif( is_page() && is_active_sidebar( 'page' ) ) {
			dynamic_sidebar( 'page' );
		} elseif ( class_exists( 'WooCommerce' ) && is_woocommerce() && ! is_product() ) {
			dynamic_sidebar( 'shop' );
		} else {
			dynamic_sidebar( 'blog' );
		}
	?>
</div><!-- /sidebar -->
