/* global GlobalNotification */
require(['wikia.cookies', 'wikia.geo'], function (cookies, geo) {
	'use strict';

	/**
	 * Initialize JS for whether or not to show a banner notifying European Union users that we use cookies
	 * on our site, per EU law. Users can dismiss the notification and will not be shown again, unless
	 * they clear their cookies.
	 */
	function initCookieNotification() {
		if (shouldShowBanner()) {
			showBanner();
		}
	}

	/**
	 * Check if user is from the EU and hasn't seen the banner yet
	 * @returns {boolean}
	 */
	function shouldShowBanner() {
		var fromEU = geo.getContinentCode() === 'EU';

		return (fromEU && !hasSeenBanner());
	}

	/**
	 * Display the cookie policy message to the user
	 */
	function showBanner() {
		var message = mw.message('oasis-eu-cookie-policy-notification-message').escaped() +
			' ' +
			'<a href="http://www.wikia.com/Privacy_Policy#Cookies" target="_blank">' +
			mw.message('oasis-eu-cookie-policy-notification-link-text').escaped() +
			'</a>';

		GlobalNotification.show(message, 'notify');
		setCookie();
	}

	/**
	 * Check if the user has seen the cookie notification banner before.
	 * @returns {boolean}
	 */
	function hasSeenBanner() {
		return !!cookies.get('euCookiePolicy');
	}

	/**
	 * Set a cookie so we know not to show the policy banner again.
	 */
	function setCookie() {
		cookies.set('euCookiePolicy', '1');
	}

	$(initCookieNotification);
});
