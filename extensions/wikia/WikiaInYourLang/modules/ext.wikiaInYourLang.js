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
			contentLanguage = w.wgContentLanguage,
			// Cache version
			cacheVersion = '1.02',
			// LinkTitle from Cache
			linkTitle = retrieveLinkTitle();

		function init() {
			var interlangExist = false;
			if (targetLanguage !== false &&
				shouldShowWikiaInYourLang(targetLanguage, contentLanguage) &&
				cache.get(getWIYLNotificationShownKey()) !== true
			) {
				// Check local browser cache to see if a request has been sent
				// in the last month
				if (cache.get(getWIYLRequestSentKey()) !== true) {
					interlangExist = getInterlangFromArticleInterlangList();
					if (!interlangExist) {
						getNativeWikiaInfo();
					}
				} else if (typeof cache.get(getWIYLMessageKey()) === 'string') {
					displayNotification(cache.get(getWIYLMessageKey()));
				}
			}
		}

		// Per request we should unify dialects like pt and pt-br
		// Feature is enabled only for languages in targetLanguageFilter
		// @see CE-1220
		// @see INT-302
		function shouldShowWikiaInYourLang(targetLanguage, contentLanguage) {
			var targetLanguageLangCode = targetLanguage.split('-')[0],
				contentLanguageLangCode = contentLanguage.split('-')[0],
				targetLanguageFilter = [ 'zh', 'ko', 'vi', 'ru', 'ja'];

			if (targetLanguageFilter.indexOf(targetLanguageLangCode) === -1) {
				return false;
			}

			return targetLanguageLangCode !== contentLanguageLangCode;
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
			return targetLanguage;
		}

		function getInterlangFromArticleInterlangList() {
			var i, interlangData;
			if (Array.isArray(w.wgArticleInterlangList)) {
				for(i = 0; i < w.wgArticleInterlangList.length; i++) {
					interlangData = w.wgArticleInterlangList[i].split(':');
					if (targetLanguage === interlangData[0]) {
						//we have interlang for this user. Pass the interlang article title
						getNativeWikiaInfo(interlangData[1]);
						return true;
					}
				}
			}
			return false;
		}

		function getNativeWikiaInfo(interlangTitle) {
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
					articleTitle: w.wgPageName,
					interlangTitle: interlangTitle
				},
				callback: function (results) {
					if (results.success === true) {
						// Save link address if it is different from this article title
						saveLinkTitle(results.linkAddress);
						// Re-initialize linkTitle with linkAddress
						linkTitle = retrieveLinkTitle();

						// Display notification
						displayNotification(results.message);

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
				label = getTrackingLabel('notification-view'),
			// Track a view of the notification
				trackingParams = {
					trackingMethod: 'analytics',
					category: 'wikia-in-your-lang',
					action: tracker.ACTIONS.VIEW,
					label: label
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
			var label = getTrackingLabel('notification-close'),
				trackingParams = {
					trackingMethod: 'analytics',
					category: 'wikia-in-your-lang',
					action: tracker.ACTIONS.CLOSE,
					label: label,
				};
			tracker.track(trackingParams);

			cache.set(getWIYLMessageKey(), null);
			// Cache for a month
			cache.set(getWIYLNotificationShownKey(), true, cache.CACHE_LONG);
		}

		function onLinkClick() {
			// Track a click on a notification link
			var label = getTrackingLabel('notification-link-click'),
				trackingParams = {
					trackingMethod: 'analytics',
					category: 'wikia-in-your-lang',
					action: tracker.ACTIONS.CLICK_LINK_TEXT,
					label: label,
				};
			tracker.track(trackingParams);
		}

		function getWIYLRequestSentKey() {
			return 'wikiaInYourLangRequestSent' + linkTitle + cacheVersion;
		}

		function getWIYLNotificationShownKey() {
			return 'wikiaInYourLangNotificationShown' + cacheVersion;
		}

		function getWIYLMessageKey() {
			return targetLanguage + 'WikiaInYourLangMessage' + linkTitle + cacheVersion;
		}

		function getWIYLLinkTitlesKey() {
			return targetLanguage + 'WikiaInYourLangLinkTitles' + cacheVersion;
		}

		function saveLinkTitle(linkAddress) {
			var articleTitle = w.wgPageName,
				linkAddressAry = linkAddress.match(/.+\.com\/wiki\/(.*)/),
				listOfCachedTitles = {},
				linkTitle = '';

			if ( linkAddressAry && linkAddressAry.length > 1 ) {
				linkTitle = linkAddressAry[1];
			} else {
				linkTitle = 'main';
			}

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
		 * @returns {string} wikia-in-your-lang link's article title
		 */
		function retrieveLinkTitle() {
			var articleTitle = w.wgPageName,
				listOfCachedTitles = cache.get(getWIYLLinkTitlesKey());
			return (listOfCachedTitles && listOfCachedTitles[articleTitle]) ? listOfCachedTitles[articleTitle] : '';
		}

		function getTrackingLabel(postfix) {
			var label = targetLanguage;
			if ( linkTitle.length > 0 && linkTitle != 'main' ) {
				label += '-article';
			}
			label += '-' + postfix;
			return label;
		}

		if (!w.wikiaPageIsCorporate) {
			$(init);
		}
	}
);
