define('wikia.articleVideo.featuredVideo.autoplay', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.cookies',
//	'wikia.geo',
//	'wikia.instantGlobals'
], function (
	adContext,
	abTest,
	featuredVideoCookieService
//	geo,
//	instantGlobals,
) {
	var inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY');

	function isAutoplayEnabled() {
		return featuredVideoCookieService.getAutoplay() !== '0' &&
			// geo.isProperGeo(instantGlobals.wgArticleVideoAutoplayCountries) &&
			!adContext.get('rabbits.ctpDesktop') &&
			!inFeaturedVideoClickToPlayABTest;
	}

	function inNextVideoAutoplayEnabled() {
		// return geo.isProperGeo(instantGlobals.wgArticleVideoNextVideoAutoplayCountries);
		return true;
	}

	return {
		isAutoplayEnabled: isAutoplayEnabled,
		inNextVideoAutoplayEnabled: inNextVideoAutoplayEnabled
	}
});
