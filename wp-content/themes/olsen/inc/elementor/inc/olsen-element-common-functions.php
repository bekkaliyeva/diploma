<?php
namespace Elementor;

use Elementor\Group_Control_Base;

trait ElementsCommonFunctions {

	/**
	 * For Exclude Option
	 */
	public function add_exclude_controls() {
		$this->add_control(
			'post__not_in',
			[
				'label'       => __( 'Exclude', 'olsen' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Olsen_Element_Helper::get_all_post_type_items(),
				'label_block' => true,
				'post_type'   => '',
				'multiple'    => true,
				'condition'   => [
					'olsen_element_posts_post_type!' => 'by_id',
				],
			]
		);
	}

	protected function query_controls() {

		$this->add_group_control(
			Olsen_Element_Posts_Group_Control::get_type(),
			[
				'name' => 'olsen_element_posts',
			]
		);

		$this->add_exclude_controls();

		$this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Posts Per Page', 'olsen' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '4',
				'condition' => [
					'olsen_element_posts_post_type!' => 'by_id',
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'     => __( 'Offset', 'olsen' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '0',
				'condition' => [
					'olsen_element_posts_post_type!' => 'by_id',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order By', 'olsen' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Olsen_Element_Helper::get_post_orderby_options(),
				'default' => 'date',

			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'olsen' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => 'Ascending',
					'desc' => 'Descending',
				],
				'default' => 'desc',

			]
		);

	}

	protected function appearance_controls( $pt_source ) {
		$this->add_control(
			'show_post_meta',
			[
				'label'        => __( 'Show Post Meta', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					$pt_source => [ 'post', 'by_id' ],
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => __( 'Show Title', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label'        => __( 'Show Featured Media', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => __( 'Show Excerpt', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => __( 'Show Button', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_social_sharing',
			[
				'label'        => __( 'Show Social Sharing', 'olsen' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'olsen' ),
				'label_off'    => __( 'Hide', 'olsen' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
	}

}
