<?php
/**
 * Define the bulk add class
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Admin\Bulk
 */

final class Simmer_Admin_Bulk_Add {
	
	public function __construct() {
		
		$this->add_actions();
	}
	
	private function add_actions() {
		
		add_action( 'wp_ajax_simmer_process_bulk', array( $this, 'process_ajax' ) );
	}
	
	public function process_ajax() {
		
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'simmer_process_bulk' ) ) {
			
			echo json_encode( array(
				'error' => 'no-nonce',
				'text'  => __( 'No don\'t have permission to do this.', Simmer::SLUG ),
			) );
			
			die();
		}
		
		if ( ! isset( $_POST['text'] ) || empty( $_POST['text'] ) ) {
			
			echo json_encode( array(
				'error' => 'no-input',
				'text'  => __( 'Please add some text.', Simmer::SLUG ),
			) );
			
			die();
		}
		
		$type = ( isset( $_POST['type'] ) ) ? $_POST['type'] : 'ingredients';
		$text = $_POST['text'];
		
		if ( $items = $this->parse_input( $text ) ) {
			
			echo json_encode( $items );
			
			die();
			
		} else {
			
			echo json_encode( array(
				'error' => 'parse-error',
				'text'  => __( 'Could not parse input.', Simmer::SLUG ),
			) );
			
			die();
			
		}
		
		die();
	}
	
	public function parse_input( $input ) {
		
		$input = str_replace( array("\r", "\n"), ',', $input );
		
		$lines = explode( ',', $input );
		$lines = array_map( 'trim', $lines );
		
		$items = false;
		
		if ( ! empty( $lines ) ) {
			
			$items = array();
			
			foreach ( $lines as $line ) {
				
				$amount = substr( $line, 0, strspn( $line, '0123456789/. ' ) );
				
				$desc_start  = strlen( $amount );
				$description = $line;
				$description = substr( $description, $desc_start );
				
				$amount = trim( $amount );
				$amount = Simmer_Ingredient::convert_amount_to_float( $amount );
				
				// Get the available measurement units.
				$units = Simmer_Ingredients::get_units();
				
				$items[] = array(
					'amount'      => $amount,
					'description' => $description,
				);
			}
		}
		
		return $items;
	}
}
