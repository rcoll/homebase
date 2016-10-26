import React from 'react';

class ClimateControl extends React.Component {
	constructor( props ) {
		super( props );

		this.tempIncrease = this.tempIncrease.bind( this );
		this.tempDecrease = this.tempDecrease.bind( this );
	}

	tempIncrease() {
		console.log( 'foo' );
		this.props.settingTemp++;
	}

	tempDecrease() {
		console.log( 'bar' );
		this.props.settingTemp--;
	}

	render() {		
		return ( 
			<div className="climate-control">
				<div className="temp temp-small">{ this.props.currentTemp }ºF</div>
				<div className="temp temp-large">{ this.props.settingTemp }ºF</div>
				<button onClick={ this.tempIncrease }>+</button>
				<button onClick={ this.tempDecrease }>-</button>
			</div>
		);
	}
}

export default ClimateControl;