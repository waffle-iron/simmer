<?php

class Simmer_Categories_Widget extends WP_Widget {
	
	/**
	 * Unique identifier for the widget.
	 *
	 * @since 1.0.3
	 *
	 * @var string
	 */
	protected $widget_slug = 'recipe-categories';
	
	public function __construct() {
		
		parent::__construct(
			$this->widget_slug,
			__( 'Recipe Categories', Simmer::SLUG ),
			array(
				'classname'   => $this->widget_slug . '-class',
				'description' => __( 'A list of recipe categories', Simmer::SLUG ),
			)
		);
		
	}
	
	public function widget( $args, $instance ) {
		
		if ( ! isset ( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		
		echo $args['before_widget'];
		
		if ( $title = $instance['title'] ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		$list_args = array(
			'show_count'   => $instance['show_count'],
			'hierarchical' => $instance['hierarchical'],
			'title_li'     => false,
		);
		
		$list_args = apply_filters( 'simmer_category_widget_list_args', $list_args, $args['widget_id'] );
		
		$list_args['taxonomy'] = simmer_get_category_taxonomy();
		
		include( plugin_dir_path( __FILE__ ) . 'html/categories-widget.php' );
		
		echo $args['after_widget'];
		
	}
	
	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['show_count']   = ! empty( $new_instance['show_count']   ) ? true : false;
		$instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? true : false;
		
		return $instance;
		
	}
	
	public function form( $instance ) {
		
		$defaults = array(
			'title'        => '',
			'show_count'   => false,
			'hierarchical' => false,
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		include( plugin_dir_path( __FILE__ ) . 'html/categories-widget-form.php' );
		
	}
	
}
