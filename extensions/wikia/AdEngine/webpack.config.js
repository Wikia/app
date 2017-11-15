const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const destinationPath = path.resolve(__dirname, 'js/build');
const cssExtract = new ExtractTextPlugin('styles.scss');

module.exports = [{
	entry: [
		path.resolve(__dirname, 'src', 'ad-engine.bridge.js'),
	],
	output: {
		path: destinationPath,
		filename: 'ad-engine.bridge.js',
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
						presets: ['es2015']
					}
				}
			}
		]
	}
}, {
	entry: [
		path.resolve(__dirname, 'src', 'ad-engine.bridge.scss')
	],
	output: {
		// TODO: remove me I'm hack for webpack scss build
		// Together with .js it breaks js modules, for this setup it needs to generate some file
		path: destinationPath,
		filename: 'ignore_me.scss'
	},
	module: {
		rules: [
			{
				test: /\.s?css$/,
				loader: cssExtract.extract({
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
		cssExtract
	],
}];
