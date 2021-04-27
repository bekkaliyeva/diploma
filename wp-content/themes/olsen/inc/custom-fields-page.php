<?php
	add_action( 'admin_init', 'olsen_cpt_page_add_metaboxes' );
	add_action( 'save_post', 'olsen_cpt_page_update_meta' );

	function olsen_cpt_page_add_metaboxes() {
		add_meta_box( 'ci-tpl-looks-box', __( 'Looks Details', 'olsen' ), 'olsen_add_cpt_page_looks_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'ci-tpl-blank-box', __( 'Distraction Free Details', 'olsen' ), 'olsen_add_cpt_page_blank_meta_box', 'page', 'normal', 'high' );
	}

	function olsen_cpt_page_update_meta( $post_id ) {

		if ( ! olsen_can_save_meta( 'page' ) ) {
			return;
		}

		update_post_meta( $post_id, 'looks_base_category', intval( $_POST['looks_base_category'] ) );
		update_post_meta( $post_id, 'looks_posts_per_page', olsen_sanitize_intval_or_empty( $_POST['looks_posts_per_page'] ) );
		update_post_meta( $post_id, 'looks_layout', in_array( $_POST['looks_layout'], array( '2cols_side', '3cols_full' ) ) ? $_POST['looks_layout'] : '2cols_side' );

		update_post_meta( $post_id, 'blank_template_padding', olsen_sanitize_checkbox_ref( $_POST['blank_template_padding'] ) );
	}

	function olsen_add_cpt_page_looks_meta_box( $object, $box ) {
		olsen_prepare_metabox( 'page' );

		?><div class="ci-cf-wrap"><?php
			olsen_metabox_open_tab( '' );

				$options = array(
					'2cols_side' => __( '2 Columns - With sidebar', 'olsen' ),
					'3cols_full' => __( '3 Columns - Full width', 'olsen' ),
				);
				olsen_metabox_dropdown( 'looks_layout', $options, __( 'Layout:', 'olsen' ), array( 'default' => '2cols_side' ) );

				$category = get_post_meta( $object->ID, 'looks_base_category', true );
				olsen_metabox_guide( __( "Select a base category. Only items from the selected category and sub-categories will be displayed. If you don't select one (i.e. empty) all items will be shown.", 'olsen' ) );
				?><p><label for="base_looks_category"><?php _e( 'Base Looks category:', 'olsen' ); ?></label><?php
				wp_dropdown_categories( array(
					'taxonomy'          => 'category',
					'selected'          => $category,
					'id'                => 'looks_base_category',
					'name'              => 'looks_base_category',
					'show_option_none'  => ' ',
					'option_none_value' => 0,
					'hierarchical'      => 1,
					'show_count'        => 1,
				) );
				?><p><?php

				olsen_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <em>all items</em>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings > Reading</em>, currently set to <strong>%s items per page</strong>.', 'olsen' ), get_option( 'posts_per_page' ) ) );
				olsen_metabox_input( 'looks_posts_per_page', __( 'Items per page:', 'olsen' ) );

			olsen_metabox_close_tab();
		?></div><?php

		olsen_bind_metabox_to_page_template( 'ci-tpl-looks-box', 'template-listing-looks.php', 'tpl_looks' );
	}

	function olsen_add_cpt_page_blank_meta_box( $object, $box ) {
		olsen_prepare_metabox( 'page' );

		?><div class="ci-cf-wrap"><?php
			olsen_metabox_open_tab( '' );

				olsen_metabox_checkbox( 'blank_template_padding', 1, esc_html__( 'Disable top and bottom padding for this page', 'olsen' ) );

			olsen_metabox_close_tab();
		?></div><?php

		olsen_bind_metabox_to_page_template( 'ci-tpl-blank-box', 'template-blank.php', 'tpl_blank' );
	}