/*global define*/
define('ext.wikia.adEngine.ml.ctp.ctpDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.ctp.ctpDesktopDataSource',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear',
	require.optional('wikia.articleVideo.featuredVideo.autoplay')
], function (adContext, source, modelFactory, linearModel, featuredVideoAutoplay) {
	'use strict';

	var isFeaturedVideoClickToPlay = !!adContext.get('targeting.hasFeaturedVideo') &&
		!!featuredVideoAutoplay &&
		!featuredVideoAutoplay.isAutoplayEnabled();

	return modelFactory.create({
		dataSource: source,
		model: linearModel.create(source.coefficients, source.intercept),
		name: 'ctpdesktop',
		wgCountriesVariable: 'wgAdDriverCTPDesktopRabbitCountries',
		enabled: isFeaturedVideoClickToPlay && adContext.get('targeting.skin') === 'oasis',
		cachePrediction: true
	});
});
