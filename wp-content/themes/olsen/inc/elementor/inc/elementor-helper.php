<?php
namespace Elementor;

class Olsen_Element_Helper {

	public static function get_query_args( $control_id, $settings ) {
		$defaults = [
			$control_id . '_post_type' => 'post',
			$control_id . '_posts_ids' => [],
			'orderby'                  => 'date',
			'order'                    => 'desc',
			'posts_per_page'           => 3,
			'offset'                   => 0,
		];

		$settings = wp_parse_args( $settings, $defaults );

		$post_type = $settings[ $control_id . '_post_type' ];

		$query_args = [
			'orderby'             => $settings['orderby'],
			'order'               => $settings['order'],
			'ignore_sticky_posts' => 1,
			'post_status'         => 'publish',
		];

		if ( 'by_id' === $post_type ) {
			$query_args['post_type'] = array_keys( self::element_post_types() );
			$query_args['post__in']  = $settings[ $control_id . '_posts_ids' ];

			if ( empty( $query_args['post__in'] ) ) {
				// If no selection - return an empty query
				$query_args['post__in'] = [ 0 ];
			}
		} else {
			$query_args['post_type']      = $post_type;
			$query_args['posts_per_page'] = $settings['posts_per_page'];

			$query_args['offset'] = $settings['offset'];

			$taxonomies = get_object_taxonomies( $post_type, 'objects' );

			$tax_query_args = array();
			// These will be joined conditionally to give the correct tax query.
			$selected_tax_args           = array();
			$product_visibility_tax_args = array();

			foreach ( $taxonomies as $object ) {
				$setting_key = $control_id . '_' . $object->name . '_ids';

				if ( ! empty( $settings[ $setting_key ] ) ) {
					$selected_tax_args[] = [
						'taxonomy' => $object->name,
						'field'    => 'term_id',
						'terms'    => $settings[ $setting_key ],
					];
				}
			}

			if ( count( $selected_tax_args ) > 1 ) {
				$selected_tax_args['relation'] = 'OR';
			}

			if ( 'product' === $post_type && taxonomy_exists( 'product_visibility' ) ) {
				$product_visibility_tax_args[] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'slug',
					'terms'    => array( 'exclude-from-catalog' ),
					'operator' => 'NOT IN',
				);
			}

			if ( count( $selected_tax_args ) >= 1 && count( $product_visibility_tax_args ) >= 1 ) {
				$tax_query_args = array(
					'relation' => 'AND',
					$selected_tax_args,
					$product_visibility_tax_args,
				);
			} elseif ( count( $selected_tax_args ) >= 1 ) {
				$tax_query_args = $selected_tax_args;
			} elseif ( count( $product_visibility_tax_args ) >= 1 ) {
				$tax_query_args = $product_visibility_tax_args;
			}

			if ( count( $tax_query_args ) >= 1 ) {
				$query_args['tax_query'] = $tax_query_args;
			}
		}

		if ( ! empty( $settings[ $control_id . '_authors' ] ) ) {
			$query_args['author__in'] = $settings[ $control_id . '_authors' ];
		}

		$post__not_in = [];
		if ( ! empty( $settings['post__not_in'] ) ) {
			$post__not_in               = array_merge( $post__not_in, $settings['post__not_in'] );
			$query_args['post__not_in'] = $post__not_in;
		}

		return $query_args;
	}

	/**
	 * Get All Post Types
	 *
	 * @return array
	 */
	public static function element_post_types() {
		$return = 'objects';

		$cpts = get_post_types( array(
			'public'            => true,
			'show_in_nav_menus' => true,
		), $return );

		$excluded_cpts = apply_filters( 'olsen_plugin_element_excluded_cpts', array(
			'elementor_library',
			'attachment',
		) );

		foreach ( $excluded_cpts as $excluded_cpt ) {
			unset( $cpts[ $excluded_cpt ] );
		}

		$post_types = array_merge( $cpts );

		$post_types = apply_filters( 'olsen_plugin_element_post_types_dropdown', $post_types, __CLASS__, $excluded_cpts, $return );

		$types = wp_list_pluck( $post_types, 'label', 'name' );

		return $types;
	}

	/**
	 * Get all types of post.
	 *
	 * @return array
	 */
	public static function get_all_post_type_items( $post_type = 'any' ) {
		$posts_args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => '-1',
		);

		$posts = new \WP_Query( $posts_args );

		$post_list = wp_list_pluck( $posts->posts, 'post_title', 'ID' );

		return $post_list;
	}

	/**
	 * Post Orderby Options
	 *
	 * @return array
	 */
	public static function get_post_orderby_options() {
		$orderby = array(
			'ID'            => __( 'Post ID', 'olsen' ),
			'author'        => __( 'Post Author', 'olsen' ),
			'title'         => __( 'Title', 'olsen' ),
			'date'          => __( 'Date', 'olsen' ),
			'modified'      => __( 'Last Modified Date', 'olsen' ),
			'parent'        => __( 'Parent Id', 'olsen' ),
			'rand'          => __( 'Random', 'olsen' ),
			'comment_count' => __( 'Comment Count', 'olsen' ),
			'menu_order'    => __( 'Menu Order', 'olsen' ),
		);

		return apply_filters( 'olsen_plugin_element_orderby_options', $orderby );
	}

}
