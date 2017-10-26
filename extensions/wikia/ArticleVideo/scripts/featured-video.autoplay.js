define('wikia.articleVideo.featuredVideo.autoplay', ['wikia.cookies', 'wikia.geo', 'wikia.instantGlobals'], function (cookies, geo, instantGlobals) {

	var inAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoAutoplayCountries),
		inNextVideoAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoNextVideoAutoplayCountries),
		autoplayCookieName = 'featuredVideoAutoplay',
		autoplayCookieExpireDays = 1209600000, // 14 days in milliseconds
		willAutoplay = cookies.get(autoplayCookieName) !== '0' && inAutoplayCountries;

	function toggleAutoplay(enableAutoplay) {
		if (enableAutoplay === undefined) {
			enableAutoplay = !isAutoplayEnabled();
		}

		cookies.set(autoplayCookieName, enableAutoplay ? '1' : '0', {
			path: '/',
			domain: window.wgCookieDomain,
			expires: autoplayCookieExpireDays
		});

		return enableAutoplay;
	}

	function isAutoplayEnabled() {
		var cookieValue = cookies.get(autoplayCookieName);

		return cookieValue !== '0';
	}

	return {
		inAutoplayCountries: inAutoplayCountries,
		inNextVideoAutoplayCountries: inNextVideoAutoplayCountries,
		isAutoplayEnabled: isAutoplayEnabled,
		toggleAutoplay: toggleAutoplay,
		willAutoplay: willAutoplay
	}

});
