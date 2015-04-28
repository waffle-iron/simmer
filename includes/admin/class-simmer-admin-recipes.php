<?php
/**
 * Define the class that sets up the Recipes admin
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Admin\Recipes
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Simmer_Admin_Recipes {
	
	/**
	 * Construct the class.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function __construct() {
		
		// Add the recipe metaboxes.
		add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
		
		// Save the recipe meta.
		add_action( 'save_post_recipe', array( $this, 'save_recipe_meta' ) );
		
		// Add custom "updated" messages.
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
		
		// Remove the "Quick Edit" link from the recipe row actions.
		add_filter( 'post_row_actions', array( $this, 'hide_quick_edit_link' ), 10, 2 );
	}
	
	/**
	 * Add the custom meta boxes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_metaboxes() {
		
		// Get the main object object type.
		$object_type = simmer_get_object_type();
		
		// Add the Ingredients meta box.
		add_meta_box(
			'simmer_ingredients',
			__( 'Ingredients', Simmer::SLUG ),
			array( $this, 'meta_box_ingredients' ),
			$object_type,
			'normal',
			'high'
		);
		
		// Add the Instructions meta box.
		add_meta_box(
			'simmer_instructions',
			__( 'Instructions', Simmer::SLUG ),
			array( $this, 'meta_box_instructions' ),
			$object_type,
			'normal',
			'high'
		);
		
		// Add the Information meta box.
		add_meta_box(
			'simmer_information',
			__( 'Information', Simmer::SLUG ),
			array( $this, 'meta_box_information' ),
			$object_type,
			'side'
		);
		
		/**
		 * Allow developers to register additional Simmer metaboxes.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_add_metaboxes' );
	}
	
	/**
	 * Print the ingredients meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $recipe The current recipe.
	 * @return void
	 */
	public function meta_box_ingredients( $recipe ) {
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_before_ingredients_metabox', $recipe );
		
		/**
		 * Include the meta box HTML.
		 */
		include_once( 'html/meta-boxes/ingredients.php' );
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_after_ingredients_metabox', $recipe );
	}
	
	/**
	 * Print the instructions meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $recipe The current recipe.
	 * @return void
	 */
	public function meta_box_instructions( $recipe ) {
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_before_instructions_metabox', $recipe );
		
		/**
		 * Include the meta box HTML.
		 */
		include_once( 'html/meta-boxes/instructions.php' );
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_after_instructions_metabox', $recipe );
	}
	
	/**
	 * Print the information meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $recipe The current recipe.
	 * @return void
	 */
	public function meta_box_information( $recipe ) {
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_before_information_metabox', $recipe );
		
		/**
		 * Include the meta box HTML.
		 */
		include_once( 'html/meta-boxes/information.php' );
		
		/**
		 * Allow others to add to this meta box.
		 *
		 * @since 1.0.0
		 * 
		 * @param object $recipe The recipe currently being edited.
		 */
		do_action( 'simmer_after_information_metabox', $recipe );
	}
	
	/**
	 * Save the recipe meta.
	 *
	 * @since 1.0.0
	 *
	 * @param  int $recipe_id The ID of the current recipe.
	 * @return void
	 */
	public function save_recipe_meta( $id ) {
		
		// Check if this is an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Check that this was a POST request.
		if ( 'POST' != strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
			return;
		}
		
		// Check the save recipe nonce.
		if ( ! wp_verify_nonce( $_POST['simmer_nonce'], 'simmer_save_recipe_meta' ) ) {
			return;
		}
		
		/** Ingredients **/
		
		// Add or update ingredient items.
		if ( isset( $_POST['simmer_ingredients'] ) && ! empty( $_POST['simmer_ingredients'] ) ) {
			
			foreach ( $_POST['simmer_ingredients'] as $key => $ingredient ) {
				
				if ( empty( $ingredient['description'] ) ) {
					continue;
				}
				
				$amount = Simmer_Recipe_Ingredient::convert_amount_to_float( $ingredient['amount'] );
				
				if ( isset( $ingredient['id'] ) && $ingredient['id'] ) {
					
					$ingredient_id = simmer_update_recipe_ingredient( $ingredient['id'], array(
						'amount'      => $amount,
						'unit'        => $ingredient['unit'],
						'description' => $ingredient['description'],
						'order'       => $ingredient['order'],
					) );
					
				} else {
					
					$ingredient_id = simmer_add_recipe_ingredient( get_the_ID(), $ingredient['description'], $amount, $ingredient['unit'], $ingredient['order'] );
					
				}
				
				/**
				 * Fire after saving a recipe ingredient.
				 *
				 * @since 1.3.0
				 *
				 * @param int $ingredient_id The ingredient ID.
				 * @param int $id            The recipe ID.
				 */
				do_action( 'simmer_admin_save_recipe_ingredient', $ingredient_id, $id );
			}
		}
		
		// Delete 'removed' ingredient items.
		if ( isset( $_POST['simmer_ingredients_remove'] ) && ! empty( $_POST['simmer_ingredients_remove'] ) ) {
			
			foreach ( $_POST['simmer_ingredients_remove'] as $ingredient_id ) {
				
				simmer_delete_recipe_ingredient( $ingredient_id );
				
				/**
				 * Fire after deleting a recipe ingredient.
				 *
				 * @since 1.3.0
				 */
				do_action( 'simmer_admin_delete_recipe_ingredient' );
			}
		}
		
		/** Instructions **/
		
		// Add or update instruction items.
		if ( isset( $_POST['simmer_instructions'] ) && ! empty( $_POST['simmer_instructions'] ) ) {
			
			foreach ( $_POST['simmer_instructions'] as $key => $instruction ) {
				
				if ( empty( $instruction['description'] ) ) {
					continue;
				}
				
				if ( isset( $instruction['id'] ) && $instruction['id'] ) {
					
					$instruction_id = simmer_update_recipe_instruction( $instruction['id'], array(
						'description' => $instruction['description'],
						'is_heading'  => $instruction['heading'],
						'order'       => $instruction['order'],
					) );
					
				} else {
					
					$instruction_id = simmer_add_recipe_instruction( get_the_ID(), $instruction['description'], $instruction['heading'], $instruction['order'] );
					
				}
				
				/**
				 * Fire after saving a recipe instruction.
				 *
				 * @since 1.3.0
				 *
				 * @param int $instruction_id The instruction ID.
				 * @param int $id            The recipe ID.
				 */
				do_action( 'simmer_admin_save_recipe_instruction', $instruction_id, $id );
			}
		}
		
		// Delete 'removed' instruction items.
		if ( isset( $_POST['simmer_instructions_remove'] ) && ! empty( $_POST['simmer_instructions_remove'] ) ) {
			
			foreach ( $_POST['simmer_instructions_remove'] as $instruction_id ) {
				
				simmer_delete_recipe_instruction( $instruction_id );
				
				/**
				 * Fire after deleting a recipe instruction.
				 *
				 * @since 1.3.0
				 */
				do_action( 'simmer_admin_delete_recipe_instruction' );
			}
		}
			
		/** Information **/
		
		// Save the prep, cooking, and total times.
		$times = (array) $_POST['simmer_times'];
		
		if ( ! empty( $times ) ) {
			
			foreach ( $times as $time => $values ) {
				
				// Convert the hours input to minutes.
				$hours = (int) $values['h'] * 60;
				
				$minutes = (int) $values['m'];
				
				$duration = $hours + $minutes;
				
				if ( 0 != $duration ) {
					update_post_meta( $id, '_recipe_' . $time . '_time', $duration );
				} else {
					delete_post_meta( $id, '_recipe_' . $time . '_time' );
				}
			}
			
		}
		
		// Maybe save the servings.
		if ( ! empty( $_POST['simmer_servings'] ) ) {
			update_post_meta( $id, '_recipe_servings', $_POST['simmer_servings'] );
		} else {
			delete_post_meta( $id, '_recipe_servings' );
		}
		
		// Maybe save the yield.
		if ( ! empty( $_POST['simmer_yield'] ) ) {
			update_post_meta( $id, '_recipe_yield', $_POST['simmer_yield'] );
		} else {
			delete_post_meta( $id, '_recipe_yield' );
		}
		
		// Maybe save the source text.
		if ( ! empty( $_POST['simmer_source_text'] ) ) {
			update_post_meta( $id, '_recipe_source_text', $_POST['simmer_source_text'] );
		} else {
			delete_post_meta( $id, '_recipe_source_text' );
		}
		
		// Maybe save the source URL.
		if ( ! empty( $_POST['simmer_source_url'] ) ) {
			update_post_meta( $id, '_recipe_source_url', $_POST['simmer_source_url'] );
		} else {
			delete_post_meta( $id, '_recipe_source_url' );
		}
		
		/**
		 * Allow others to do things when the recipe meta is saved.
		 * 
		 * @since 1.0.0
		 * 
		 * @param int $id The current recipe ID.
		 * @return void
		 */
		do_action( 'simmer_save_recipe_meta', $id );
	}
	
	/**
	 * Add custom "updated" messages.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $messages The default "updated" messages.
	 * @return array $messages The recipe "updated" messages.
	 */
	public function updated_messages( $messages ) {
		global $post;
		
		$recipe_url = get_permalink( $post->ID );
		
		$messages[ simmer_get_object_type() ] = array(
			1 => sprintf(
				__( 'Recipe updated. <a href="%s">View recipe</a>', Simmer::SLUG ),
				$recipe_url
			),
			4 => __( 'Recipe updated.', Simmer::SLUG ),
			5 => isset( $_GET['revision'] ) ? sprintf(
				__( 'Recipe restored to revision from %s', Simmer::SLUG ),
				wp_post_revision_title( (int) $_GET['revision'], false )
			) : false,
			6 => sprintf(
				__( 'Recipe created. <a href="%s">View recipe</a>', Simmer::SLUG ),
				$recipe_url
			),
			7 => __( 'Recipe saved.', Simmer::SLUG ),
			8 => sprintf(
				__( 'Recipe submitted. <a target="_blank" href="%s">Preview recipe</a>', Simmer::SLUG ),
				esc_url( add_query_arg( 'preview', 'true', $recipe_url ) )
			),
			9 => sprintf(
				__( 'Recipe scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview recipe</a>', Simmer::SLUG ),
				date_i18n( __( 'M j, Y @ G:i' ),
				strtotime( $post->post_date ) ),
				$recipe_url
			),
			10 => sprintf(
				__( 'Recipe draft updated. <a target="_blank" href="%s">Preview recipe</a>', Simmer::SLUG ),
				esc_url( add_query_arg( 'preview', 'true', $recipe_url ) )
			),
		);

		return $messages;
	}
	
	/**
	 * Remove the "Quick Edit" link from the recipe row actions.
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $actions The list of post row actions.
	 * @param  object $object  The current object.
	 * @return array  $actions The list of post row actions.
	 */
	public function hide_quick_edit_link( $actions, $object ) {
		
		// Only remove the link if this is a recipe.
		if ( $object->post_type == simmer_get_object_type() ) {
			
			unset( $actions['inline hide-if-no-js'] );
		}

		return $actions;
	}
}

new Simmer_Admin_Recipes();
