<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry ' ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

	<?php if ( get_post_type() === 'post' && 'yes' === $settings['show_post_meta'] ) : ?>
		<div class="entry-meta">
			<p class="entry-categories">
				<?php the_category( ' ' ); ?>
			</p>
			<time class="entry-date" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</div>
	<?php endif; ?>

	<?php
	if ( 'yes' === $settings['show_title'] ) {
		the_title( sprintf( '<h2 itemprop="headline" class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}
	?>

	<?php if ( get_post_format() === 'gallery' && 'yes' === $settings['show_thumbnail'] ) : ?>
		<div class="entry-featured">
			<?php
				$gallery      = olsen_featgal_get_attachments( get_the_ID() );
				$gallery_type = get_post_meta( get_the_ID(), 'gallery_layout', true );
			?>
			<?php if ( $gallery->have_posts() ): ?>
				<?php if ( $gallery_type === 'tiled' ) : ?>
					<div class="entry-justified" data-height='150'>
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<a class="olsen-lightbox jg-entry" href="<?php echo esc_url( olsen_get_image_src( get_the_ID(), 'large' ) ); ?>">
								<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
								<img src="<?php echo esc_url( olsen_get_image_src( get_the_ID(), 'olsen_thumb_wide' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
							</a>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php else : ?>
					<div class="feature-slider">
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<div class="slide">
								<a class="olsen-lightbox" href="<?php echo esc_url( olsen_get_image_src( get_the_ID(), 'large' ) ); ?>">
									<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
									<img src="<?php echo esc_url( olsen_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
								</a>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php elseif ( get_post_format() === 'audio' || get_post_format() === 'video' ) : ?>
		<?php // We don't want anything to appear here ?>
	<?php else : ?>
		<?php if ( has_post_thumbnail() && 'yes' === $settings['show_thumbnail'] ) : ?>
			<div class="entry-featured">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-content" itemprop="text">
		<?php
		if ( 'yes' === $settings['show_excerpt'] ) {
			the_excerpt();
		}
		?>
	</div>

	<div class="entry-utils group">
		<?php if ( 'yes' === $settings['show_button'] ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php esc_html_e( 'Continue Reading', 'olsen' ); ?></a>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'single_social_sharing', 1 ) && 'yes' === $settings['show_social_sharing'] ) {
			get_template_part( 'part', 'social-sharing' );
		} ?>
	</div>
</article>
