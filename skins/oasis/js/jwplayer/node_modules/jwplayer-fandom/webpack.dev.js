'use strict';

const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

require('es6-promise').polyfill();

module.exports = {
	context: __dirname,
	entry: [
		path.resolve('src', 'scripts', 'index.js'),
		path.resolve('src', 'styles', 'dev.scss'),
		path.resolve('src', 'styles', 'index.scss')
	],
	output: {
		path: path.resolve('dist'),
		filename: 'wikiajwplayer.js',
		publicPath: "/dist/"
	},
	plugins: [
		new ExtractTextPlugin('index.css')
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
				use:  ExtractTextPlugin.extract({
					fallback: "style-loader",
					use: [
						'css-loader',
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
	devtool: 'source-map',
	devServer: {
		compress: true,
		port: 9000,
		index: 'index.html',
		inline: true
	}
};
