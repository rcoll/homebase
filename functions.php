<?php

function hb_get_js_config() {
	return array( 
		'apiurl' => esc_url( admin_url( 'admin-ajax.php' ) ), 
		'switchZoneGroups' => array( 
			array( 'id' => 1, 'group' => 'common', 'label' => 'Common' ), 
			array( 'id' => 2, 'group' => 'children', 'label' => 'Children' ), 
			array( 'id' => 3, 'group' => 'master', 'label' => 'Master' ), 
			array( 'id' => 4, 'group' => 'outdoors', 'label' => 'Outdoors' ), 
			array( 'id' => 5, 'group' => 'guest', 'label' => 'Guest' ), 
			array( 'id' => 6, 'group' => 'office', 'label' => 'Office' ), 
			array( 'id' => 9, 'group' => 'security', 'label' => 'Security' ), 
		),
		'switchZones' => array( 
			'common' => array( 
				array( 'id' => 101, 'group' => 'common',   'label' => 'Mudroom',        'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 102, 'group' => 'common',   'label' => 'Dining Room',    'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 103, 'group' => 'common',   'label' => 'Kitchen',        'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 104, 'group' => 'common',   'label' => 'Breakfast',      'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 105, 'group' => 'common',   'label' => 'Family Room',    'icon' => 'lightbulb',     'state' => 0 ), 
			),
			'children' => array( 
				array( 'id' => 201, 'group' => 'children', 'label' => 'Rylan',          'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 202, 'group' => 'children', 'label' => 'Roman',          'icon' => 'lightbulb',     'state' => 1 ), 
				array( 'id' => 203, 'group' => 'children', 'label' => 'Bathroom',       'icon' => 'lightbulb',     'state' => 0 ), 
			), 
			'master' => array( 
				array( 'id' => 301, 'group' => 'master',   'label' => 'Bedroom',        'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 302, 'group' => 'master',   'label' => 'Bathroom',       'icon' => 'lightbulb',     'state' => 0 ), 
			),
			'outdoors' => array( 
				array( 'id' => 401, 'group' => 'outdoors', 'label' => 'Front Yard',     'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 402, 'group' => 'outdoors', 'label' => 'Back Yard',      'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 403, 'group' => 'outdoors', 'label' => 'Side Yard',      'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 404, 'group' => 'outdoors', 'label' => 'Pool Light',     'icon' => 'lightbulb',     'state' => 0 ),
				array( 'id' => 405, 'group' => 'outdoors', 'label' => 'Pool Heater',    'icon' => 'admin-generic', 'state' => 1 ), 
				array( 'id' => 406, 'group' => 'outdoors', 'label' => 'Pool Pump',      'icon' => 'admin-generic', 'state' => 1 ), 
			),
			'guest' => array( 
				array( 'id' => 501, 'group' => 'guest',    'label' => 'Guest Bedroom',  'icon' => 'lightbulb',     'state' => 0 ), 
				array( 'id' => 502, 'group' => 'guest',    'label' => 'Guest Bathroom', 'icon' => 'lightbulb',     'state' => 0 ), 
			), 
			'office' => array( 
				array( 'id' => 601, 'group' => 'office',   'label' => 'Office',         'icon' => 'lightbulb',     'state' => 0 ), 
			),
			'security' => array( 
				array( 'id' => 901, 'group' => 'security', 'label' => 'Front Door',     'icon' => 'admin-network', 'state' => 1 ), 
				array( 'id' => 902, 'group' => 'security', 'label' => 'Shades',         'icon' => 'admin-home',    'state' => 0 ), 
			), 
		),
	);
}



function hb_enqueue_scripts() {
	wp_register_script( 'homebase', get_template_directory_uri() . '/js/client/public/homebase.js', array(), null, true );

	wp_localize_script( 'homebase', 'homebase', hb_get_js_config() );

	wp_enqueue_script( 'homebase' );
	wp_enqueue_script( 'dashicons' );

	wp_enqueue_style( 'homebase', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'hb_enqueue_scripts' );



function hb_ajax_get_data() {
	wp_send_json_success( hb_get_js_config() );
}
add_action( 'wp_ajax_hb_get_data', 'hb_ajax_get_data' );
add_action( 'wp_ajax_nopriv_get_data', 'hb_ajax_get_data' );



function hb_ajax_update_state() {
	$id = absint( $_POST['id'] );
	$state = absint( $_POST['state'] );
	$results = shell_exec( "homebase $id $state" );

	wp_send_json_success( array( 'state' => 'updated', 'id' => $id, 'state' => $state, 'results' => $results ) );
}
add_action( 'wp_ajax_hb_update_state', 'hb_ajax_update_state' );
add_action( 'wp_ajax_nopriv_hb_update_state', 'hb_ajax_update_state' );

// omit