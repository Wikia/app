/*global define*/
define('ext.wikia.adEngine.adInContentPlayer', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageDimensions',
	'ext.wikia.adEngine.adTracker',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adLogicPageDimensions, adTracker, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInContentPlayer',
		context = adContext.getContext(),
		slotName = 'INCONTENT_PLAYER',
		adHtml = '<div id="' + slotName + '" class="wikia-ad default-height"></div>';

	function init() {
		var articleContainer,
			header,
			$header,
			logMessage,
			logWikiData = '(wikiId: ' + win.wgCityId + ' articleId: ' + win.wgArticleId + ')';

		log('INCONTENT_PLAYER: init()', 'debug', logGroup);

		articleContainer = $('#mw-content-text');
		header = $(articleContainer).find('> h2')[1];
		if (!header) {
			logMessage = 'no second section in the article ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('incontent_slot_player/insertion/failed', {'reason': logMessage});
			return;
		}
		log(header, 'debug', logGroup);

		$header = $(header);
		if (context.targeting.skin === 'oasis' && $header.width() < articleContainer.width()) {
			logMessage = '2nd section in the article is not full width ' + logWikiData;
			log('INCONTENT_PLAYER not added - ' + logMessage, 'debug', logGroup);
			adTracker.track('incontent_slot_player/insertion/failed', {'reason': logMessage});
			return;
		}

		$header.before(adHtml);
		adTracker.track('incontent_slot_player/insertion/success');
		win.adslots2.push(slotName);
	}

	return {
		init: init
	};
});
