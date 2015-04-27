<?php
/**
 * Define the main ingredients class
 * 
 * @since 1.3.0
 * 
 * @package Simmer/Recipes/Items/Ingredients
 */

/**
 * The class that handles the specialty ingredients funcitonality.
 * 
 * @since 1.3.0
 */
final class Simmer_Recipe_Ingredients {
	
	/**
	 * Get the ingredients list heading text.
	 *
	 * @since 1.3.0
	 *
	 * @return string $heading The ingredients list heading text.
	 */
	public function get_list_heading() {
		
		$heading = get_option( 'simmer_ingredients_list_heading', __( 'Ingredients', Simmer::SLUG ) );
		
		/**
		 * Allow others to filter the ingredients list heading text.
		 *
		 * @since 1.0.0
		 * 
		 * @param string $heading The ingredients list heading text.
		 */
		$heading = apply_filters( 'simmer_ingredients_list_heading', $heading );
		
		return $heading;
	}
	
	/**
	 * Get the ingredients list type.
	 *
	 * @since 1.3.0
	 *
	 * @return string $type The ingredients list type.
	 */
	function get_list_type() {
		
		$type = get_option( 'simmer_ingredients_list_type', 'ul' );
		
		/**
		 * Allow others to filter the ingredients list type.
		 *
		 * @since 1.0.0
		 * 
		 * @param string $type The ingredients list type.
		 */
		$type = apply_filters( 'simmer_ingredients_list_type', $type );
		
		return $type;
	}
	
	public function add_ingredient( $amount = '', $unit = '', $description ) {
		
		
	}
	
	/**
	 * Get the available units of measure.
	 *
	 * @since 1.3.0
	 *
	 * @return array $units The filtered units.
	 */
	public static function get_units() {
		
		$units = array(
			'volume' => array(
				'tsp' => array(
					'single' => 'teaspoon',
					'plural' => 'teaspoons',
					'abbr'   => 'tsp.',
				),
				'tbsp' => array(
					'single' => 'tablespoon',
					'plural' => 'tablespoons',
					'abbr'   => 'tbsp.',
				),
				'floz' => array(
					'single' => 'fluid ounce',
					'plural' => 'fluid ounces',
					'abbr'   => 'fl oz',
				),
				'cup' => array(
					'single' => 'cup',
					'plural' => 'cups',
					'abbr'   => 'c',
				),
				'pint' => array(
					'single' => 'pint',
					'plural' => 'pints',
					'abbr'   => 'pt',
				),
				'quart' => array(
					'single' => 'quart',
					'plural' => 'quarts',
					'abbr'   => 'qt',
				),
				'gal' => array(
					'single' => 'gallon',
					'plural' => 'gallons',
					'abbr'   => 'gal',
				),
				'ml' => array(
					'single' => 'milliliter',
					'plural' => 'milliliters',
					'abbr'   => 'mL',
				),
				'liter' => array(
					'single' => 'liter',
					'plural' => 'liters',
					'abbr'   => 'L',
				),
			),
			'weight' => array(
				'lb' => array(
					'single' => 'pound',
					'plural' => 'pounds',
					'abbr'   => 'lb',
				),
				'oz' => array(
					'single' => 'ounce',
					'plural' => 'ounces',
					'abbr'   => 'oz',
				),
				'mg' => array(
					'single' => 'milligram',
					'plural' => 'milligrams',
					'abbr'   => 'mg',
				),
				'gram' => array(
					'single' => 'gram',
					'plural' => 'grams',
					'abbr'   => 'g',
				),
				'kg' => array(
					'single' => 'killogram',
					'plural' => 'killograms',
					'abbr'   => 'kg',
				),
			),
			'misc' => array(
				'pinch' => array(
					'single' => 'pinch',
					'plural' => 'pinches',
					'abbr'   => false,
				),
				'dash' => array(
					'single' => 'dash',
					'plural' => 'dashes',
					'abbr'   => false,
				),
				'package' => array(
					'single' => 'package',
					'plural' => 'packages',
					'abbr'   => 'pkg',
				),
			),
		);
		
		/**
		 * Filter the available units.
		 *
		 * @since 1.0.0
		 * 
		 * @param array $units The available units of measure.
		 */
		$units = apply_filters( 'simmer_get_units', $units );
		
		return $units;
	}
}
