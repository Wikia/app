/*global define*/
define('ext.wikia.adEngine.ml.fmr.fmrPassiveAggressiveClassifier', [
	'ext.wikia.adEngine.ml.fmr.fmrInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			-0.82278099,
			-8.79683582,
			7.60984978,
			1.45988694,
			8.92733562,
			-12.05770462,
			5.62087356,
			9.07374935,
			3.01971169,
			0.12593883,
			4.46370629,
			1.33673095,
			2.01391295,
			4.59430009,
			0.81224786,
			2.17649926,
			-0.66646972,
			26.31888106,
			-11.46201455,
			2.07762358,
			2.60118493,
			2.51322211,
			0.65912343,
			2.379149,
			0.60862587,
			4.01793758,
			1.26946244,
			3.84173804,
			1.20193068,
			2.36249361,
			1.84468104,
			2.31894266,
			2.01761805,
			0.11216369
		],
		intercept = 14.85686651;

	return modelFactory.create({
		inputParser: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'fmrpac',
		wgCountriesVariable: 'wgAdDriverFMRPassiveAggressiveClassifierRabbitCountries',
		enabled: true,
		cachePrediction: true
	});
});
