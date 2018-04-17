/*global define*/
define('ext.wikia.adEngine.ml.n1.n1mLogisticRegression', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.n1.n1mInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (adContext, inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			0.170345207,
			0.359278905,
			-1.17811689,
			0.239185808,
			0.371057213,
			0.204047324,
			-0.775458431,
			-0.671111404,
			-0.00103779496,
			0.106914564,
			0.272032908,
			0.0103591977,
			1.04714742,
			-0.907550162,
			0.667635441
		],
		intercept = -0.17861922;

	return modelFactory.create({
		inputParser: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'n1mlr',
		wgCountriesVariable: 'wgAdDriverN1LogisticRegressionRabbitCountries',
		enabled: adContext.get('targeting.skin') !== 'oasis',
		cachePrediction: true
	});
});
