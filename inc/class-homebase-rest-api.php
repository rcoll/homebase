<?php

/**
 * REST API endpoints for Homebase app
 */
class HomeBase_REST_API {

	/**
	 * Holder for object instance
	 *
	 * @access public
	 * @static
	 */
	static $instance = null;

	/**
	 * Singleton init
	 *
	 * @uses self::$instance
	 *
	 * @access public
	 * @static
	 */
	static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Class constructor - add actions and filters
	 *
	 * @uses add_action()
	 *
	 * @access public
	 */
	function __construct() {
		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
	}

	/**
	 * Register REST routes
	 *
	 * @uses register_rest_route()
	 *
	 * @access public
	 */
	public function rest_api_init() {
		register_rest_route( 'homebase/v1', '/status', array( 
			'methods' => WP_REST_Server::READABLE, 
			'callback' => array( $this, 'callback_status' ), 
			'permission_callback' => array( $this, 'permission_callback' ), 
		) );

		register_rest_route( 'homebase/v1', '/set/(?<id>\d+)/(?<state>\d+)', array( 
			'methods' => WP_REST_Server::READABLE, 
			'callback' => array( $this, 'callback_set' ), 
			'args' => array( 
				'id' => array( 
					'validate_callback' => 'absint', 
				),
				'state' => array( 
					'validate_callback' => 'absint', 
				),
			),
			'permission_callback' => array( $this, 'permission_callback' ), 
		) );
	}

	/**
	 * Ensure user has proper permission to access REST API
	 *
	 * @return bool True for authorized, false if not
	 */
	public function permission_callback() {
		return true;
	}

	/**
	 * Callback for getting app status
	 *
	 * @uses hb_get_config()
	 * @uses WP_REST_Response
	 *
	 * @access private
	 */
	private function callback_status( $request ) {
		$config = hb_get_config();

		$checksum = md5( serialize( $config ) );

		$data = array( 
			'status' => 'okay', 
			'config' => $config, 
			'checksum' => $checksum,
		);

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Callback for setting switch state
	 *
	 * @uses absint()
	 * @uses WP_REST_Response
	 *
	 * @access private
	 */
	function callback_set( $request ) {
		$args = $request->get_params();

		$id = absint( $args['id'] );
		$state = absint( $args['id'] );

		//$results = str_replace( "\n", '', shell_exec( "homebase $id $state" ) );
		$results = $args;

		return new WP_REST_Response( $results, 200 );
	}

}
