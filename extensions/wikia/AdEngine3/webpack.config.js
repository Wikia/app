const { getAdEngineLoader } = require('@wikia/ad-engine/configs/webpack-app.config');
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const compact = (collection) => Array.from(collection).filter(v => v != null);

module.exports = function (env) {
	const hoistDependencies = env && env['hoist-dependencies'];
	const isDevelopment = process.env.NODE_ENV !== 'production';
	const mode = isDevelopment ? 'development' : 'production';
	const buildDirectory = isDevelopment ? 'dist-dev' : 'dist';

	const packages = {
		mode,
		context: __dirname,
		entry: {
			'ads': './src/index.js',
		},
		output: {
			path: path.resolve(__dirname, buildDirectory),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'ext.wikia.adEngine3.[name]'
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
				},
				getAdEngineLoader()
			]
		},
		// resolve: {
		// 	modules: compact([
		// 		hoistDependencies ? path.resolve(__dirname, 'node_modules') : null,
		// 		'node_modules'
		// 	])
		// },
		performance: {
			maxEntrypointSize: 500000
		},
		plugins: [
			new MiniCssExtractPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin(),
			new CopyWebpackPlugin([
				{
					from: './node_modules/@wikia/ad-engine/lib/prebid.min.js',
					to: 'vendors/prebid.js'
				}
			])
		]
	};

	return packages
};
