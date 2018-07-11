/*global define*/
define('ext.wikia.adEngine.ml.ctp.queenDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.ctp.queenDesktopDataSource',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear'
], function (adContext, source, modelFactory, linearModel) {
	'use strict';

	return modelFactory.create({
		dataSource: source,
		model: linearModel.create(source.coefficients, source.intercept),
		name: 'queendesktop',
		enabled: function () {
			/*
			Enable only on page with FV on oasis with queen enabled
			(queen can be forced to enabled state by query presence
			of query param "CTPQueenForce").
			 */
			return (
				!!adContext.get('targeting.hasFeaturedVideo') &&
				adContext.get('targeting.skin') === 'oasis'
			) && (
				!!adContext.get('rabbits.isQueenDesktopForced') ||
				!!adContext.get('rabbits.queenDesktop')
			);
		},
		cachePrediction: true
	});
});
