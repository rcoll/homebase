import React from 'react';

class SwitchZone extends React.Component {
	constructor( props ) {
		super( props );

		this.state = { enabled: this.props.data.state, broken: 0 };
	
		this.onClick = this.onClick.bind( this );
		this.toggleOn = this.toggleOn.bind( this );
		this.toggleOff = this.toggleOff.bind( this );
	}

	encodeQueryString( obj ) {
		var str = [];

		for ( var p in obj ) {
			if ( obj.hasOwnProperty( p ) ) {
				str.push( encodeURIComponent( p ) + '=' + encodeURIComponent( obj[ p ] ) );
			}
		}

		return str.join( '&' );
	}

	componentWillUpdate( nextProps, nextState ) {
		if ( 1 === nextState.broken ) {
			return;
		}

		var url = homebase.apiurl + 'set/' + nextProps.data.id + '/' + nextState.enabled;
		var http = new XMLHttpRequest();
		var that = this;

		http.open( 'GET', url, true );
		http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
		http.onreadystatechange = function() {
			if ( 4 === http.readyState && 200 === http.status ) {
				var response = JSON.parse( http.responseText );
			}
		}

		http.send();
	}

	onClick() {
		if ( 1 === this.state.enabled ) {
			this.setState( { enabled: 0 } );
		} else {
			this.setState( { enabled: 1 } );
		}
	}

	toggleOn() {
		this.setState( { enabled: 1 } );
	}

	toggleOff() {
		this.setState( { enabled: 0 } );
	}

	render() {
		var classes = [ 'switch-zone' ];

		if ( 1 === this.state.enabled ) {
			classes.push( 'active' );
		}

		if ( 1 === this.state.broken ) {
			classes.push( 'broken' );
		}

		let icon = ( <i className={ "fa fa-3x fa-" + this.props.data.icon } /> );

		return ( 
			<div className={ classes.join( ' ' ) } onClick={ this.onClick }>
				<div className="icon">{ icon }</div>
				<div className="label">{ this.props.data.label }</div>
			</div> 
		);
	}
}

export default SwitchZone;