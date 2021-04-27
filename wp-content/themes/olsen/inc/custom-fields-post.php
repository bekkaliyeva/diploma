<?php
	add_action( 'admin_init', 'olsen_cpt_post_add_metaboxes' );
	add_action( 'save_post', 'olsen_cpt_post_update_meta' );

	function olsen_cpt_post_add_metaboxes() {
		add_meta_box( 'ci-layout-box', __( 'Post Utilities', 'olsen' ), 'olsen_add_cpt_post_layout_meta_box', 'post', 'normal', 'high' );
		add_meta_box( 'ci-gallery-box', __( 'Gallery Details', 'olsen' ), 'olsen_add_cpt_post_gallery_meta_box', 'post', 'normal', 'high' );
	}

	function olsen_cpt_post_update_meta( $post_id ) {

		if ( ! olsen_can_save_meta( 'post' ) ) {
			return;
		}

		update_post_meta( $post_id, 'layout', in_array( $_POST['layout'], array( 'sidebar', 'full', 'full_wide' ) ) ? $_POST['layout'] : '' );
		update_post_meta( $post_id, 'secondary_featured_id', intval( $_POST['secondary_featured_id'] ) );
		update_post_meta( $post_id, 'gallery_layout', in_array( $_POST['gallery_layout'], array( 'tiled', 'slider' ) ) ? $_POST['gallery_layout'] : '' );
		olsen_metabox_gallery_save( $_POST );
		update_post_meta( $post_id, 'post_disable_featured_image', olsen_sanitize_checkbox_ref( $_POST['post_disable_featured_image'] ) );
		update_post_meta( $post_id, 'post_disable_affiliate_link', olsen_sanitize_checkbox_ref( $_POST['post_disable_affiliate_link'] ) );
	}

	function olsen_add_cpt_post_layout_meta_box( $object, $box ) {
		olsen_prepare_metabox( 'post' );

		?><div class="ci-cf-wrap"><?php
			olsen_metabox_open_tab( __( 'Layout', 'olsen' ) );
				$options = array(
					'sidebar' => _x( 'With sidebar', 'post layout', 'olsen' ),
					'full'    => _x( 'Full width narrow', 'post layout', 'olsen' ),
					'full_wide'    => _x( 'Full width wide', 'post layout', 'olsen' ),
				);
				olsen_metabox_dropdown( 'layout', $options, __( 'Post layout:', 'olsen' ) );

				olsen_metabox_checkbox( 'post_disable_featured_image', 1, esc_html__( 'Hide the featured image of this post', 'olsen' ) );
				olsen_metabox_checkbox( 'post_disable_affiliate_link', 1, esc_html__( 'Hide the affiliate disclosure link (Set in Customizer > Posts Options)', 'olsen' ) );

			olsen_metabox_close_tab();

			olsen_metabox_open_tab( __( 'Secondary image', 'olsen' ) );
				olsen_metabox_guide( __( 'The <em>Looks</em> page template uses images in portrait (tall) orientation. If the Featured Image of this post is in landscape (wide) orientation, you may want to provide a portrait image to be used instead, otherwise an automatically cropped image (based on the Featured Image) will be used.', 'olsen' ) );

				$secondary_featured_id = get_post_meta( $object->ID, 'secondary_featured_id', true );
				?>
				<div class="ci-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $secondary_featured_id ) ): ?>
							<?php
								$image_url = olsen_get_image_src( $secondary_featured_id, 'ci_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( __('Remove image', 'olsen') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="ci-uploaded-id" name="secondary_featured_id" value="<?php echo esc_attr( $secondary_featured_id ); ?>" />
					<input type="button" class="button ci-media-button" value="<?php esc_attr_e( 'Select Image', 'olsen' ); ?>" />
				</div>
				<?php
			olsen_metabox_close_tab();
		?></div><?php
	}

	function olsen_add_cpt_post_gallery_meta_box( $object, $box ) {
		olsen_prepare_metabox( 'post' );

		?><div class="ci-cf-wrap"><?php
			olsen_metabox_open_tab( '' );
				$options = array(
					'tiled' => _x( 'Tiled', 'gallery layout', 'olsen' ),
					'slider'  => _x( 'Slider', 'gallery layout', 'olsen' ),
				);
				olsen_metabox_dropdown( 'gallery_layout', $options, __( 'Gallery layout:', 'olsen' ) );

				olsen_metabox_gallery();
			olsen_metabox_close_tab();
		?></div><?php

		olsen_bind_metabox_to_post_format( 'ci-gallery-box', 'gallery', 'mb_format_gallery_box' );
	}
