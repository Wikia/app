define(
	'ext.wikia.powerUser.pageViewTracking',
	[
		'wikia.window',
		'wikia.cookies',
		'wikia.tracker'
	],
	function (w, cookies, tracker) {
		'use strict';

		var maxCounter = 5,
			cookieName = 'puspvs',
			cookieSetupValue = 0,
			/**
			 * If a user is not active for 3 hours
			 * we treat his return as a new session
			 * @type {number}
			 */
			cookieExpires = 1000 * 60 * 60 * 3;

		function pvIsCookieSet() {
			return cookies.get(cookieName) !== null;
		}

		function pvGetCookieCounter() {
			return parseInt(cookies.get(cookieName));
		}

		function pvSetCookieCounter(cookieValue) {
			cookies.set(cookieName, cookieValue, {
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
			tracker.track({
				trackingMethod: 'internal',
				category: 'poweruser-pageviews',
				action: w.wikiaPageType,
				label: w.wgPageName,
				value: pvGetCookieCounter()
			});
		}

		function init() {
			if (!pvIsCookieSet()) {
				pvSetCookieCounter(cookieSetupValue);
			}

			pvIncreaseCookieCounter();

			if (pvGetCookieCounter() <= maxCounter) {
				pvLaunchTracking();
			}
		}

		return {
			init: init
		};
	}
);
