<?php
/**
 * Define the front-end supporting functions
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Front_End
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Retrieve a template part from the appropriate Simmer directory.
 *
 * @since 1.0.0
 *
 * @param string  $slug
 * @param string  $name Optional. Default null.
 * @param bool    $load Optional. Default true.
 *
 * @return string
 */
function simmer_get_template_part( $slug, $name = null, $load = true ) {
	
	$template_loader = new Simmer_Template_Loader();
	
	return $template_loader->get_template_part( $slug, $name, $load );
}

/**
 * Get the available recipe tools.
 * 
 * @since 1.2.1
 * 
 * @return array $tools The available recipe tools like print, share, etc...
 */
function simmer_get_recipe_tools() {
	
	$tool_factory = new Simmer_Frontend_Recipe_Tools();
	
	// Get the available tools.
	$tools = (array) $tool_factory->get_tools();
	
	$_tools = array();
	
	// Attach each tools slug to its cooresponding HTML.
	foreach ( $tools as $tool ) {
		
		$html = $tool_factory->get_tool_html( $tool );
		
		if ( $html ) {
			$_tools[ $tool ] = $tool_factory->get_tool_html( $tool );
		}
	}
	
	$tools = $_tools;
	
	return $tools;
}
