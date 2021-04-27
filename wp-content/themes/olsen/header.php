<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( get_theme_mod( 'site_socials' ) == 1 ) : ?>
	<div class="site-socials">
		<?php get_template_part( 'part', 'social-icons' ); ?>
	</div>
<?php endif; ?>

<div id="page">

	<?php if ( has_nav_menu( 'top_menu' ) ) :

		$mobile_empty = 1 !== get_theme_mod( 'topbar_searchform', 0 ) && 1 !== get_theme_mod( 'topbar_socials', 1 ) ? 'mobile-empty' : '';
	?>

		<div class="top-bar group <?php echo esc_attr( $mobile_empty ); ?>">
				<nav class="nav" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'top_menu',
						'container'      => '',
						'menu_id'        => '',
						'menu_class'     => 'navigation'
					) ); ?>
				</nav>

			<?php $has_search = get_theme_mod( 'topbar_searchform', 0 ); ?>

			<?php if ( get_theme_mod( 'topbar_searchform', 1 ) || get_theme_mod( 'topbar_socials', 1 ) ) : ?>
				<div class="site-tools <?php echo 1 === $has_search ? 'has-search' : ''; ?>">
					<?php if ( 1 === $has_search ) {
						get_search_form();
					} ?>

					<?php if ( 1 === get_theme_mod( 'topbar_socials', 1 ) ) {
						get_template_part( 'part-social-icons' );
					} ?>

				</div><!-- /site-tools -->
			<?php endif; ?>
		</div><!-- /top-bar -->
	<?php endif; ?>


	<?php if ( ! is_page_template( 'template-blank.php') ) : ?>
		<header id="masthead" class="site-header group">

			<div class="site-logo">
				<div>
					<a href="<?php echo esc_url( home_url() ); ?>">
						<?php if ( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ): ?>
							<img src="<?php echo esc_url( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>"
									alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
						<?php else: ?>
							<?php bloginfo( 'name' ); ?>
						<?php endif; ?>
					</a>
				</div>

				<?php if ( get_bloginfo( 'description' ) ): ?>
					<p class="tagline"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div><!-- /site-logo -->

			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-bar group <?php echo get_theme_mod('header_sticky_menu') ? 'sticky-head' : ''; ?>">
							<nav class="nav" role="navigation">
								<?php wp_nav_menu( array(
									'theme_location' => 'main_menu',
									'container'      => '',
									'menu_id'        => '',
									'menu_class'     => 'navigation'
								) ); ?>

								<a class="mobile-nav-trigger" href="#mobilemenu"><i class="fa fa-navicon"></i> <?php esc_html_e( 'Menu', 'olsen' ); ?></a>
							</nav>
							<?php if ( has_nav_menu( 'mobile_menu' ) ) : ?>
								<nav class="mobile-nav-location" role="navigation">
									<?php wp_nav_menu( array(
										'theme_location' => 'mobile_menu',
										'container'      => '',
										'menu_id'        => '',
										'menu_class'     => 'mobile-navigation',
									) ); ?>
								</nav>
							<?php endif; ?>
							<div id="mobilemenu"></div>

							<?php $has_search = get_theme_mod( 'header_searchform', 0 ); ?>

							<div class="site-tools <?php echo $has_search === 1 ? 'has-search' : ''; ?>">
								<?php if ( $has_search == 1 ) {
									get_search_form();
								} ?>

								<?php if ( get_theme_mod( 'header_socials', 1 ) == 1 ) {
									get_template_part( 'part-social-icons' );
								} ?>

							</div><!-- /site-tools -->
						</div><!-- /site-bar -->
					</div>
				</div>
			</div>
		</header>
	<?php endif; ?>

	<?php if ( is_home() ) {
		get_template_part( 'part', 'slider' );
	} ?>

	<div class="container">
		<div class="row">
			<div class="col-12">

				<?php if ( is_active_sidebar( 'frontpage-widgets' ) && is_home() ) : ?>
					<div class="widgets-inset">
						<div class="row">
							<?php dynamic_sidebar( 'frontpage-widgets' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<div id="site-content">
