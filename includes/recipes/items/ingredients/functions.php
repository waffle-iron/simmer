<?php
/**
 * Supporting functions for ingredients.
 *
 * @since 1.0.0
 *
 * @package Simmer/Recipes/Items/Ingredients
 */

// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get a specific ingredient.
 * 
 * @since 1.0.0
 * 
 * @param  int    $ingredient_id The ingredient item ID.
 * @return object $ingredient    The single ingredient item.
 */
function simmer_get_ingredient( $ingredient_id ) {
	
	$ingredient = new Simmer_Recipe_Ingredient( $ingredient_id );
	
	return $ingredient;
}
