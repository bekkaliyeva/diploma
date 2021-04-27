<?php get_header(); ?>
<?php
	$content_class = 'col-12';
	$sidebar_class = '';

	if ( ! is_product() && is_active_sidebar( 'shop' ) && get_theme_mod( 'olsen_woo_sidebar', 1 ) ) {
		$content_class = 'col-lg-8 col-12';
		$sidebar_class = 'col-lg-4 col-12';
	}
?>
<div class="row">

	<div class="col-12">
		<main id="content">
			<div class="row">
				<div class="<?php echo esc_attr( $content_class ); ?>">

					<?php woocommerce_content(); ?>

				</div>

				<?php if ( ! empty( $sidebar_class ) ) : ?>
					<div class="<?php echo esc_attr( $sidebar_class ); ?>">

						<?php get_sidebar(); ?>

					</div>
				<?php endif; ?>
			</div>
		</main>
	</div>

</div>

<?php get_footer(); ?>
