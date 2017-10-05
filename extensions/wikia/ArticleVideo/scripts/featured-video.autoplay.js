define('wikia.featuredVideo.autoplay', ['wikia.cookies', 'wikia.geo', 'wikia.instantGlobals'], function (cookies, geo, instantGlobals) {

	var inAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoAutoplayCountries),
		inNextVideoAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoNextVideoAutoplayCountries),
		autoplayCookieName = 'featuredVideoAutoplay',
		willAutoplay = cookies.get(autoplayCookieName) !== '0' && inAutoplayCountries;

	function toggleAutoplay() {
		cookies.set(autoplayCookieName, cookies.get(autoplayCookieName) === '0' ? '1' : '0');
	}

	function isAutoplayEnabled() {
		return !!cookies.get(autoplayCookieName);
	}

	return {
		inAutoplayCountries: inAutoplayCountries,
		inNextVideoAutoplayCountries: inNextVideoAutoplayCountries,
		isAutoplayEnabled: isAutoplayEnabled,
		toggleAutoplay: toggleAutoplay,
		willAutoplay: willAutoplay
	}

});