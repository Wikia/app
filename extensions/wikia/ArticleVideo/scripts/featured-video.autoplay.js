define('wikia.articleVideo.featuredVideo.autoplay', ['wikia.cookies'], function (cookies) {

	var autoplayCookieName = 'featuredVideoAutoplay',
		autoplayCookieExpireDays = 1209600000; // 14 days in milliseconds

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
		isAutoplayEnabled: isAutoplayEnabled,
		toggleAutoplay: toggleAutoplay
	}

});
