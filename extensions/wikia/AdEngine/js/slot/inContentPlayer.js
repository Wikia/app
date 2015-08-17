/*global define*/
define('ext.wikia.adEngine.slot.inContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.geo',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, geo, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContentPlayer',
		selector = '#mw-content-text > h2',
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
		context = adContext.getContext(),
		header;

	/**
	 * If conditions are met adds dynamically new slot in the right place and sends tracking data
	 */
	function init() {
		var logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')',
			$header;

		if (!context.slots.incontentPlayer) {
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
