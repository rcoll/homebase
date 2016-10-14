import React           from 'react';
import { render }      from 'react-dom';
import SwitchZoneGroup from './SwitchZoneGroup.jsx';
import SwitchZone      from './SwitchZone.jsx';
import MasterMenu      from './MainMenu.jsx';

class App extends React.Component {

	render() {
		let content = homebase.switchZoneGroups.map( function( group ) {
			return ( <SwitchZoneGroup data={ group } /> );
		});

		return (
			<div>
				<MasterMenu />
				{ content }
			</div>
		);

	}
}

export default App;