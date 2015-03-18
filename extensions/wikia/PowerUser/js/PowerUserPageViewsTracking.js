require(
	[
		'jquery',
		'wikia.window',
		'wikia.cookies',
		'wikia.tracker'
	],
	function ($, w, c, tracker) {
		var maxCounter = 5,
			cookieName = 'puPageViews';

		function init() {
			if (pvIsCookieSet() && !pvRemoveCookie()) {
				pvLaunchTracking();
			}
		}

		function pvLaunchTracking() {
			$newCounter = pvIncreaseCookieCounter();

			trackingParams = {
				trackingMethod: 'internal',
				category: 'poweruser-pageviews',
				action: 'pageviews-' + String($newCounter),
				label: w.wgPageName
			};

			tracker.track(trackingParams);
		}

		function pvIsCookieSet() {
			var cookie = pvGetCookieCounter();

			if ( cookie !== null && cookie !== '' ) {
				return true;
			}

			return false;
		}

		function pvRemoveCookie() {
			if (pvGetCookieCounter() >= maxCounter) {
				c.set(cookieName, null, {
					domain: w.wgCookieDomain,
					path: w.wgCookiePath
				});
				return true;
			}
			return false;
		}

		function pvGetCookieCounter() {
			return c.get(cookieName);
		}

		function pvIncreaseCookieCounter() {
			var newCounter = parseInt( pvGetCookieCounter() ) + 1;

			c.set(cookieName, newCounter, {
				expires: 1000*60*60,
				domain: w.wgCookieDomain,
				path: w.wgCookiePath
			});

			return newCounter;
		}

		init();
	}
);