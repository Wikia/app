/*global require*/
require([
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adPlacementChecker',
	'ext.wikia.adEngine.eventDispatcher'
], function (log, document, adContext, adPlacementChecker, eventDispatcher) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.topInContentBoxad',
		slotName = 'TOP_INCONTENT_BOXAD',
		result = null;

	function doesNotBreakContent(slot) {

		var adPlace,
			fakeAdId = 'fake-top-incontent-boxad',
			fakeAdStyle = 'float: right; height: 250px; margin: 0 0 10px 10px; width: 300px',
			fakeAdHtml = '<div id="' + fakeAdId + '" style="' + fakeAdStyle + '"></div>',
			contentDiv,
			fakeAd;

		if (slotName !== slot[0]) {
			return true;
		}

		if (result !== null) {
			log(['doesNotBreakContent result', result], 'debug', logGroup);

			return result;
		}

		if (!adContext.getContext().targeting.pageIsArticle) {
			log(['doesNotBreakContent result', false, 'Page is not an article'], 'debug', logGroup);

			return false;
		}

		contentDiv = document.getElementById('mw-content-text');
		result = adPlacementChecker.injectAdIfItFits(fakeAdHtml, contentDiv);

		if (result) {
			fakeAd = document.getElementById(fakeAdId);
			fakeAd.parentNode.removeChild(fakeAd);
			adPlace = contentDiv.parentNode.querySelector('.home-top-right-ads');
			adPlace.className += ' top-right-ads-in-content';
		}

		log(['doesNotBreakContent result', result], 'debug', logGroup);
		return result;

	}

	eventDispatcher.bind('ext.wikia.adEngine.adDecoratorPageDimensions fillInSlot', doesNotBreakContent);
});
