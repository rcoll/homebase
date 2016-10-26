<?php

class Homebase {

	/**
	 * Instance holder variable
	 *
	 * @access public
	 * @static
	 */
	static $instance = null;

	/** 
	 * Singleton init function
	 *
	 * @uses self::$instance
	 * 
	 * @access public
	 * @static
	 * 
	 * @return object Instance of Homebase class
	 */
	static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Class constructor - require depenedencies and add filters and actions
	 *
	 * @uses add_action()
	 * 
	 * @access public
	 */
	public function __construct() {
		require_once( 'inc/hb-config.php' );
		require_once( 'inc/class-hb-rest-api.php' );
		require_once( 'inc/class-hb-logger.php' );

		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

		// Initialize REST API
		HomeBase_REST_API::init();
	}

	/**
	 * Enqueue scripts and styles for the front end
	 *
	 * @uses wp_register_script()
	 * @uses wp_localize_script()
	 * @uses wp_enqueue_script()
	 * @uses wp_enqueue_style()
	 *
	 * @access public
	 */
	public function wp_enqueue_scripts() {
		// Enqueue the sync script
		wp_register_script( 'hbsync', get_template_directory_uri() . '/js/lib/hb-sync.js', array(), null, true );

		// Enqueue the react app
		wp_register_script( 'homebase', get_template_directory_uri() . '/js/build/homebase.js', array( 'hbsync' ), null, true );
		wp_localize_script( 'homebase', 'homebase', hb_get_config() );
		wp_enqueue_script( 'homebase' );

		// Enqueue the stylesheet
		wp_enqueue_style( 'homebase', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );
	}

}

Homebase::init();