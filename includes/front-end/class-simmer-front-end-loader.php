<?php
/**
 * Set up the front-end
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Front_End
 */

class Simmer_Front_End_Loader {
	
	/**
	 * Get the loader running.
	 * 
	 * @since 1.2.0
	 */
	public function load() {
		
		$this->load_files();
		
		$this->add_filters();
	}
	
	/**
	 * Load the necessary files.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function load_files() {
		
		/**
		 * The HTML classes class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-front-end-classes.php' );
	}
	
	/**
	 * Add the necessary filters.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function add_filters() {
		
		/**
		 * Setup the HTML classes.
		 */
		$html_classes = new Simmer_Front_End_Classes();
		add_filter( 'body_class', array( $html_classes, 'add_body_classes' ), 20, 1 );
		add_filter( 'post_class', array( $html_classes, 'add_recipe_classes' ), 20, 3 );
		
	}
}
