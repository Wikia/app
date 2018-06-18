const path = require('path');
const fs = require('fs');
const colors = require('colors/safe');

const allowedVendorsIds = [
	10, // Index Exchange, Inc.
	11, // Quantcast International Limited
	32, // AppNexus Inc.
	52, // The Rubicon Project, Limited
	69, // OpenX Software Ltd. and its affiliates
	76, // PubMatic, Inc.
];
const moduleRules = {
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
		name: 'index',
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
	},
	{
		name: 'vendor-list',
		mode: 'production',
		context: __dirname,
		entry: {
			'vendor-list.min': './src/vendorlist.json',
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: '[name].js',
			libraryTarget: 'amd',
			library: 'wikia.consentFrameworkVendorList'
		},
		module: {
			rules: [
				{
					test: path.resolve(__dirname, 'src/vendorlist.json'),
					use: [
						{
							loader: 'transform-json-loader',
							options: {
								transform: function (json) {
									console.log(colors.green('Transforming Consent Framework Vendor List'));
									console.log(colors.yellow(`Version ${json.vendorListVersion}, last updated: ${json.lastUpdated}\n\n`));

									json.vendors = json.vendors.filter(vendor => {
										const isIncluded = allowedVendorsIds.includes(vendor.id);

										if (isIncluded) {
											console.log(`Adding vendor: ${colors.yellow(vendor.id)} (${colors.blue(vendor.name)})`);
										}

										return isIncluded;
									});

									console.log('\n---------------\n');

									return json;
								}
							}
						}
					]
				}
			]
		},
		resolveLoader: {
			alias: {
				'transform-json-loader': path.resolve(__dirname, 'transform-json-loader')
			}
		}
	}
];
