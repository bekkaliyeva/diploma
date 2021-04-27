<?php
	add_action( 'init', 'olsen_create_brands_taxonomy', 0 );

	function olsen_create_brands_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Brands', 'taxonomy general name', 'olsen' ),
			'singular_name'              => _x( 'Brand', 'taxonomy singular name', 'olsen' ),
			'search_items'               => __( 'Search Brands', 'olsen' ),
			'popular_items'              => __( 'Popular Brands', 'olsen' ),
			'all_items'                  => __( 'All Brands', 'olsen' ),
			'parent_item'                => __( 'Parent Brand', 'olsen' ),
			'parent_item_colon'          => __( 'Parent Brand:', 'olsen' ),
			'edit_item'                  => __( 'Edit Brand', 'olsen' ),
			'update_item'                => __( 'Update Brand', 'olsen' ),
			'add_new_item'               => __( 'Add New Brand', 'olsen' ),
			'new_item_name'              => __( 'New Brand Name', 'olsen' ),
			'separate_items_with_commas' => __( 'Separate brands with commas', 'olsen' ),
			'add_or_remove_items'        => __( 'Add or remove brands', 'olsen' ),
			'choose_from_most_used'      => __( 'Choose from the most used brands', 'olsen' ),
			'not_found'                  => __( 'No brands found.', 'olsen' ),
			'menu_name'                  => __( 'Brands', 'olsen' ),
			'view_name'                  => __( 'View Brand', 'olsen' ),
		);

		register_taxonomy( 'brand', 'post', array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => _x( 'brands', 'taxonomy slug', 'olsen' ) ),
		) );
	}
