				</div><!-- /site-content -->

				<?php if ( ! is_page_template( 'template-blank.php') ) : ?>
					<footer id="footer">

						<?php if ( is_active_sidebar( 'footer-widgets') ) : ?>
							<?php
								$attributes = sprintf( 'data-auto="%s" data-speed="%s"',
									esc_attr( get_theme_mod( 'instagram_auto', 1 ) ),
									esc_attr( get_theme_mod( 'instagram_speed', 300 ) )
								);
							?>
							<div class="row">
								<div class="col-12">
									<div class="footer-widget-area" <?php echo $attributes; ?>>
										<?php dynamic_sidebar( 'footer-widgets' ); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<div class="site-bar group">
							<nav class="nav">
								<?php wp_nav_menu( array(
									'theme_location' => 'footer_menu',
									'container'      => '',
									'menu_id'        => '',
									'menu_class'     => 'navigation',
									'depth'          => 1,
								) ); ?>
							</nav>

							<div class="site-tools">
								<?php if ( get_theme_mod( 'footer_socials', 1 ) == 1 ) {
									get_template_part( 'part-social-icons' );
								} ?>
							</div><!-- /site-tools -->
						</div><!-- /site-bar -->
						<div class="site-logo">
							<h3>
								<a href="<?php echo esc_url( home_url() ); ?>">
									<?php if( get_theme_mod( 'footer_logo', get_template_directory_uri() . '/images/logo.png' ) ): ?>
										<img src="<?php echo esc_url( get_theme_mod( 'footer_logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
									<?php else: ?>
										<?php bloginfo( 'name' ); ?>
									<?php endif; ?>
								</a>
							</h3>

							<?php if ( get_theme_mod( 'footer_tagline', 1 ) == 1 ): ?>
								<p class="tagline"><?php bloginfo( 'description' ); ?></p>
							<?php endif; ?>
						</div><!-- /site-logo -->
						<?php if ( ! empty( get_theme_mod( 'footer_copy', '' ) ) ) : ?>
							<p class="footer-copy"><?php echo wp_kses( get_theme_mod( 'footer_copy', '' ), olsen_get_allowed_tags( 'guide' ) ); ?></p>
						<?php endif; ?>
					</footer><!-- /footer -->
				<?php endif; ?>
			</div><!-- /col-md-12 -->
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- #page -->

<div class="navigation-mobile-wrap">
	<a href="#nav-dismiss" class="navigation-mobile-dismiss">
		<?php esc_html_e( 'Close Menu', 'olsen' ); ?>
	</a>
	<ul class="navigation-mobile"></ul>
</div>

<?php wp_footer(); ?>


</body>
</html>
