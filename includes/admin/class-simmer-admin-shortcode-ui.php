<?php
/**
 * Define the admin shortcode functionality
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Admin
 */

// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Admin_Shortcode_UI {
	
	public function __construct() {
		
		$this->add_actions();
	}
	
	private function add_actions() {
		
		add_action( 'media_buttons', array( $this, 'add_media_button' ), 99 );
	}
	
	public function add_media_button( $editor_id = 'content' ) {
		
		$post = get_post();
		
		if ( ! $post && ! empty( $GLOBALS['post_ID'] ) ) {
			$post = $GLOBALS['post_ID'];
		}
		
		wp_enqueue_media( array(
			'post' => $post,
		) );
		
		printf( '<a href="#" id="simmer-add-recipe" class="simmer-icon-fork button" data-editor="%s" title="%s">%s</a>',
			esc_attr( $editor_id ),
			esc_attr__( 'Add Recipe', Simmer::SLUG ),
			esc_html__( 'Add Recipe', Simmer::SLUG )
		);
	}
}
