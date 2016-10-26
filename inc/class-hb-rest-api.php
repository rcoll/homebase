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
	 * Holder for the logger instance
	 */
	public $logger = null;

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
		$this->logger = HomeBase_Logger::init();

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

		register_rest_route( 'homebase/v1', '/get', array( 
			'methods' => WP_REST_Server::READABLE, 
			'callback' => array( $this, 'callback_get' ), 
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
	 * Callback for getting all setting states
	 *
	 * @access public
	 */
	function callback_get( $request ) {
		$config = hb_get_config();

		$settings = array();

		foreach ( $config['switchZones'] as $zone => $switches ) {
			foreach ( $switches as $switch ) {
				$settings[ $switch['id'] ] = (bool) get_option( 'hb_switch_' . $switch['id'] );
			}
		}

		return new WP_REST_Response( $settings, 200 );
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
		$state = (bool) $args['state'];

		if ( $state == get_option( "hb_switch_$id" ) ) {
			return new WP_REST_Response( array( 'status' => 'update_nochange' ), 200 );
		}

		if ( update_option( "hb_switch_$id", $state ) ) {
			$zone = hb_get_switchzone_by_id( $id );
			$onoff = ( $state ) ? 'on' : 'off';

			$title = sprintf( "%s switch was turned %s", 
				$zone['label'], 
				$onoff
			);

			$this->logger->write( array( 
				'action' => 'state_change', 
				'id' => $id, 
				'state' => $state, 
				'status' => 'success', 
			), $title );

			return new WP_REST_Response( array( 'status' => 'update_success' ), 200 );
		} else {
			$this->logger->write( array( 
				'action' => 'state_change', 
				'id' => $id, 
				'state' => $state, 
				'status' => 'error', 
			));

			return new WP_REST_Response( array( 'status' => 'update_error' ), 200 );
		}
	}

}
