const path = require('path');

module.exports = function () {
	return {
		mode: 'production',
		context: __dirname,
		entry: {
			'tracking-opt-in.min': './src/index.js',
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'wikia.trackingOptInModal'
		},
		module: {
			rules: [
				{
					test: /\.jsx?$/,
					include: path.resolve(__dirname, 'src'),
					use: 'babel-loader',
				}
			]
		}
	}
};
