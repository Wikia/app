/*global define*/
define('ext.wikia.adEngine.ml.outstream.outstreamLogisticRegression', [
	'ext.wikia.adEngine.ml.outstream.outstreamInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			-0.00378709384,
			-0.415008546,
			-0.0591228445,
			-0.54962733,
			-0.00141524525,
			-0.0885103549,
			-1.98617309,
			3.12915591
		],
		intercept = 0.48931681;

	return modelFactory.create({
		inputParser: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'outstreamlr',
		wgCountriesVariable: 'wgAdDriverOutstreamLogisticRegressionRabbitCountries',
		enabled: true,
		cachePrediction: true
	});
});
