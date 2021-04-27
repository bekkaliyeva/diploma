<?php get_header(); ?>

<?php $sidebar = get_theme_mod( 'layout_other', 'side' ) === 'side' ? true : false; ?>

<div class="row">

	<div class="col-lg-8 <?php echo esc_attr( $sidebar ? '' : 'offset-lg-2' ); ?> col-12">
		<main id="content">
			<div class="row">
				<div class="col-12">
					<article class="entry">
						<h1 class="entry-title">
							<?php _e( 'Page not found' , 'olsen' ); ?>
						</h1>

						<div class="entry-content">
							<p><?php _e( 'The page you were looking for can not be found! Perhaps try searching?', 'olsen' ); ?></p>
							<?php get_search_form(); ?>
						</div>
					</article>
				</div>
			</div>
		</main>
	</div>

	<?php if ( $sidebar ) : ?>
		<div class="col-lg-4 col-12">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
