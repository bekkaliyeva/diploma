<?php
$wpc->add_setting(
	'single_categories',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_categories',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show categories.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_tags',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_tags',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show tags.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_brands',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_brands',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show brands.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_date',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_date',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show date.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_comments',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_comments',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show comments.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_featured',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_featured',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show featured media.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_signature',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_signature',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show signature.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_social_sharing',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_social_sharing',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show social sharing buttons.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_nextprev',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_nextprev',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show next/previous post links.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_authorbox',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_authorbox',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show author box.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_related',
	array(
		'default'           => 1,
		'sanitize_callback' => 'olsen_sanitize_checkbox',
	)
);
$wpc->add_control(
	'single_related',
	array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => __( 'Show related posts.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_related_title',
	array(
		'default'           => __( 'You may also like', 'olsen' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wpc->add_control(
	'single_related_title',
	array(
		'type'    => 'text',
		'section' => 'single_post',
		'label'   => __( 'Related Posts section title', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_affiliate_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wpc->add_control(
	'single_affiliate_title',
	array(
		'type'        => 'text',
		'section'     => 'single_post',
		'label'       => __( 'Affiliate disclosure link text', 'olsen' ),
		'description' => __( 'If you promote products through affiliations, in some countries, you must provide a full disclosure about it. Use the following fields to create a link to your affiliate disclosure page. This link will appear at the very bottom of each post.', 'olsen' ),
	)
);

$wpc->add_setting(
	'single_affiliate_link',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wpc->add_control(
	'single_affiliate_link',
	array(
		'type'    => 'url',
		'section' => 'single_post',
		'label'   => __( 'Affiliate disclosure link', 'olsen' ),
	)
);
