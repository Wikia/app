define('wikia.articleVideo.featuredVideo.autoplay', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.ml.rabbit')
], function (adContext, abTest, featuredVideoCookieService, rabbit) {
	'use strict';

	return {
		isAutoplayDisabledByRabbits: function () {
			var isAutoplayDisabledByRabbit = adContext.get('rabbits.ctpDesktop');
			var queenPrediction = rabbit.getPredictions(['queendesktop']);
			if (queenPrediction.length > 0) {
				isAutoplayDisabledByRabbit = queenPrediction.indexOf(1) > -1;
			}
			return isAutoplayDisabledByRabbit;
		},
		isAutoplayEnabled: function () {
			var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');
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
