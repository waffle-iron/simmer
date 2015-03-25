<?php
/**
 * Define the front-end scripts class
 * 
 * @since 1.2.1
 * 
 * @package Simmer/FrontEnd
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Frontend_Scripts {
	
	/**
	 * Enqueue the front-end scripts.
	 * 
	 * @since 1.2.1
	 */
	public function enqueue_scripts() {
		
		// Register the PrintThis script.
		wp_register_script( 'simmer-print-this', plugin_dir_url( __FILE__ ) . 'assets/print-this.js', array(
			'jquery',
		), '1.5.0', true );
		
		// The main front-end scripts.
		wp_enqueue_script( 'simmer-plugin-scripts', plugin_dir_url( __FILE__ ) . 'assets/simmer-scripts.js', array(
			'jquery',
			'simmer-print-this',
		), Simmer::VERSION, true );
	}
	
	/**
	 * Determine if the scripts should be enqueued.
	 * 
	 * @since 1.2.1
	 * 
	 * @return bool $enable_scripts Whether the scripts should be enabled.
	 */
	public function enable_scripts() {
		
		$enable_scripts = true;
		
		/**
		 * Filter whether the scripts should be loaded.
		 * 
		 * @since 1.2.1
		 * 
		 * @param bool $enable_scripts Whether the scripts are set to load.
		 */
		$enable_scripts = (bool) apply_filters( 'simmer_enable_scripts', $enable_scripts );
		
		return $enable_scripts;
	}
}
