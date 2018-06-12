const path = require('path'),
	moduleRules = {
		rules: [
			{
				test: /\.jsx?$/,
				include: path.resolve(__dirname, 'src'),
				use: 'babel-loader',
			}
		]
	};

module.exports = [
	{
		name: "index",
		mode: 'production',
		context: __dirname,
		entry: {
			'tracking-opt-in.min': './src/index.js',
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'wikia.trackingOptInModal'
		},
		module: moduleRules
	},
	{
		name: 'consent-string',
		mode: 'production',
		context: __dirname,
		entry: {
			'consent-string.min': './src/consent-string.js',
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'wikia.consentStringLibrary'
		},
		module: moduleRules
	}
];
