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
		'BannerNotification'
	],
	function ($, mw, w, geo, cache, tracker, BannerNotification) {
		'use strict';

		// Get user's geographic data and a country code
		var targetLanguage = getTargetLanguage(),
			// Per request we should unify dialects like pt and pt-br
			// @see CE-1220
			contentLanguage = w.wgContentLanguage.split('-')[0],
			// Cache version
			cacheVersion = '1.01',
			// LinkTitle from Cache
			linkTitle = retrieveLinkTitle();

		function init() {
			if (targetLanguage !== false && targetLanguage !== contentLanguage) {
				// Check local browser cache to see if a request has been sent
				// in the last month and if the notification has been shown to him.
				// Both have to be !== true to continue.
				if (cache.get(getWIYLRequestSentKey()) !== true &&
					cache.get(getWIYLNotificationShownKey()) !== true) {
					getNativeWikiaInfo();
				} else if (typeof cache.get(getWIYLMessageKey()) === 'string') {
					displayNotification(cache.get(getWIYLMessageKey()));
				}
			}
		}

		function getTargetLanguage() {
			var browserLanguage = window.navigator.language || window.navigator.userLanguage,
				geoCountryCode = geo.getCountryCode().toLowerCase(),
				targetLanguage;

			if (w.wgUserName !== null) {
				// Check if a user is logged and if so - use a lang from settings
				targetLanguage = w.wgUserLanguage;
			} else if (typeof browserLanguage === 'string') {
				// Check if a browser's language is accessible
				targetLanguage = browserLanguage.split('-')[0];
			} else if (typeof geoCountryCode === 'string') {
				// Check if a langcode from Geo cookie is accessible
				targetLanguage = geoCountryCode;
			} else {
				// If neither - return false
				targetLanguage = false;
			}

			// Per request we should unify dialects like pt and pt-br
			// @see CE-1220
			return targetLanguage.split('-')[0];
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
					targetLanguage: targetLanguage,
					articleTitle: w.wgTitle
				},
				callback: function (results) {
					if (results.success === true) {
						// Display notification
						displayNotification(results.message);

						// Save link address if it is different from this article title
						saveLinkTitle(results.linkAddress);
						// Re-initialize linkTitle with linkAddress
						linkTitle = retrieveLinkTitle();

						// Update JS cache and set the notification shown indicator to true
						// Cache for a day
						cache.set(getWIYLRequestSentKey(), true, cache.CACHE_STANDARD);

						// Save the message in cache to display until a user closes it
						// Cache for a day
						cache.set(
							getWIYLMessageKey(),
							results.message,
							cache.CACHE_STANDARD
						);
					}
				}
			});
		}

		function displayNotification(message) {
			var bannerNotification = new BannerNotification(message, 'notify').show(),
				// Track a view of the notification
				trackingParams = {
					trackingMethod: 'analytics',
					category: 'wikia-in-your-lang',
					action: tracker.ACTIONS.VIEW,
					label: targetLanguage + '-notification-view'
				};

			tracker.track(trackingParams);

			// Bind tracking of clicks on a link and events on close
			bindEvents(bannerNotification);
		}

		function bindEvents(bannerNotification) {
			bannerNotification
				.onClose(onNotificationClosed);
			bannerNotification
				.$element
				.on('click', '.text', onLinkClick);
		}

		function onNotificationClosed() {
			// Track closing of a notification
			var trackingParams = {
				trackingMethod: 'analytics',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.CLOSE,
				label: targetLanguage + '-notification-close',
			};
			tracker.track(trackingParams);

			cache.set(getWIYLMessageKey(), null);
			// Cache for a month
			cache.set(getWIYLNotificationShownKey(), true, cache.CACHE_LONG);
		}

		function onLinkClick() {
			// Track a click on a notification link
			var trackingParams = {
				trackingMethod: 'analytics',
				category: 'wikia-in-your-lang',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: targetLanguage + '-notification-link-click',
			};

			tracker.track(trackingParams);
		}

		function getWIYLRequestSentKey() {
			return 'wikiaInYourLangRequestSent' + linkTitle + cacheVersion;
		}

		function getWIYLNotificationShownKey() {
			return 'wikiaInYourLangNotificationShown' + linkTitle + cacheVersion;
		}

		function getWIYLMessageKey() {
			return targetLanguage + 'WikiaInYourLangMessage' + linkTitle + cacheVersion;
		}

		function getWIYLLinkTitlesKey() {
			return targetLanguage + 'WikiaInYourLangLinkTitles' + cacheVersion;
		}

		function saveLinkTitle(linkAddress) {
			var articleTitle = w.wgTitle,
				linkAddressAry = linkAddress.split('/'),
				listOfCachedTitles = {},
				linkTitle = linkAddressAry[linkAddressAry.length - 1].length === 0 ? 'main' : linkAddressAry[linkAddressAry.length - 1];

			listOfCachedTitles = cache.get(getWIYLLinkTitlesKey());
			if ( !listOfCachedTitles ) {
				listOfCachedTitles = {};
			}
			listOfCachedTitles[articleTitle] = linkTitle;

			cache.set(getWIYLLinkTitlesKey(),listOfCachedTitles, cache.CACHE_LONG);
		}

		/**
		 * Retrieve linkTitle for this articleTitle from cache.
		 * articleTitle is a current article title of this wiki.
		 * linkTitle is wikia-in-your-lang link's article title, which may or may not be the same as the articleTitle.
		 * listOfCachedTitles is a map of articleTitle => linkTitle
		 * @returns {
		 *   linkTitle string: wikia-in-your-lang link's article title
		 * }
		 */
		function retrieveLinkTitle() {
			var articleTitle = w.wgTitle,
				listOfCachedTitles = cache.get(getWIYLLinkTitlesKey());
			return (listOfCachedTitles && listOfCachedTitles[articleTitle]) ? listOfCachedTitles[articleTitle] : '';
		}

		if (!w.wikiaPageIsCorporate) {
			$(init);
		}
	}
);
