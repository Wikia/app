const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = function (env) {
	const isProduction = (process.env.NODE_ENV === 'production') || env && env.production;

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
			alias: {
				// size optimization - forcing webpack to use given dependencies
				// this MAY cause issues in case of version mismatch
				'regenerator-runtime': path.dirname(require.resolve('regenerator-runtime/package.json')),
				'core-decorators': path.dirname(require.resolve('core-decorators/package.json'))
			}
		},
		plugins: [
			new ExtractTextPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin()
		],
	};
};
