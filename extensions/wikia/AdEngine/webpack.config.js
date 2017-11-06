const path = require('path');

module.exports = {
	entry: path.resolve(__dirname, 'src', 'ad-engine.utils.js'),
	output: {
		path: path.resolve(__dirname, 'js/build'),
		filename: 'ad-engine.utils.js',
		libraryTarget: 'amd',
		library: 'ad-engine.utils'
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
