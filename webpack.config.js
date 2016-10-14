var webpack = require( 'webpack' );
var path = require( 'path' );

var BUILD_DIR = path.resolve( __dirname, 'js/build' );
var APP_DIR = path.resolve( __dirname, 'js/src' );

var config = {
	entry: APP_DIR + '/main.jsx',
	output: {
		path: BUILD_DIR,
		filename: 'homebase.js'
	},
	module: {
		loaders: [
			{
				test: /\.jsx?/,
				include: APP_DIR,
				loader: 'babel'
			}
		]
	}
};

module.exports = config;