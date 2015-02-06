<?php

final class Simmer_Widgets {
	
	/**
	 * The only instance of this class.
	 *
	 * @since  1.0.5
	 * @access protected
	 * @var    object The only instance of this class.
	 */
	protected static $_instance = null;
	
	/**
	 * Get the main instance.
	 *
	 * Insure that only one instance of this class exists in memory at any one time.
	 *
	 * @since 1.0.5
	 *
	 * @return The only instance of this class.
	 */
	public static function get_instance() {
		
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	public function __construct() {
		
		$this->include_files();
		
		$this->init();
	}
	
	public function init() {
		
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}
	
	public function include_files() {
		
		/**
		 * Include the Recipe Categories widget class.
		 */
		include plugin_dir_path( __FILE__ ) . 'class-simmer-categories-widget.php';
	}
	
	public function register_widgets() {
		
		// Register the Recipe Categories widget.
		register_widget( 'Simmer_Categories_Widget' );
	}
}

Simmer_Widgets::get_instance();
