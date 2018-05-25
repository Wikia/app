/*global define, require*/
define('ext.wikia.adEngine.ml.ctp.ctpDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.ctp.ctpDesktopDataSource',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (adContext, source, modelFactory, linearModel) {
	'use strict';

	return modelFactory.create({
		dataSource: source,
		model: linearModel.create(source.coefficients, source.intercept),
		name: 'ctpdesktop',
		enabled: function () {
			return !!adContext.get('targeting.hasFeaturedVideo') &&
				adContext.get('rabbits.ctpDesktop') &&
				adContext.get('targeting.skin') === 'oasis';
		},
		cachePrediction: true
	});
});
