import React           from 'react';
import { render }      from 'react-dom';
import SwitchZoneGroup from './SwitchZoneGroup.jsx';
import SwitchZone      from './SwitchZone.jsx';
import ClimateControl  from './ClimateControl.jsx';
import AudioSettings   from './AudioSettings.jsx';

class App extends React.Component {

	render() {
		let switchZoneGroups = homebase.switchZoneGroups.map( function( group ) {
			return ( <SwitchZoneGroup ref={ group.id } data={ group } /> );
		});

		let climateControl = ( <ClimateControl settingTemp="77" currentTemp="71" /> );

		let audioSettings = ( <AudioSettings/> );

		return ( 
			<div>
				<div className="switches">
					{ switchZoneGroups }
				</div>
				<div className="climate">
					{ climateControl }
				</div>
				<div className="audio">
					{ audioSettings }
				</div>
			</div> 
		);

	}
}

export default App;