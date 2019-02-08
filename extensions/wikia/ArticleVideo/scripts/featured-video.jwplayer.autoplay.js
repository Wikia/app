define('wikia.articleVideo.featuredVideo.autoplay', [
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.ml.billTheLizardExecutor'),
	require.optional('ext.wikia.adEngine3.api')
], function (abTest, featuredVideoCookieService, billTheLizardExecutor, adsApi) {
	'use strict';
	var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');

	function isDisabledByQueenOfHearts() {
		if (adsApi) {
			return adsApi.isAutoPlayDisabled();
		}

		return billTheLizardExecutor && billTheLizardExecutor.isAutoPlayDisabled();
	}

	return {
		isAutoplayEnabled: function () {
			return featuredVideoCookieService.getAutoplay() !== '0' &&
				!isDisabledByQueenOfHearts() &&
				!inFeaturedVideoClickToPlayABTest;
		},
		inNextVideoAutoplayEnabled: function () {
			return true;
		},
		isAutoplayToggleShown: function () {
			return !(
				isDisabledByQueenOfHearts() ||
				inFeaturedVideoClickToPlayABTest
			);
		}
	};
});
