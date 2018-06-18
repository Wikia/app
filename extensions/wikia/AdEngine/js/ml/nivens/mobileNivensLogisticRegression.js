/*global define*/
define('ext.wikia.adEngine.ml.nivens.mobileNivensLogisticRegression', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.nivens.mobileNivensInputParser',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (adContext, inputParser, modelFactory, linearModel) {
	'use strict';

	var coefficients = [
			-0.07481867,
			0.03927151,
			-0.01093154,
			1.11326222,
			-0.26659575,
			-0.12685029,
			0.734006,
			0.92938614,
			-0.0735317
		],
		intercept = 0.03849616;

	return modelFactory.create({
		dataSource: inputParser,
		model: linearModel.create(coefficients, intercept),
		name: 'mnivens',
		wgCountriesVariable: 'wgAdDriverMobileNivensRabbitCountries',
		enabled: adContext.get('targeting.skin') !== 'oasis',
		cachePrediction: true
	});
});
