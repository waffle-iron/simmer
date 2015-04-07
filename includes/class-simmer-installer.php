<?php
/**
 * Define the installer class
 *
 * @since 1.3.0
 *
 * @package Simmer/Install
 */

/**
 * A class to handle the installing and uninstalling of Simmer.
 *
 * @since 1.3.0
 */
final class Simmer_Installer {
	
	/**
	 * Install Simmer in all its glory.
	 *
	 * @since 1.3.0
	 */
	public static function install() {
		
		// Shout it from the rooftops: "Simmer is installing!"
		if ( ! defined( 'SIMMER_INSTALLING' ) ) {
			define( 'SIMMER_INSTALLING', true );
		}
		
		// Reset the version number.
		delete_option( 'simmer_version' );
		add_option( 'simmer_version', Simmer::VERSION, '', 'no' );
		
		/**
		 * Fires after Simmer has been installed.
		 *
		 * @since 0.1.0
		 */
		do_action( 'simmer_installed' );
	}
	
	public static function uninstall() {
		
		delete_option( 'simmer_version' );
		
		$on_uninstall = get_option( 'simmer_on_uninstall', 'keep_all' );
		
		// Check that the user wants everything deleted with the plugin.
		if ( 'keep_all' == $on_uninstall ) {
			return;
		}
		
		if ( 'delete_settings' == $on_uninstall || 'delete_all' == $on_uninstall ) {
			
			delete_option( 'simmer_ingredients_list_heading'  );
			delete_option( 'simmer_ingredients_list_type'     );
			delete_option( 'simmer_units_format'              );
			
			delete_option( 'simmer_instructions_list_heading' );
			delete_option( 'simmer_instructions_list_type'    );
			
			delete_option( 'simmer_enqueue_styles'      );
			delete_option( 'simmer_recipe_accent_color' );
			delete_option( 'simmer_recipe_text_color'   );
			
			delete_option( 'simmer_license' );
			
			delete_option( 'simmer_on_uninstall' );
			
			delete_option( 'simmer_archive_base'  );
			delete_option( 'simmer_recipe_base'   );
			delete_option( 'simmer_category_base' );
			
		}
		
		if ( 'delete_all' == $on_uninstall ) {
			
			// Delete all recipes.
			$recipe_ids = get_posts( array(
				'post_type'   => 'recipe',
				'post_status' => 'any',
				'numberposts' => -1,
				'fields'      => 'ids',
			) );
			
			if ( $recipe_ids ) {
				
				foreach ( $recipe_ids as $recipe_id ) {
					wp_delete_post( $recipe_id, true );
				}
				
			}
			
			// Delete all categories.
			$category_ids = get_terms( 'recipe_category', array(
				'hide_empty' => false,
				'fields'     => 'ids',
			) );
			
			if ( ! is_wp_error( $category_ids ) && ! empty( $category_ids ) ) {
				
				foreach ( $category_ids as $category_id ) {
					wp_delete_term( $category_id, 'recipe_category' );
				}
				
			}
			
		}
	}
}
