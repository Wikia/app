require(
	[
		'wikia.window',
		'wikia.cookies',
		'wikia.tracker'
	],
	function (w, c, tracker) {
		'use strict';

		var maxCounter = 5,
			cookieName = 'puspvs',
			cookieDefaultValue = 1,
			/**
			 * If a user is not active for 3 hours
			 * we treat his return as a new session
			 * @type {number}
			 */
			cookieExpires = 1000 * 60 * 60 * 3;

		function init() {
			if (!pvIsCookieSet()) {
				pvSetCookieCounter(cookieDefaultValue);
			}

			if (pvGetCookieCounter() <= maxCounter) {
				pvLaunchTracking();
				pvIncreaseCookieCounter();
			}
		}

		function pvIsCookieSet() {
			return c.get(cookieName) !== null;
		}

		function pvGetCookieCounter() {
			return parseInt(c.get(cookieName));
		}

		function pvSetCookieCounter(cookieValue) {
			c.set(cookieName, cookieValue, {
				expires: cookieExpires,
				domain: w.wgCookieDomain,
				path: w.wgCookiePath
			});
		}

		function pvIncreaseCookieCounter() {
			var newCounter = pvGetCookieCounter() + 1;
			pvSetCookieCounter(newCounter);
		}

		function pvLaunchTracking() {
			var trackingParams = {
				trackingMethod: 'internal',
				category: 'poweruser-pageviews',
				action: w.wikiaPageType,
				label: w.wgPageName,
				value: pvGetCookieCounter()
			};
			tracker.track(trackingParams);
		}

		init();
	}
);
