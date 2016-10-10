import React from 'react';
import {render} from 'react-dom';
import SwitchZoneGroup from './SwitchZoneGroup.jsx';
import SwitchZone from './SwitchZone.jsx';

class App extends React.Component {
	
	render() {
		let groups = homebase.switchZoneGroups.map( function( group ) {
			return ( <SwitchZoneGroup data={ group } /> );
		});

		return ( <div>{ groups }</div> );
	}
}

render( <App/>, document.getElementById( 'app' ) );