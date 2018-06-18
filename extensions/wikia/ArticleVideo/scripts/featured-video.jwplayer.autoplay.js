define('wikia.articleVideo.featuredVideo.autoplay', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
], function (adContext, abTest, featuredVideoCookieService) {
	var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');

	function isAutoplayEnabled() {
		return featuredVideoCookieService.getAutoplay() !== '0' &&
			// adContext.isEnabled('wgArticleVideoAutoplayCountries') &&
			!adContext.get('rabbits.ctpDesktop') &&
			!inFeaturedVideoClickToPlayABTest;
	}

	function inNextVideoAutoplayEnabled() {
		// return adContext.isEnabled('wgArticleVideoNextVideoAutoplayCountries');
		return true;
	}

	return {
		isAutoplayEnabled: isAutoplayEnabled,
		inNextVideoAutoplayEnabled: inNextVideoAutoplayEnabled
	}
});
