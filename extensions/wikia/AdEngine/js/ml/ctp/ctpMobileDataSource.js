/*global define*/
define('ext.wikia.adEngine.ml.ctp.ctpMobileDataSource', [
	'ext.wikia.adEngine.ml.dataSourceFactory'
], function (dataSourceFactory) {
	'use strict';

	return dataSourceFactory.create({
		coefficients: [
			1.10590466,
			0.61278047,
			0.36253462,
			1.92155622,
			0.58158104,
			-0.23980652,
			1.4999982,
			-0.26325649,
			0.29644939,
			0.17877794,
			1.02768361,
			2.15447831,
			1.44061676,
			-0.22907158,
			0.98622022,
			2.33801039,
			1.43509304,
			1.08236178,
			1.83044473,
			1.89168248,
			0.05693382,
			1.01443448,
			1.94304584,
			1.48159354,
			-1.25962374,
			-0.18995752,
			-0.7115996,
			0.47548732,
			-0.44931183,
			1.84193522
		],
		features: [
			{ name: 'wikiId', value: '277' },
			{ name: 'wikiId', value: '374' },
			{ name: 'wikiId', value: '530' },
			{ name: 'wikiId', value: '1343' },
			{ name: 'wikiId', value: '1544' },
			{ name: 'wikiId', value: '4492' },
			{ name: 'wikiId', value: '4828' },
			{ name: 'wikiId', value: '66026' },
			{ name: 'wikiId', value: '86644' },
			{ name: 'wikiId', value: '147413' },
			{ name: 'wikiId', value: '200383' },
			{ name: 'wikiId', value: '224761' },
			{ name: 'wikiId', value: '701294' },
			{ name: 'wikiId', value: '848200' },
			{ name: 'wikiId', value: '986551' },
			{ name: 'wikiId', value: '1639458' },
			{ name: 'country', value: 'BJ' },
			{ name: 'country', value: 'CN' },
			{ name: 'country', value: 'GY' },
			{ name: 'country', value: 'IQ' },
			{ name: 'country', value: 'JP' },
			{ name: 'country', value: 'MM' },
			{ name: 'country', value: 'PE' },
			{ name: 'verticalName', value: 'lifestyle' },
			{ name: 'trafficSource', value: 'direct' },
			{ name: 'trafficSource', value: 'external' },
			{ name: 'trafficSource', value: 'wiki' },
			{ name: 'esrb', value: 'everyone' },
			{ name: 'esrb', value: 'mature' },
			{ name: 'namespace', value: 'home' }
		],
		intercept: -0.06423668
	});
});
