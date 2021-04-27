<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

require_once get_theme_file_path( '/inc/elementor/inc/elementor-helper.php' );
require_once get_theme_file_path( '/inc/elementor/inc/olsen-element-common-functions.php' );

/**
 * Olsen Elementor related code.
 */
add_action( 'elementor/init', 'Elementor\olsen_elementor_init' );
function olsen_elementor_init() {
	Plugin::instance()->elements_manager->add_category(
		'olsen-elements',
		[
			'title' => __( 'Olsen Elements', 'olsen' ),
			'icon'  => 'font',
		]
	);
}

add_action( 'elementor/widgets/widgets_registered', 'Elementor\olsen_elementor_add_elements' );
function olsen_elementor_add_elements() {

	require_once get_theme_file_path( '/inc/elementor/olsen-element.php' );
	Plugin::instance()->widgets_manager->register_widget_type( new Olsen_Element() );

	require_once get_theme_file_path( '/inc/elementor/post-type.php' );
	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Post_Type() );
}

add_action( 'elementor/controls/controls_registered', 'Elementor\olsen_plugin_posts_register_control' );
function olsen_plugin_posts_register_control( $controls_manager ) {
	require_once get_theme_file_path( '/inc/elementor/inc/olsen-element-posts-group-control.php' );
	$controls_manager->add_group_control( 'olsen_element_posts', new Olsen_Element_Posts_Group_Control() );
}

add_action( 'elementor/frontend/before_enqueue_scripts', 'Elementor\olsen_element_scripts' );
function olsen_element_scripts() {
	$theme  = wp_get_theme();
	$suffix = olsen_scripts_styles_suffix();

	wp_enqueue_script( 'olsen-elementor', get_template_directory_uri() . "/js/admin/olsen-elementor{$suffix}.js", array(), $theme->get( 'Version' ), true );
}
