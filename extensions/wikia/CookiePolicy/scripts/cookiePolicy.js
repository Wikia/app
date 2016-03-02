require([
	'jquery',
	'mw',
	'wikia.window',
	'wikia.cookies',
	'wikia.geo',
	'BannerNotification'
], function ($, mw, window, cookies, geo, BannerNotification) {
	'use strict';

	/**
	 * Initialize JS for whether or not to show a banner notifying European Union users that we use cookies
	 * on our site, per EU law. Users can dismiss the notification and will not be shown again, unless
	 * they clear their cookies.
	 */
	function initCookieNotification() {
		if (shouldShowBanner()) {

			// make sure messages are loading before we show the notification
			mw.loader.using('ext.cookiePolicyMessages').then(showBanner);
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
		var message = mw.message('cookie-policy-notification-message').parse(),
			bannerNotification = new BannerNotification(message, 'notify').show();

		// currently, mw.message doesn't support the #NewWindowLink magic word, so we'll have to use JS
		bannerNotification.$element.find('a').on('click', function (event) {
			var url = $(this).attr('href');
			event.preventDefault();
			window.open(url, '_blank');
		});
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
		cookies.set('euCookiePolicy', '1', {
			domain: window.wgCookieDomain,
			path: '/',
			expires: 'never'
		});
	}

	$(function () {
		initCookieNotification();
	});
});
