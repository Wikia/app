/* global GlobalNotification */
require(['wikia.cookies', 'wikia.geo'], function (cookies, geo) {
	'use strict';

	/**
	 * Initialize JS for whether or not to show a banner notifying European Union users that we use cookies
	 * on our site, per EU law. Users can dismiss the notification and will not be shown again, unless
	 * they clear their cookies.
	 */
	function initCookNotification() {
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
		var message = $.msg('oasis-eu-cookie-policy-notification-message') +
			'<a href="http://www.wikia.com/Privacy_Policy" target="_blank">' +
			$.msg('oasis-eu-cookie-policy-notification-link') +
			'</a>';

		GlobalNotification.show(message, 'confirm');
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

	$(initCookNotification);
});
