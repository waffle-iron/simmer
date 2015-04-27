<?php
/**
 * Supporting functions for instructions.
 *
 * @since 1.3.0
 *
 * @package Simmer/Recipes/Items/Instructions
 */

/**
 * Get a specific instruction.
 * 
 * @since 1.3.0
 * 
 * @param  int    $instruction_id The instruction item ID.
 * @return object $instruction    The single instruction item.
 */
function simmer_get_instruction( $instruction_id ) {
	
	$instruction = new Simmer_Recipe_Instruction( $instruction_id );
	
	return $instruction;
}
