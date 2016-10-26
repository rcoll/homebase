<?php

function hb_get_config() {
	$config = array( 
		'apiurl' => esc_url( home_url( '/wp-json/homebase/v1/' ) ), 
		'switchZoneGroups' => array( 
			array( 'id' => 1, 'group' => 'common', 'label' => 'Common' ), 
			array( 'id' => 2, 'group' => 'children', 'label' => 'Children' ), 
			array( 'id' => 3, 'group' => 'master', 'label' => 'Master' ), 
			array( 'id' => 4, 'group' => 'outdoors', 'label' => 'Outdoors' ), 
			array( 'id' => 5, 'group' => 'guest', 'label' => 'Guest' ), 
			array( 'id' => 6, 'group' => 'office', 'label' => 'Office' ), 
		),
		'switchZones' => array( 
			'common' => array( 
				array( 'id' => 101, 'group' => 'common',   'label' => 'Mudroom',        'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_101' ) ), 
				array( 'id' => 102, 'group' => 'common',   'label' => 'Dining Room',    'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_102' ) ), 
				array( 'id' => 103, 'group' => 'common',   'label' => 'Kitchen',        'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_103' ) ), 
				array( 'id' => 104, 'group' => 'common',   'label' => 'Breakfast',      'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_104' ) ), 
				array( 'id' => 105, 'group' => 'common',   'label' => 'Family Room',    'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_105' ) ), 
			),
			'children' => array( 
				array( 'id' => 201, 'group' => 'children', 'label' => 'Rylan',          'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_201' ) ), 
				array( 'id' => 202, 'group' => 'children', 'label' => 'Roman',          'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_202' ) ), 
				array( 'id' => 203, 'group' => 'children', 'label' => 'Bathroom',       'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_203' ) ), 
			), 
			'master' => array( 
				array( 'id' => 301, 'group' => 'master',   'label' => 'Bedroom',        'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_301' ) ), 
				array( 'id' => 302, 'group' => 'master',   'label' => 'Bathroom',       'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_302' ) ), 
			),
			'outdoors' => array( 
				array( 'id' => 401, 'group' => 'outdoors', 'label' => 'Front Yard',     'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_401' ) ), 
				array( 'id' => 402, 'group' => 'outdoors', 'label' => 'Back Yard',      'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_402' ) ), 
				array( 'id' => 403, 'group' => 'outdoors', 'label' => 'Side Yard',      'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_403' ) ), 
				array( 'id' => 404, 'group' => 'outdoors', 'label' => 'Pool Light',     'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_404' ) ),
			),
			'guest' => array( 
				array( 'id' => 501, 'group' => 'guest',    'label' => 'Guest Bedroom',  'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_501' ) ), 
				array( 'id' => 502, 'group' => 'guest',    'label' => 'Guest Bathroom', 'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_502' ) ), 
			), 
			'office' => array( 
				array( 'id' => 601, 'group' => 'office',   'label' => 'Office',         'icon' => 'lightbulb-o',     'state' => (int) get_option( 'hb_switch_601' ) ), 
			),
		),
	);

	return $config;
}

function hb_get_switchzone_by_id( $id ) {
	$config = hb_get_config();

	foreach ( $config['switchZones'] as $group => $zones ) {
		foreach ( $zones as $zone ) {
			if ( $zone['id'] === absint( $id ) ) {
				return $zone;
			}
		}
	}

	return false;
}

function hb_get_switchzone_by_label( $label ) {
	$config = hb_get_config();

	foreach ( $config['switchZones'] as $group => $zones ) {
		foreach ( $zones as $zone ) {
			if ( $zone['label'] == $label ) {
				return $zone;
			}
		}
	}

	return false;
}