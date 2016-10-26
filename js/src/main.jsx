import React from 'react';
import { render } from 'react-dom';
import App from './components/App.jsx';

window.app = render( <App/>, document.getElementById( 'app' ) );
