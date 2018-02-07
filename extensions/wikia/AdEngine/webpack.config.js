const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const compact = (collection) => Array.from(collection).filter(v => v != null);

module.exports = function (env) {
	const hoistDependencies = env && env['hoist-dependencies'];

	return {
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
		resolve: {
			modules: compact([
				hoistDependencies ? path.resolve(__dirname, 'node_modules') : null,
				'node_modules'
			])
		},
		plugins: [
			new ExtractTextPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin()
		]
	};
};
