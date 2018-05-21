/*global define*/
define('ext.wikia.adEngine.ml.ctp.ctpDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.ml.ctp.ctpDesktopData',
	'ext.wikia.adEngine.ml.modelFactory',
	'ext.wikia.adEngine.ml.model.linear',
	require.optional('wikia.articleVideo.featuredVideo.autoplay')
], function (adContext, data, modelFactory, linearModel, featuredVideoAutoplay) {
	'use strict';

	var isFeaturedVideoClickToPlay = !!adContext.get('targeting.hasFeaturedVideo') &&
		!!featuredVideoAutoplay &&
		featuredVideoAutoplay.isAutoplayEnabled();

	return modelFactory.create({
		inputParser: data,
		model: linearModel.create(data.getCoefficients(), data.getIntercept()),
		name: 'ctpdesktop',
		wgCountriesVariable: 'wgAdDriverCTPDesktopRabbitCountries',
		enabled: isFeaturedVideoClickToPlay && adContext.get('targeting.skin') === 'oasis',
		cachePrediction: true
	});
});
