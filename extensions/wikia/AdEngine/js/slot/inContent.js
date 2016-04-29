/*global define*/
define('ext.wikia.adEngine.slot.inContent', [
	'ext.wikia.adEngine.adTracker',
	'JSMessages',
	'wikia.log',
	'wikia.window'
], function (adTracker, msg, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContent',
		selector = '#mw-content-text > h2',
		header;

	/**
	 * Adds dynamically new slot in the right place and sends tracking data
	 */
	function init(slotName, onSuccessCallback) {
		var adHtml = '<div id="INCONTENT_WRAPPER"><div id="' + slotName + '" class="wikia-ad default-height" data-label="' + msg('adengine-advertisement') + '"></div></div>',
			logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')',
			$header,
			slotNameGA;

		if (!slotName) {
			log('slotName is falsy', 'error', logGroup);
			return;
		}

		slotNameGA = slotName.toLowerCase();

		// take 2nd header from the article
		header = $(selector)[1];
		log(header, 'debug', logGroup);

		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log(slotName + ' not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/' + slotNameGA + '/failed', {'reason': logMessage});
			return;
		}

		$header = $(header);
		if ($header.width() < $('#mw-content-text').width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log(slotName + ' not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/' + slotNameGA + '/failed', {'reason': logMessage});
			return;
		}

		log('insertSlot()', 'debug', logGroup);
		$header.before(adHtml);
		adTracker.track('slot/' + slotNameGA + '/success');
		win.adslots2.push({
			slotName: slotName,
			onSuccess: onSuccessCallback
		});
	}

	return {
		init: init
	};
});
