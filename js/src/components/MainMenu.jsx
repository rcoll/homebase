import React from 'react';
import MainMenuItem from './MainMenuItem.jsx';

class MainMenu extends React.Component {
	
	constructor( props ) {
		super( props );
	}

	render() {
		return (
			<ul className="main-menu">
				<MainMenuItem hash="lighting" label="Lighting" />
				<MainMenuItem hash="sound" label="Sound" />
				<MainMenuItem hash="security" label="Security" />
				<MainMenuItem hash="climate" label="Climate" />
				<MainMenuItem hash="other" label="Other" />
			</ul>
		)
	}
}

export default MainMenu;