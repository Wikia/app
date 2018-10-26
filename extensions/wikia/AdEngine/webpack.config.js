const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const compact = (collection) => Array.from(collection).filter(v => v != null);

module.exports = function (env) {
	const hoistDependencies = env && env['hoist-dependencies'];

	const adEngine = {
		mode: 'production',
		context: __dirname,
		entry: {
			'engine': './src/ad-engine.js',
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'ext.wikia.adEngine'
		},
		module: {
			rules: [
				{
					test: /\.jsx?$/,
					include: path.resolve(__dirname, 'src'),
					use: 'babel-loader',
				}
			]
		},
		resolve: {
			modules: compact([
				hoistDependencies ? path.resolve(__dirname, 'node_modules') : null,
				'node_modules'
			])
		},
		performance: {
			maxEntrypointSize: 500000
		},
		plugins: [
			new webpack.optimize.ModuleConcatenationPlugin()
		]
	};

	const packages = {
		mode: 'production',
		context: __dirname,
		entry: {
			'bidders': './src/ad-bidders.js',
			'bridge': './src/ad-engine.bridge.js',
			'services': './src/ad-services.js'
		},
		externals: {
			'@wikia/ad-engine': {
				amd: 'ext.wikia.adEngine'
			}
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'ext.wikia.adEngine.[name]'
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
		performance: {
			maxEntrypointSize: 500000
		},
		plugins: [
			new MiniCssExtractPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin(),
			new CopyWebpackPlugin([
				{
					from: './node_modules/@wikia/ad-engine/lib/prebid.min.js',
					to: 'prebid.js'
				}
			])
		]
	};

	return [
		adEngine,
		packages
	]
};
