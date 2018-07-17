define('wikia.articleVideo.featuredVideo.autoplay', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.ml.rabbit')
], function (adContext, abTest, featuredVideoCookieService, rabbit) {
	'use strict';
	var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');

	return {
		isAutoplayDisabledByRabbits: function () {
			var isDesktopAutoplayDisabledByRabbit = adContext.get('rabbits.ctpDesktop');

			var queenPrediction = rabbit.getPrediction('queendesktop');
			if (queenPrediction !== undefined) {
				isDesktopAutoplayDisabledByRabbit = !!queenPrediction;
			}
			return isDesktopAutoplayDisabledByRabbit;
		},
		isAutoplayEnabled: function () {
			var isEnabled =  featuredVideoCookieService.getAutoplay() !== '0' &&
				// adContext.isEnabled('wgArticleVideoAutoplayCountries') &&
				!inFeaturedVideoClickToPlayABTest;
			if (rabbit) {
				isEnabled = isEnabled && !this.isAutoplayDisabledByRabbits();
			}
			return isEnabled;
		},
		inNextVideoAutoplayEnabled: function () {
			return true;
		},
		isAutoplayToggleShown: function () {
			return !(
				adContext.get('rabbits.ctpDesktop') ||
				adContext.get('rabbits.queenDesktop') ||
				inFeaturedVideoClickToPlayABTest
			);
		}
	};
});
