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

	const core = {
		mode,
		context: __dirname,
		entry: {
			'engine': './src/vendors/ad-engine.js',
		},
		output: {
			path: path.resolve(__dirname, `${buildDirectory}/vendors`),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'ext.wikia.adEngine3'
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

	const vendors = {
		mode,
		context: __dirname,
		entry: {
			'bidders': './src/vendors/ad-bidders.js',
			'products': './src/vendors/ad-products.js',
			'services': './src/vendors/ad-services.js',
		},
		externals: {
			'@wikia/ad-engine': {
				amd: 'ext.wikia.adEngine3'
			}
		},
		output: {
			path: path.resolve(__dirname, `${buildDirectory}/vendors`),
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
		mode,
		context: __dirname,
		entry: {
			'ads': './src/index.js',
			'styles': './src/styles.js',
		},
		externals: {
			'@wikia/ad-engine': {
				amd: 'ext.wikia.adEngine3'
			},
			'@wikia/ad-engine/dist/ad-bidders': {
				amd: 'ext.wikia.adEngine3.bidders'
			},
			'@wikia/ad-engine/dist/ad-products': {
				amd: 'ext.wikia.adEngine3.products'
			},
			'@wikia/ad-engine/dist/ad-services': {
				amd: 'ext.wikia.adEngine3.services'
			}
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
					to: 'vendors/prebid.js'
				}
			])
		]
	};

	return [
		core,
		vendors,
		packages
	]
};
