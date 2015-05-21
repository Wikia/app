/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, geo, instantGlobals, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		context = adContext.getContext(),
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
		header,
		isOasis = (context.targeting.skin === 'oasis');

	function getSlotName() {
		return slotName;
	}

	/**
	 * Oasis only method; Adds the slot if the conditions are met and sends tracking event
	 */
	function insertSlot() {
		log('insertSlot()', 'debug', logGroup);
		$(header).before(adHtml);
		trackSuccess();
		win.adslots2.push(slotName);
	}

	/**
	 * Basically checks if 2nd header in an article exists but in Oasis checks also the width of the header; + tracking
	 *
	 * @param {string} selector 2nd header selector
	 * @returns {boolean}
	 */
	function shouldInsertSlot(selector) {
		var incontentPlayerCountries = instantGlobals.wgIncontentPlayerCountries,
			logMessage,
			logWikiData = isOasis ? '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')' : '';

		if (!incontentPlayerCountries ||
			!incontentPlayerCountries.indexOf ||
			incontentPlayerCountries.indexOf(geo.getCountryCode()) === -1
		) {
			log('INCONTENT_PLAYER not added - INCONTENT_PLAYER disabled in this country', 'debug', logGroup);
			return false;
		}

		header = $(selector)[1];
		log(header, 'debug', logGroup);

		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/incontent_player/failed', {'reason': logMessage, 'isOasis': isOasis});
			return false;
		}

		if (isOasis && $(header).width() < $('#mw-content-text').width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/incontent_player/failed', {'reason': logMessage, 'isOasis': isOasis});
			return false;
		}

		return true;
	}

	function trackSuccess() {
		adTracker.track('slot/incontent_player/success', {'isOasis': isOasis});
	}

	return {
		getSlotName: getSlotName,
		insertSlot: insertSlot,
		shouldInsertSlot: shouldInsertSlot,
		trackSuccess: trackSuccess
	};
});
