<?php
add_action( 'widgets_init', 'olsen_widgets_init' );
function olsen_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html_x( 'Blog', 'widget area', 'olsen' ),
			'id'            => 'blog',
			'description'   => __( 'This is the main sidebar.', 'olsen' ),
			'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html_x( 'Blog - Left', 'widget area', 'olsen' ),
			'id'            => 'blog-left',
			'description'   => __( 'Widgets assigned here only appear on the two sidebar blog layout', 'olsen' ),
			'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html_x( 'Pages', 'widget area', 'olsen' ),
			'id'            => 'page',
			'description'   => __( 'This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'olsen' ),
			'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html_x( 'Footer Sidebar', 'widget area', 'olsen' ),
			'id'            => 'footer-widgets',
			'description'   => __( 'Special site-wide sidebar for the WP Instagram Widget plugin.', 'olsen' ),
			'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html_x( 'Frontpage Inset Widgets', 'widget area', 'olsen' ),
			'id'            => 'frontpage-widgets',
			'description'   => __( 'Widgets placed in this sidebar will appear below the frontpage slider.', 'olsen' ),
			'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop', 'olsen' ),
				'id'            => 'shop',
				'description'   => esc_html__( 'Widgets added here will appear on the shop page.', 'olsen' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}

add_action( 'widgets_init', 'olsen_load_widgets' );
function olsen_load_widgets() {
	require get_template_directory() . '/inc/widgets/ci-about-me.php';
	require get_template_directory() . '/inc/widgets/ci-latest-posts.php';
	require get_template_directory() . '/inc/widgets/ci-socials.php';
	require get_template_directory() . '/inc/widgets/ci-newsletter.php';
	require get_template_directory() . '/inc/widgets/ci-callout.php';
}
