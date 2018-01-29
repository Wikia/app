/*global define*/
define('ext.wikia.adEngine.ml.n1.n1LogisticRegression', [
	'ext.wikia.adEngine.ml.n1.n1InputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			-1.35593338,
			-0.74005118,
			-0.68989916,
			-1.54150067,
			-1.2476945 ,
			0.23770009
		],
		intercept = 0.38341737;

	return modelFactory.create({
		inputParser: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'n1lr',
		wgCountriesVariable: 'wgAdDriverN1LogisticRegressionRabbitCountries',
		enabled: true
	});
});
