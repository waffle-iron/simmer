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
	
	/**
	 * Post types that allow the shortcode UI.
	 * 
	 * @since 1.2.0
	 * 
	 * @var array $supported_post_types
	 */
	public $supported_post_types;
	
	/**
	 * Construct the class.
	 * 
	 * @since 1.2.0
	 */
	public function __construct() {
		
		// Set the default supported post types.
		$this->supported_post_types = array(
			'post',
			'page',
		);
		
		// Add the necessary action hooks.
		$this->add_actions();
	}
	
	/**
	 * Add the necessary action hooks.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function add_actions() {
		
		add_action( 'media_buttons', array( $this, 'add_media_button' ), 99 );
	}
	
	/**
	 * Add the 'Add Recipe' button above the main content editor.
	 * 
	 * @since 1.2.0
	 * 
	 * @param string $editor_id The TinyMCE editor ID.
	 */
	public function add_media_button( $editor_id = 'content' ) {
		
		if ( ! in_array( get_post_type(), $this->get_supported_post_types() ) ) {
			return;
		}
		
		printf( '<a href="#" id="simmer-add-recipe" class="simmer-icon-fork button" data-editor="%s" data-object-id="%s" title="%s">%s</a>',
			esc_attr( $editor_id ),
			esc_attr( get_the_ID() ),
			esc_attr__( 'Add Recipe', Simmer::SLUG ),
			esc_html__( 'Add Recipe', Simmer::SLUG )
		);
	}
	
	/**
	 * Get the post types supported by the shortcode UI.
	 * 
	 * @since  1.2.0
	 * @access private
	 * 
	 * @return array $supported_post_types The filtered post types array.
	 */
	private function get_supported_post_types() {
		
		/**
		 * Filter the list of supported post types.
		 * 
		 * @since 1.2.0
		 */
		$supported_post_types = apply_filters( 'simmer_admin_shortcode_ui_post_types', $this->supported_post_types );
		
		return (array) $supported_post_types;
	}
}
