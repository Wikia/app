const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const compact = (collection) => Array.from(collection).filter(v => v != null);

module.exports = function (env) {
	const hoistDependencies = env && env['hoist-dependencies'];

	const bridge = {
		mode: 'production',
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
					use: [
						MiniCssExtractPlugin.loader,
						'css-loader',
						'sass-loader'
					],
				}
			]
		},
		resolve: {
			modules: compact([
				hoistDependencies ? path.resolve(__dirname, 'node_modules') : null,
				'node_modules'
			])
		},
		plugins: [
			new MiniCssExtractPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin(),
			new CopyWebpackPlugin([
				{
					from: './node_modules/@wikia/ad-products/dist/geo.amd.js',
					to: 'geo.js'
				}
			])
		]
	};

	return bridge;
};
