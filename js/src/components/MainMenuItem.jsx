import React from 'react';

class MainMenuItem extends React.Component {
	
	constructor( props ) {
		super( props );

		this.onClick = this.onClick.bind( this );
	}

	onClick() {
		
	}

	render() {
		return (
			<li onClick={ this.onClick }>{ this.props.label }</li>
		)
	}
}

export default MainMenuItem;