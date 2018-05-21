/*global define*/
define('ext.wikia.adEngine.ml.ctp.ctpDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.ctp.ctpDesktopData',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (adContext, data, modelFactory, linearModel) {
	'use strict';

	return modelFactory.create({
		inputParser: data,
		model: linearModel.create(data.getCoefficients(), data.getIntercept()),
		name: 'ctpdesktop',
		wgCountriesVariable: 'wgAdDriverCTPDesktopRabbitCountries',
		enabled: !!adContext.get('targeting.hasFeaturedVideo') && adContext.get('targeting.skin') === 'oasis',
		cachePrediction: true
	});
});
