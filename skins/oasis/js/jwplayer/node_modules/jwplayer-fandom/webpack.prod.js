'use strict';

const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

require('es6-promise').polyfill();

module.exports = {
	context: __dirname,
	entry: [
		path.resolve('src', 'scripts', 'index.js'),
		path.resolve('src', 'styles', 'index.scss')
	],
	output: {
		path: path.resolve('dist'),
		filename: 'wikiajwplayer.js'
	},
	plugins: [
		new ExtractTextPlugin('index.css'),
		new webpack.optimize.UglifyJsPlugin({
			sourceMap: true
		})
	],
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					'babel-loader'
				]
			},
			{
				test: /\.scss$/,
				use: ExtractTextPlugin.extract({
					fallback: 'style-loader',
					use: [
						{ loader: 'css-loader', options: { minimize: true, sourceMap: true } },
						'postcss-loader',
						'sass-loader'
					]
				})
			}
		]
	},
	stats: {
		colors: true
	},
	devtool: 'source-map'
};
