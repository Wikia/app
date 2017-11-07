const path = require('path');

module.exports = {
	entry: path.resolve(__dirname, 'src', 'ad-engine.bridge.js'),
	output: {
		path: path.resolve(__dirname, 'js/build'),
		filename: 'ad-engine.bridge.js',
		libraryTarget: 'amd',
		library: 'ad-engine.bridge'
	},
	resolve: {
		extensions: ['.js']
	},
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['es2015']
					}
				}
			}
		]
	}
};
