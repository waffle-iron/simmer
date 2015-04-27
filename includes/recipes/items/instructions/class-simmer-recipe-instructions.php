<?php
/**
 * Define the main instructions class
 * 
 * @since 1.3.0
 * 
 * @package Simmer/Recipes/Items/Instructions
 */

/**
 * The class that handles the specialty instructions funcitonality.
 * 
 * @since 1.3.0
 */
final class Simmer_Recipe_Instructions {
	
	/**
	 * Get the instructions list heading text.
	 *
	 * @since 1.3.0
	 *
	 * @return string $heading The instructions list heading text.
	 */
	public function get_list_heading() {
		
		$heading = get_option( 'simmer_instructions_list_heading', __( 'Instructions', Simmer::SLUG ) );
		
		/**
		 * Filter the instructions list heading text.
		 *
		 * @since 1.0.0
		 * 
		 * @param string $heading The instructions list heading text.
		 */
		$heading = apply_filters( 'simmer_instructions_list_heading', $heading );
		
		return $heading;
	}
	
	/**
	 * Get the instructions list type.
	 *
	 * @since 1.3.0
	 *
	 * @return string $type The instructions list type.
	 */
	function get_list_type() {
		
		$type = get_option( 'simmer_instructions_list_type', 'ol' );
		
		/**
		 * Filter the instructions list type.
		 *
		 * @since 1.0.0
		 * 
		 * @param string $type The instructions list type.
		 */
		$type = apply_filters( 'simmer_instructions_list_type', $type );
		
		return $type;
	}
	
	public function add_instruction( $description, $is_heading = false ) {
		
		
	}
}
