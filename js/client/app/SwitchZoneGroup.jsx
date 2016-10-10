import React from 'react';
import SwitchZone from './SwitchZone.jsx';

class SwitchZoneGroup extends React.Component {
	constructor( props ) {
		super( props );
		
		this.toggleAllZonesOn = this.toggleAllZonesOn.bind( this );
		this.toggleAllZonesOff = this.toggleAllZonesOff.bind( this );
	}

	getGroupZones() {
		return homebase.switchZones[ this.props.data.group ];
	}

	toggleAllZonesOn() {
		Object.keys( this.refs ).forEach( function( key, idx ) {
			this.refs[ key ].toggleOn();
		}, this );
	}

	toggleAllZonesOff() {
		Object.keys( this.refs ).forEach( function( key, idx ) {
			this.refs[ key ].toggleOff();
		}, this );
	}

	render() {
		let zones = homebase.switchZones[ this.props.data.group ].map( function( zone ) {
			return ( <SwitchZone ref={ zone.id } data={ zone } /> );
		});

		return ( 
			<div className="switch-zone-group">
				<div className="meta">
					<div className="title">
						<span>{ this.props.data.label }</span>
					</div>
					<div className="controls">
						<button onClick={ this.toggleAllZonesOn }>All On</button>
						<button onClick={ this.toggleAllZonesOff }>All Off</button>
					</div>
				</div>
				{ zones }
			</div>
		);
	}
}

export default SwitchZoneGroup;