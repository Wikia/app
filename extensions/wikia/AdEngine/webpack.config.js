const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
	context: __dirname,
	entry: {
		'bridge': './src/ad-engine.bridge.js',
	},
	output: {
		path: path.resolve(__dirname, 'js/build'),
		filename: '[name].js',
		libraryTarget: 'amd',
		library: 'ext.wikia.adEngine.bridge'
	},
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				include: path.resolve(__dirname, 'src'),
				use: 'babel-loader',
			},
			{
				test: /\.s?css$/,
				include: path.resolve(__dirname, 'src'),
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
		new ExtractTextPlugin({filename: '[name].scss'}),
		new webpack.optimize.ModuleConcatenationPlugin()
	]
};
