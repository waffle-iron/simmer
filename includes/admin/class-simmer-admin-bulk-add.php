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
	
	/**
	 * Add the necessary action hooks.
	 * 
	 * @since 1.2.0
	 */
	private function add_actions() {
		
		add_action( 'admin_footer', array( $this, 'add_modal' ) );
		
		add_action( 'wp_ajax_simmer_process_bulk', array( $this, 'process_ajax' ) );
	}
	
	public function add_modal() {
		
		include_once( plugin_dir_path( __FILE__ ) . 'html/meta-boxes/bulk-add.php' );
	}
	
	public function process_ajax() {
		
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'simmer_process_bulk' ) ) {
			
			echo json_encode( array(
				'error' => 'no-nonce',
				'message'  => __( 'No don\'t have permission to do this.', Simmer::SLUG ),
			) );
			
			die();
		}
		
		if ( ! isset( $_POST['text'] ) || empty( $_POST['text'] ) ) {
			
			echo json_encode( array(
				'error' => 'no-input',
				'message'  => __( 'Please add some text.', Simmer::SLUG ),
			) );
			
			die();
		}
		
		$type = ( isset( $_POST['type'] ) ) ? $_POST['type'] : 'ingredient';
		$text = $_POST['text'];
		
		if ( $items = $this->parse_input( $text, $type ) ) {
			
			echo json_encode( $items );
			
			die();
			
		} else {
			
			echo json_encode( array(
				'error' => 'parse-error',
				'message'  => __( 'Could not parse input.', Simmer::SLUG ),
			) );
			
			die();
			
		}
		
		die();
	}
	
	public function parse_input( $input, $type ) {
		
		$lines = preg_split( '/\r\n|[\r\n]/', $input );
		$lines = array_map( 'trim', $lines );
		
		$items = false;
		
		if ( ! empty( $lines ) ) {
			
			$items = array();
			
			foreach ( $lines as $line ) {
				
				if ( 'ingredient' == $type ) {
					
					$amount = '';
					$unit   = '';
					$description = $line;
					
					$parsed_amount = $this->parse_amount( $line );
					
					if ( $parsed_amount ) {
						
						$amount = $parsed_amount['result'];
						
						// Remove the amount and format the description.
						$description = substr( $description, $parsed_amount['end'] );
						$description = trim( $description );
						
						$parsed_unit = $this->parse_unit( $description );
						
						if ( $parsed_unit ) {
							
							$description = substr( $description, $parsed_unit['end'] );
							
							$unit = $parsed_unit['result'];
						}
					}
					
					$description = trim( $description );
					
					$items[] = array(
						'amount'      => $amount,
						'unit'        => $unit,
						'description' => $description,
					);
					
				} else {
					
					$description = trim( $line );
					
					$items[] = array(
						'description' => $description,
					);
				}
			}
		}
		
		return $items;
	}
	
	private function parse_amount( $string ) {
		
		// Isolate the first word.
		$first_word = strtok( $string, ' ' );
		
		// Get amount string if it meets our criteria.
		$amount_length = strspn( $first_word, '0123456789/. ' );
		$amount_string = substr( $string, 0, $amount_length );
		
		if ( $amount_string ) {
			
			// Format the amount.
			$amount = trim( $amount_string );
			$amount = Simmer_Ingredient::convert_amount_to_float( $amount );
			
			$result = array(
				'start'  => 0,
				'end'    => $amount_length,
				'result' => $amount,
			);
			
		} else {
			
			$result = false;
			
		}
		
		return $result;
	}
	
	private function parse_unit( $string ) {
		
		$_unit  = '';
		$end = 0;
		
		// Isolate the first word.
		$first_word = strtok( $string, ' ' );
		
		// Get the available measurement units.
		$units = Simmer_Ingredients::get_units();
		$_units = array();
		
		foreach ( $units as $unit ) {
			$_units = array_merge( $unit, $_units );
		}
		
		foreach ( $_units as $unit => $labels ) {
			
			if ( ! in_array( $first_word, $labels ) ) {
				continue;
			}
			
			$_unit = $unit;
			$end  = strlen( $first_word );
		}
		
		if ( $_unit && $end ) {
			
			$result = array(
				'result' => $_unit,
				'start'  => 0,
				'end'    => $end,
			);
			
		} else {
			$result = false;
		}
		
		return $result;
	}
}
