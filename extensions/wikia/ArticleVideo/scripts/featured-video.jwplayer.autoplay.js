define('wikia.articleVideo.featuredVideo.autoplay', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.ml.rabbit')
], function (adContext, abTest, featuredVideoCookieService, rabbit) {
	'use strict';
	var isAutoplayDisabledByRabbit = adContext.get('rabbits.ctpDesktop');
	var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');

	return {
		isAutoplayDisabledByRabbits: function () {
			var queenPrediction = rabbit.getPrediction('queendesktop');
			if (queenPrediction !== undefined) {
				isAutoplayDisabledByRabbit = !!queenPrediction;
			}
			return isAutoplayDisabledByRabbit;
		},
		isAutoplayEnabled: function () {
			return featuredVideoCookieService.getAutoplay() !== '0' &&
				// adContext.isEnabled('wgArticleVideoAutoplayCountries') &&
				!this.isAutoplayDisabledByRabbits() &&
				!inFeaturedVideoClickToPlayABTest;
		},
		inNextVideoAutoplayEnabled: function () {
			return true;
		}
	};
});
