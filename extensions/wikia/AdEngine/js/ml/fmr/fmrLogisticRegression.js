/*global define*/
define('ext.wikia.adEngine.ml.fmr.fmrLogisticRegression', [
	'ext.wikia.adEngine.ml.fmr.fmrInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			-0.304360167,
			-3.03645625,
			2.43407028,
			1.37748331,
			8.18936945,
			-6.80640838,
			3.07912864,
			4.22575335,
			3.05398039,
			1.56544758,
			1.35266676,
			1.46443631,
			1.63976417,
			1.72897041,
			1.56771498,
			1.64995283,
			1.54796903,
			27.2848195,
			-14.7678968,
			1.99373638,
			2.18399385,
			2.04954933,
			2.02234034,
			1.66476354,
			2.03765807,
			0.564880392,
			2.46780663,
			2.07613289,
			1.79205965,
			2.05993374,
			1.99533944,
			1.71450779,
			0.411141975,
			0.0230943713
		],
		intercept = 12.51692079;

	return modelFactory.create({
		inputParser: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'fmrlr',
		wgCountriesVariable: 'wgAdDriverFMRLogisticRegressionRabbitCountries',
		enabled: true
	});
});
