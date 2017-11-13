define('wikia.articleVideo.featuredVideo.cookies', ['wikia.cookies'], function (cookies) {
	'use strict';

	var autoplayCookieName = 'featuredVideoAutoplay',
		captionsCookieName = 'featuredVideoCaptions',
		cookieExpireDays = 1209600000; // 14 days in milliseconds

	function setCookie(cookieName) {
		return function (cookieValue) {
			cookies.set(cookieName, cookieValue, {
				path: '/',
				domain: window.wgCookieDomain,
				expires: cookieExpireDays
			});

			return cookieValue;
		};
	}

	function getCookie(cookieName) {
		return function () {
			return cookies.get(cookieName);
		};
	}

	return {
		getAutoplay: getCookie(autoplayCookieName),
		setAutoplay: setCookie(autoplayCookieName),
		getCaptions: getCookie(captionsCookieName),
		setCaptions: setCookie(captionsCookieName)
	};
});
