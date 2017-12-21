const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const destinationPath = path.resolve(__dirname, 'js/build');

module.exports = {
	entry: {
		'bridge': path.resolve(__dirname, 'src/ad-engine.bridge.js'),
	},
	output: {
		path: destinationPath,
		filename: '[name].js',
		libraryTarget: 'amd',
		library: 'ad-engine.bridge'
	},
	resolve: {
		modules: ['./', './node_modules'],
		extensions: ['.js', '.scss'],
		alias: {
			'ad-engine': path.join(__dirname, 'node_modules/ad-engine'),
			'ad-products': path.join(__dirname, 'node_modules/ad-products'),
		}
	},
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				use: {
					loader: 'babel-loader',
					options: {
						plugins: ['lodash'],
						presets: [
							'env'
						]
					}
				}
			},
			{
				test: /\.s?css$/,
				loader: ExtractTextPlugin.extract({
					fallback: 'style-loader',
					use: [
						'css-loader',
						'sass-loader'
					]
				})
			}
		]
	},
	plugins: [
		new ExtractTextPlugin({filename: '[name].scss'})
	]
};
