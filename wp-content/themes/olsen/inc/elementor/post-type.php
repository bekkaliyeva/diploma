<?php
namespace Elementor;

class Widget_Post_Type extends Widget_Base {

	use \Elementor\ElementsCommonFunctions;

	public function get_name() {
		return 'post_type_widget';
	}

	public function get_title() {
		return __( 'Olsen Post Type', 'olsen' );
	}

	public function get_icon() {
		return 'eicon-wordpress';
	}

	public function get_categories() {
		return [ 'olsen-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Olsen Post Type', 'olsen' ),
			]
		);

		$this->add_control(
			'html_msg',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Display any post type item from Olsen by first selecting the post type and then the item itself.', 'olsen' ),
				'content_classes' => 'ci-description',
			]
		);

		$this->add_control(
			'post_types',
			[
				'label'   => __( 'Post Type', 'olsen' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => Olsen_Element_Helper::element_post_types(),
			]
		);

		foreach ( Olsen_Element_Helper::element_post_types() as $slug => $name ) {
			$this->add_control(
				'selected_post_' . $slug,
				[
					'label'     => $name,
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => Olsen_Element_Helper::get_all_post_type_items( $slug ),
					'condition' => [
						'post_types' => $slug,
					],
				]
			);
		}

		$this->appearance_controls( 'post_types' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title Styles', 'olsen' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_text_color',
			[
				'label'     => __( 'Text Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .entry-title a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label' => __( 'Excerpt Styles', 'olsen' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'excerpt_text_color',
			[
				'label'     => __( 'Text Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .entry-content, {{WRAPPER}} .entry-content p' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .entry-content, {{WRAPPER}} .entry-content p',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => __( 'Meta Styles', 'olsen' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_types' => [ 'post', 'product' ],
				],
			]
		);

		$this->add_control(
			'meta_text_color',
			[
				'label'     => __( 'Text Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .entry-meta, {{WRAPPER}} .entry-meta .entry-categories a' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .entry-meta, {{WRAPPER}} .entry-meta .entry-categories a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_socials',
			[
				'label' => __( 'Socials Styles', 'olsen' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'socials_color',
			[
				'label'     => __( 'Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .socials a' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'socials_color_hover',
			[
				'label'     => __( 'Hover Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .socials a:hover' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'olsen' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'olsen' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.btn, {{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.btn, {{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'olsen' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.btn:hover, {{WRAPPER}} .btn:hover, {{WRAPPER}} .button:hover, {{WRAPPER}} .read-more:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.btn:hover, {{WRAPPER}} .btn:hover, {{WRAPPER}} .button:hover, {{WRAPPER}} .read-more:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'olsen' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.btn:hover, {{WRAPPER}} .btn:hover, {{WRAPPER}} .button:hover, {{WRAPPER}} .read-more:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'olsen' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'olsen' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .btn, {{WRAPPER}} .button, {{WRAPPER}} .read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$post_type  = $settings['post_types'];
		$post_id_bc = isset( $settings['selected_post'] ) ? $settings['selected_post'] : false;
		$post_id    = $settings[ 'selected_post_' . $post_type ] ? $settings[ 'selected_post_' . $post_type ] : $post_id_bc;

		if ( empty( $post_id ) ) {
			return;
		}

		$q = new \WP_Query( array(
			'post_type' => get_post_type( $post_id ),
			'p'         => $post_id,
		) );

		while ( $q->have_posts() ) : $q->the_post();
			$template_path = 'elementor-item.php';

			include locate_template( $template_path, false, false );
		endwhile;

		wp_reset_postdata();
	}

}
