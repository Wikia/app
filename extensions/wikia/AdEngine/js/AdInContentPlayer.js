/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adTracker',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (adTracker, geo, instantGlobals, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		selector = '#mw-content-text > h2',
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
		header;

	/**
	 * If conditions are met adds dynamically new slot in the right place and sends tracking data
	 */
	function init() {
		var incontentPlayerCountries = instantGlobals.wgAdDriverIncontentPlayerSlotCountries,
			logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')',
			$header;

		if (!incontentPlayerCountries ||
			!incontentPlayerCountries.indexOf ||
			incontentPlayerCountries.indexOf(geo.getCountryCode()) === -1
		) {
			log('INCONTENT_PLAYER not added - INCONTENT_PLAYER disabled in this country', 'debug', logGroup);
			return;
		}

		// take 2nd header from the article
		header = $(selector)[1];
		log(header, 'debug', logGroup);

		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/incontent_player/failed', {'reason': logMessage});
			return;
		}

		$header = $(header);
		if ($header.width() < $('#mw-content-text').width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/incontent_player/failed', {'reason': logMessage});
			return;
		}

		log('insertSlot()', 'debug', logGroup);
		$header.before(adHtml);
		adTracker.track('slot/incontent_player/success');
		win.adslots2.push(slotName);
	}

	return {
		init: init
	};
});
