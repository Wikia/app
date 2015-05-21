/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		context = adContext.getContext(),
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>';

	function init() {
		log('INCONTENT_PLAYER: init()', 'debug', logGroup);

		var $header,
			articleContainer,
			header,
			headersSelector,
			logMessage,
			logWikiData,
			isOasis = (context.targeting.skin === 'oasis');

		articleContainer = isOasis ? $('#mw-content-text') : $('.article-body')[0];
		headersSelector = isOasis ? '> h2' : 'h2';
		logWikiData = isOasis ? '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')' : '';

		header = $(articleContainer).find(headersSelector)[1];
		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('incontent_slot_player/insertion/failed', {'reason': logMessage, 'isOasis': isOasis});
			return;
		}
		log(header, 'debug', logGroup);

		$header = $(header);
		if (isOasis && $header.width() < articleContainer.width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('incontent_slot_player/insertion/failed', {'reason': logMessage, 'isOasis': isOasis});
			return;
		}

		$header.before(adHtml);
		adTracker.track('incontent_slot_player/insertion/success', {'isOasis': isOasis});

		if (isOasis) {
			win.adslots2.push(slotName);
		}
	}

	return {
		init: init
	};
});
