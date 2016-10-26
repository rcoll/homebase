<?php

class HomeBase_Logger {

	static $instance = null;

	static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	public function register_post_type() {
		register_post_type( 'hb_logger', array( 
			'labels' => array( 'name' => 'Log', 'singular_name' => 'Log' ), 
			'public' => true, 
			'has_archive' => true, 
		));
	}

	static function write( $data, $title = false ) {
		$data = json_encode( $data );

		$post = array( 
			'post_content' => $data, 
			'post_type' => 'hb_logger', 
		);

		if ( $title ) {
			$post['post_title'] = $title;
		}

		wp_insert_post( $post );
	}

	static function read( $args ) {

	}

}

HomeBase_Logger::init();