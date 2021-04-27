<div class="entry-author group">
	<figure class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 90, get_option( 'avatar_default', 'mystery' ), esc_attr( get_the_author_meta( 'display_name' ) ), array( 'extra_attr' => 'itemprop="image"' ) ); ?>
	</figure>

	<div class="author-details">
		<h4><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h4>

		<?php if ( get_the_author_meta( 'description' ) ): ?>
			<p class="author-excerpt">
				<?php echo wp_kses( get_the_author_meta( 'description' ), olsen_get_allowed_tags( 'guide' ) ); ?>
			</p>
		<?php else: ?>
			<p class="author-excerpt">
				<?php _e( 'In this area you can display your biographic info. Just visit <em>Users > Your Profile > Biographic info</em>', 'olsen' ); ?>
			</p>
		<?php endif; ?>

		<?php get_template_part( 'part-social-icons' ); ?>
	</div>
</div>