define('wikia.articleVideo.featuredVideo.cookies', ['wikia.cookies'], function (cookies) {
	'use strict';

	var autoplayCookieName = 'featuredVideoAutoplay',
		captionsCookieName = 'featuredVideoCaptions',
		videoSeenInSessionCookieName = 'featuredVideoSeenInSession',
		playerImpressionsCookieName = 'playerImpressionsInWiki',
		cookieExpireDays = 1209600000; // 14 days in milliseconds

	function setCookie(cookieName, domain, path) {
		return function (cookieValue) {
			cookies.set(cookieName, cookieValue, {
				path: path,
				domain: domain,
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

	function getLangPath() {
		var pathParts = window.location.pathname.split('/');

		return pathParts[1] === 'wiki' ? '/' : '/' + pathParts[1];
	}

	return {
		getAutoplay: getCookie(autoplayCookieName),
		setAutoplay: setCookie(autoplayCookieName, window.wgCookieDomain, '/'),
		getCaptions: getCookie(captionsCookieName),
		setCaptions: setCookie(captionsCookieName, window.wgCookieDomain, '/'),
		getVideoSeenInSession: getCookie(videoSeenInSessionCookieName),
		getPlayerImpressionsInWiki: function () {
			return Number(getCookie(playerImpressionsCookieName)());
		},
		setPlayerImpressionsInWiki: setCookie(
			playerImpressionsCookieName,
			window.location.hostname,
			getLangPath()
		)
	};
});
