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

		// Get user's geographic data and a country code
		targetLanguage = getTargetLanguage();

		function init() {
			if (targetLanguage !== false && targetLanguage != w.wgContentLanguage) {
				// Check local browser cache to see if a request has been sent
				// in the last month and if the notification has been shown to him.
				// Both have to be !== true to continue.
				if (cache.get('wikiaInYourLangRequestSent') !== true && cache.get('wikiaInYourLangNotificationShown') !== true) {
					// Update JS cache and set the notification shown indicator to true
					var ttl = 60 * 60 * 24 * 30; // Cache for a month
					cache.set('wikiaInYourLangRequestSent', true, ttl);

					getNativeWikiaInfo();
				} else if (typeof cache.get(targetLanguage + 'WikiaInYourLangMessage') === 'string') {
					displayNotification(cache.get(targetLanguage + 'WikiaInYourLangMessage'));
				}
			}
		}

		function getTargetLanguage() {
			var browserLanguage = window.navigator.language || window.navigator.userLanguage,
				geoCountryCode = geo.getCountryCode().toLowerCase();

			// Check if a browser's language is accessible
			if (typeof browserLanguage === 'string') {
				targetLanguage = browserLanguage.substr(0, 2);
				// Check if a langcode from Geo cookie is accessible
			} else if (typeof geoCountryCode === 'string') {
				targetLanguage = geoCountryCode;
				// If neither - return false
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
					if (results.success === true) {
						// Display notification
						displayNotification(results.message);

						// Save the message in cache to display until a user closes it
						cache.set(targetLanguage + 'WikiaInYourLangMessage', results.message);
					}
				}
			});
		}

		function displayNotification(message) {
			w.GlobalNotification.show(message, 'notify');

			// Track a view of the notification
			var trackingParams = {
				trackingMethod: 'ga',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.VIEW,
				label: targetLanguage + '-notification-view',
			};

			tracker.track(trackingParams);

			// Bind tracking of clicks on a link and events on close
			bindEvents();
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
			// Track closing of a notification
			var trackingParams = {
				trackingMethod: 'ga',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.CLOSE,
				label: targetLanguage + '-notification-close',
			};
			tracker.track(trackingParams);

			cache.set(targetLanguage + 'WikiaInYourLangMessage', null);
			cache.set('wikiaInYourLangNotificationShown', true);
		}

		function onLinkClick() {
			// Track a click on a notification link
			var trackingParams = {
				trackingMethod: 'ga',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: targetLanguage + '-notification-link-click',
			};

			tracker.track(trackingParams);
		}

		$(init);
	}
);
