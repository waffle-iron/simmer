<?php
/**
 * Set up the front-end
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Front_End
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Front_End_Loader {
	
	/**
	 * Get the loader running.
	 * 
	 * @since 1.2.0
	 */
	public function load() {
		
		// Load the necessary files.
		$this->load_files();
		
		// Add the necessary actions.
		$this->add_actions();
		
		// Add the necessary filters.
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
		 * The all-important template loader.
		 */
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-template-loader.php' );
		
		/**
		 * The HTML classes class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-front-end-classes.php' );
		
		/**
		 * The CSS styles class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-front-end-styles.php' );
		
		/**
		 * The supporting functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'functions.php' );
		
		/**
		 * The supporting template functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'template-functions.php' );
	}
	
	/**
	 * Add the necessary actions.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function add_actions() {
		
		/**
		 * Set up the styles.
		 */
		$styles = new Simmer_Front_End_Styles();
		
		// Check if front-end styles should be enqueued.
		if ( $styles->enable_styles() ) {
			add_action( 'wp_enqueue_scripts', array( $styles, 'enqueue_styles' ) );
			add_action( 'wp_head', array( $styles, 'add_custom_styles' ) );
		}
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
