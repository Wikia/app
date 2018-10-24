/*global define*/
define('ext.wikia.adEngine.slot.inContent', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.video.videoFrequencyMonitor',
	'JSMessages',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, slotsContext, videoFrequencyMonitor, msg, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContent',
		selectorArticle = '#mw-content-text > h2',
		selectorRail = '#mw-content-text > :first-child',
		inRail = adContext.get('opts.incontentPlayerRail.enabled');

	function createInContentWrapper(slotName) {
		var adHtml = doc.createElement('div'),
			label = msg('adengine-advertisement'),
			innerHTMLClass = inRail ? ' in-rail' : '';

		adHtml.id = 'INCONTENT_WRAPPER';
		adHtml.innerHTML = '<div id="' + slotName + '" class="wikia-ad hidden' + innerHTMLClass + '" data-label="' + label + '"></div>';

		return adHtml;
	}

	function insertSlot(header, slotName, onSuccessCallback) {
		var wrapper = createInContentWrapper(slotName);

		log('insertSlot', 'debug', logGroup);
		header.parentNode.insertBefore(wrapper, header);
		win.adslots2.push({
			slotName: slotName,
			onSuccess: onSuccessCallback
		});
	}

	/**
	 * Adds dynamically new slot in the right place and sends tracking data
	 */
	function init(slotName, onSuccessCallback) {
		var header = inRail ? doc.querySelectorAll(selectorRail)[0] : doc.querySelectorAll(selectorArticle)[1],
			logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')',
			slotNameGA = slotName.toLowerCase();

		if (!header) {
			logMessage = 'missing second section ' + logWikiData;
		}

		if (!slotsContext.isApplicable(slotName)) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
		}

		if (!videoFrequencyMonitor.videoCanBeLaunched()) {
			logMessage = 'video frequency capping ' + logWikiData;
		}

		if (logMessage) {
			log(slotName + ' not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('slot/' + slotNameGA + '/failed', {'reason': logMessage});
			return;
		}

		insertSlot(header, slotName, onSuccessCallback);
		adTracker.track('slot/' + slotNameGA + '/success');
	}

	return {
		init: init
	};
});
