<?php
$choices = array(
	'classic_2side'       => _x( 'Classic - Two Sidebars', 'page layout', 'olsen' ),
	'classic_2side_right' => _x( 'Classic - Two Sidebars on the Right', 'page layout', 'olsen' ),
	'classic_1side'       => _x( 'Classic - One Sidebar', 'page layout', 'olsen' ),
	'classic_full'        => _x( 'Classic - Full width', 'page layout', 'olsen' ),
	'small_side'          => _x( 'Small images - Sidebar', 'page layout', 'olsen' ),
	'small_full'          => _x( 'Small images - Full width', 'page layout', 'olsen' ),
	'small_full_narrow'   => _x( 'Small images - Full width narrow', 'page layout', 'olsen' ),
	'2cols_side'          => _x( 'Two columns - Sidebar', 'page layout', 'olsen' ),
	'2cols_full'          => _x( 'Two columns - Full width', 'page layout', 'olsen' ),
	'2cols_narrow'        => _x( 'Two columns - Narrow - Full width', 'page layout', 'olsen' ),
	'2cols_masonry'       => _x( 'Two columns - Masonry - Sidebar', 'page layout', 'olsen' ),
	'3cols_full'          => _x( 'Three columns - Full width', 'page layout', 'olsen' ),
	'3cols_masonry'       => _x( 'Three columns - Masonry - Full width', 'page layout', 'olsen' ),
);
$wpc->add_setting(
	'layout_blog',
	array(
		'default'           => 'classic_2side',
		'sanitize_callback' => 'olsen_sanitize_blog_terms_layout',
	)
);
$wpc->add_control(
	'layout_blog',
	array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Blog layout', 'olsen' ),
		'description' => __( 'Applies to the home page and blog-related pages.', 'olsen' ),
		'choices'     => $choices,
	)
);

$wpc->add_setting(
	'layout_terms',
	array(
		'default'           => 'classic_2side',
		'sanitize_callback' => 'olsen_sanitize_blog_terms_layout',
	)
);
$wpc->add_control(
	'layout_terms',
	array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Categories and Tags layout', 'olsen' ),
		'description' => __( 'Applies to the categories and tags listing pages.', 'olsen' ),
		'choices'     => $choices,
	)
);

$wpc->add_setting(
	'layout_other',
	array(
		'default'           => 'side',
		'sanitize_callback' => 'olsen_sanitize_other_layout',
	)
);
$wpc->add_control(
	'layout_other',
	array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => __( 'Other Pages layout', 'olsen' ),
		'description' => __( 'Applies to all other pages, e.g. 404 page, etc.', 'olsen' ),
		'choices'     => array(
			'side' => _x( 'With sidebar', 'page layout', 'olsen' ),
			'full' => _x( 'Full width', 'page layout', 'olsen' ),
		),
	)
);

$wpc->add_setting(
	'excerpt_length',
	array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
	)
);
$wpc->add_control(
	'excerpt_length',
	array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'step' => 1,
		),
		'section'     => 'layout',
		'label'       => __( 'Automatically generated excerpt length (in words)', 'olsen' ),
	)
);

$wpc->add_setting(
	'excerpt_on_classic_layout',
	array(
		'default'           => '',
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'excerpt_on_classic_layout',
	array(
		'type'    => 'checkbox',
		'section' => 'layout',
		'label'   => __( 'Display the excerpt on classic blog layouts.', 'olsen' ),
	)
);

$wpc->add_setting(
	'pagination_method',
	array(
		'default'           => 'numbers',
		'sanitize_callback' => 'olsen_sanitize_pagination_method',
	)
);
$wpc->add_control(
	'pagination_method',
	array(
		'type'    => 'select',
		'section' => 'layout',
		'label'   => __( 'Pagination method', 'olsen' ),
		'choices' => array(
			'numbers' => _x( 'Numbered links', 'pagination method', 'olsen' ),
			'text'    => _x( '"Previous - Next" links', 'pagination method', 'olsen' ),
		),
	)
);

$wpc->add_setting(
	'blog_related',
	array(
		'default'           => 0,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'blog_related',
	array(
		'type'    => 'checkbox',
		'section' => 'layout',
		'label'   => __( 'Show related posts in blog listing. Applies to classic layouts only.', 'olsen' ),
	)
);

$wpc->add_setting(
	'blog_related_title',
	array(
		'default'           => __( 'You may also like', 'olsen' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wpc->add_control(
	'blog_related_title',
	array(
		'type'    => 'text',
		'section' => 'layout',
		'label'   => __( 'Blog Related Posts section title.', 'olsen' ),
	)
);
