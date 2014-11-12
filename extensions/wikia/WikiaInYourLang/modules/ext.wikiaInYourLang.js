/**
 * Module that checks if a given wikia exists
 * in a user's native language (based on a Geo cookie)
 * and displays a notification with a link.
 *
 * @author - Adam Karmiński <adamk@wikia-inc.com>
 */

require(
	[
		'jquery',
		'mw',
		'wikia.window',
		'wikia.geo',
		'wikia.cache',
		'wikia.tracker',
	],
	function ($, mw, w, geo, cache, tracker) {
		'use strict';

		cache.set('wikiaInYourLangRequestSent', false);
		cache.set('wikiaInYourLangNotificationShown', false);
		/**
		 * An array of language codes for which we want to look for a native wikia
		 * @type {Array}
		 */
		var supportedLanguages = ['ja'],
			// Get user's geographic data and a country code
			// targetLanguage = getTargetLanguage();
			targetLanguage = 'ja';

		function init() {
			if (targetLanguage !== false) {
				// Check local browser cache to see if a request has been sent
				// in the last month and if the notification has been shown to him.
				// Both have to be !== true to continue.
				if (cache.get('wikiaInYourLangRequestSent') !== true && cache.get('wikiaInYourLangNotificationShown') !== true) {
					// Update JS cache and set the notification shown indicator to true
					var ttl = 60 * 60 * 24 * 30; // Cache for a month
					cache.set('wikiaInYourLangRequestSent', true, ttl);

					getNativeWikiaInfo();
				}
			}
		}

		function getTargetLanguage() {
			// var browserLanguage = window.navigator.language || window.navigator.userLanguage,
			var browserLanguage = 'ja',
				geoCountryCode = geo.getCountryCode().toLowerCase();

			// Check if a browser's language is one of the supported languages
			if (typeof (browserLanguage) == 'string' && $.inArray(browserLanguage.substr(0, 2), supportedLanguages)) {
				targetLanguage = browserLanguage.substr(0, 2);
				// Check if the country code is one of the supported languages
			} else if ($.inArray(geoCountryCode, supportedLanguages) !== -1) {
				targetLanguage = geoCountryCode;
				// If neither - return an empty string
			} else {
				targetLanguage = false;
			}

			return targetLanguage;
		}

		function getNativeWikiaInfo() {
			/**
			 * Sends a request to the WikiaInYourLangController via Nirvana.
			 * Response consists of:
			 * {
			 *   success:       bool    True if a native wikia is found
			 *   wikiaSitename: string  A wgSitename value for the wikia
			 *   wikiaUrl:      string  A city_url valur for the wikia
			 * }
			 */
			$.nirvana.sendRequest({
				controller: 'WikiaInYourLangController',
				method: 'getNativeWikiaInfo',
				format: 'json',
				type: 'GET',
				data: {
					targetLanguage: targetLanguage
				},
				callback: function (results) {
					console.log(results);
					if (results.success === true) {
						// Display notification and then set tracking on
						// the text link in it
						displayNotification(results.message);
						bindEvents();
					}
				}
			});
		}

		function displayNotification(message) {
			w.GlobalNotification.show(message, 'notify');

			var trackingParams = {
				trackingMethod: 'ga',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.VIEW,
				label: targetLanguage + '-notification-view',
			};

			tracker.track(trackingParams);
		}

		function bindEvents() {
			$('.global-notification.notify').click(function (event) {
				if (event.target.parentElement.className.indexOf('close') !== -1) {
					onNotificationClosed();
				} else if (event.target.id.indexOf('wikia-in-your-lang-link') !== -1) {
					onLinkClick();
				}
			})
		}

		function onNotificationClosed() {
			debugger;
			cache.set('wikiaInYourLangNotificationShown', true);
		}

		function onLinkClick() {
			var trackingParams = {
				trackingMethod: 'ga',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: targetLanguage + '-notification-link-click',
			};

			tracker.track(trackingParams);
		}

		init();
	}
);