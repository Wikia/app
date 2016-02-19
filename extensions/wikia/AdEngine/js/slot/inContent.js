/*global define*/
define('ext.wikia.adEngine.slot.inContentPlayer', [
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window'
], function (adTracker, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContent',
		selector = '#mw-content-text > h2',
		header;

	/**
	 * Adds dynamically new slot in the right place and sends tracking data
	 */
	function init(slotName) {
		var adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>',
			logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')',
			$header;

		// take 2nd header from the article
		header = $(selector)[1];
		log(header, 'debug', logGroup);

		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log(slotName + ' not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/' + slotName.toLowerCase() + '/failed', {'reason': logMessage});
			return;
		}

		$header = $(header);
		if ($header.width() < $('#mw-content-text').width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log(slotName + ' not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/' + slotName.toLowerCase() + '/failed', {'reason': logMessage});
			return;
		}

		log('insertSlot()', 'debug', logGroup);
		$header.before(adHtml);
		adTracker.track('slot/' + slotName.toLowerCase() + '/success');
		win.adslots2.push(slotName);
	}

	return {
		init: init
	};
});
