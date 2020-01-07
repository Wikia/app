const { getAdEngineLoader } = require('@wikia/ad-engine/configs/webpack-app.config');
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

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
			'styles': './src/styles.js',
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
		performance: {
			maxAssetSize: 310000,
			maxEntrypointSize: 310000,
		},
		devtool: 'source-map',
		plugins: [
			new MiniCssExtractPlugin({filename: '[name].scss'}),
			new webpack.optimize.ModuleConcatenationPlugin()
		]
	};

	return packages
};
