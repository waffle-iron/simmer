<?php
/**
 * Define the tools class for print, share, etc...
 * 
 * @since 1.2.1
 * 
 * @package Simmer/Frontend/Tools
 */

/**
 * Sets up the recipe template tools like 'print'.
 * 
 * @since 1.2.1
 */
class Simmer_Frontend_Recipe_Tools {
	
	/**
	 * Stores the available tools.
	 * 
	 * @since 1.2.1
	 * 
	 * @var array $tools The available recipe tools.
	 */
	public $tools;
	
	/**
	 * Construct the class.
	 * 
	 * @since 1.2.1
	 */
	function __construct() {
		
		$this->tools = array(
			'print'
		);
	}
	
	/**
	 * Get the available recipe tools.
	 * 
	 * @since 1.2.1
	 * 
	 * @return array $tools The available recipe tools.
	 */
	public function get_tools() {
		
		/**
		 * Filter the available tools.
		 * 
		 * Use in conjuction with 'simmer_recipe_tool_html' to add custom
		 * recipe tools for display.
		 * 
		 * @since 1.2.1
		 */
		$tools = (array) apply_filters( 'simmer_recipe_tools', $this->tools );
		
		return $tools;
	}
	
	/**
	 * Get a single tool's HTML for display.
	 * 
	 * @since 1.2.1
	 * 
	 * @param  string $tool A single tool slug.
	 * @return string $html The single tool's HTML.
	 */
	public function get_tool_html( $tool ) {
		
		switch ( $tool ) {
			
			case 'print' :
				
				$html = '<a href="#">' . __( 'Print', Simmer::SLUG ) . '</a>';
				
				break;
			
			default :
				
				$html = false;
		}
		
		/**
		 * Filter a recipe tool's HTML.
		 * 
		 * Use in conjuction with 'simmer_recipe_tools' to add custom
		 * recipe tools for display.
		 * 
		 * @since 1.2.1
		 * 
		 * @param string $tool The single tool slug.
		 */
		$html = apply_filters( 'simmer_recipe_tool_html', $html, $tool );
		
		return $html;
	}
}
