<?php
/**
 * Define the support items functions
 *
 * @since 1.3.0
 *
 * @package Simmer/Recipes/Items
 */

/**
 * Get metadata for an item.
 *
 * @since 1.3.0
 *
 * @param  int                $item_id  The item ID.
 * @param  string             $meta_key Optional. The key of the metadata to retrieve. If left blank,
 *                                      all of the item's metadata will be returned in an array.
 * @param  bool               $single   Optional. Whether to return a single value or array of values. Default false.
 * @return array|string|false $metadata Array of metadata, a single metadata value, or false on failure.
 */
function simmer_get_recipe_item_meta( $item_id, $meta_key = '', $single = false ) {
	
	$items_api = new Simmer_Recipe_Item_Meta;
	
	$metadata = $items_api->get_item_meta( $item_id, $meta_key, $single );
	
	return $metadata;
}

/**
 * Add metadata to an item.
 *
 * @since 1.3.0
 *
 * @param  int      $item_id    The item ID.
 * @param  string   $meta_key   The meta key to add.
 * @param  string   $meta_value The meta value to add.
 * @param  bool     $unique     Optional. Whether the key should stay unique. When set to true,
 *                              the custom field will not be added if the given key already exists
 *                              among custom fields of the specified item.
 * @return int|bool $result     The new metadata's ID on success or false on failure.
 */
function simmer_add_recipe_item_meta( $item_id, $meta_key, $meta_value, $unique = false ) {
	
	$items_api = new Simmer_Recipe_Item_Meta;
	
	$result = $items_api->add_item_meta( $item_id, $meta_key, $meta_value, $unique );
	
	return $result;
}

/**
 * Update an item's metadata.
 *
 * @since 1.3.0
 *
 * @param  int      $item_id    The item ID.
 * @param  string   $meta_key   The key of the metadata to update.
 * @param  string   $meta_value The new metadata value.
 * @param  string   $prev_value Optional. The old value of the custom field you wish to change.
 *                              This is to differentiate between several fields with the same key.
 *                              If omitted, and there are multiple rows for this post and meta key,
 *                              all meta values will be updated.
 * @return int|bool $result     True on success or false on failure. If the metadata being updated
 *                              doesn't yet exist, it will be created and the new metadata's ID will
 *                              be returned. If the specified value already exists, then nothing will
 *                              be updated and false will be returned.
 */
function simmer_update_recipe_item_meta( $item_id, $meta_key, $meta_value, $prev_value = '' ) {
	
	$items_api = new Simmer_Recipe_Item_Meta;
	
	$result = $items_api->update_item_meta( $item_id, $meta_key, $meta_value, $prev_value );
	
	return $result;
}

/**
 * Delete metadata from an item.
 *
 * @since 1.3.0
 *
 * @param  int      $item_id    The item ID.
 * @param  string   $meta_key   The key of the metadata to delete.
 * @param  string   $meta_value Optional. The value of the metadata you wish to delete. This is used
 *                              to differentiate between several fields with the same key. If left blank,
 *                              all fields with the given key will be deleted.
 * @return bool     $result     True on success, false on failure.
 */
function simmer_delete_recipe_item_meta( $item_id, $meta_key, $meta_value = '' ) {
	
	$items_api = new Simmer_Recipe_Item_Meta;
	
	$result = $items_api->delete_item_meta( $item_id, $meta_key, $meta_value );
	
	return $result;
}
