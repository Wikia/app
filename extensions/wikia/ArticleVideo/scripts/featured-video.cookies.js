define('wikia.articleVideo.featuredVideo.cookies', ['wikia.cookies'], function (cookies) {
	'use strict';

	var autoplayCookieName = 'featuredVideoAutoplay',
		captionsCookieName = 'featuredVideoCaptions',
		cookieExpireDays = 1209600000; // 14 days in milliseconds

	function toggleCookie(cookieName) {
		return function (condition) {
			if (condition === undefined) {
				condition = !isCookieEnabled(cookieName)();
			}

			cookies.set(cookieName, condition ? '1' : '0', {
				path: '/',
				domain: window.wgCookieDomain,
				expires: cookieExpireDays
			});

			return condition;
		};
	}

	function isCookieEnabled(cookieName) {
		return function () {
			return cookies.get(cookieName) !== '0';
		};
	}

	return {
		isAutoplayEnabled: isCookieEnabled(autoplayCookieName),
		areCaptionsEnabled: isCookieEnabled(captionsCookieName),
		toggleAutoplay: toggleCookie(autoplayCookieName),
		toggleCaptions: toggleCookie(captionsCookieName)
	};
});
