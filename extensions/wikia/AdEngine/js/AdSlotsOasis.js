/*global require*/
require([
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adPlacementChecker',
	'ext.wikia.adEngine.adSlotsInContent'
], function (log, document, adContext, adPlacementChecker, adSlotsInContent) {
	'use strict';
	var elementsBeforeSlots = $(adSlotsInContent.selector);

	function doesNotBreakContent() {
		var adPlace,
			fakeAdId = 'fake-top-incontent-boxad',
			fakeAdStyle = 'float: right; height: 250px; margin: 0 0 10px 10px; width: 300px',
			fakeAdHtml = '<div id="' + fakeAdId + '" style="' + fakeAdStyle + '"></div>',
			contentDiv,
			fakeAd,
			result,
			logGroup = 'ext.wikia.adEngine.adDecoratorTopInContent';

		if (!adContext.getContext().targeting.pageIsArticle) {
			log(['doesNotBreakContent result', false, 'Page is not an article'], 'debug', logGroup);

			return false;
		}

		contentDiv = document.getElementById('mw-content-text');
		result = adPlacementChecker.injectAdIfMedrecFits(fakeAdHtml, contentDiv);

		if (result) {
			fakeAd = document.getElementById(fakeAdId);
			fakeAd.parentNode.removeChild(fakeAd);
			adPlace = contentDiv.parentNode.querySelector('.home-top-right-ads');
			adPlace.className += ' top-right-ads-in-content';
		}

		log(['doesNotBreakContent result', result], 'debug', logGroup);
		return result;

	}

	if (doesNotBreakContent()) {
		//adding null element will cause the ad slot to render on the
		// top of the zero section
		elementsBeforeSlots = elementsBeforeSlots.get();
		elementsBeforeSlots.unshift(null);
	}

	adSlotsInContent.init(elementsBeforeSlots);
});
