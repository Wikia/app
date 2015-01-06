/*global define*/
define('ext.wikia.adEngine.adDecoratorTopInContent', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adPlacementChecker'
], function (log, document, adContext, adPlacementChecker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adDecoratorTopInContent',
		slotName = 'TOP_INCONTENT_BOXAD';

	function doesNotBreakContent() {

		var adPlace,
			fakeAdId = 'fake-top-incontent-boxad',
			fakeAdStyle = 'float: right; height: 250px; margin: 0 0 10px 10px; width: 300px',
			fakeAdHtml = '<div id="' + fakeAdId + '" style="' + fakeAdStyle + '"></div>',
			contentDiv,
			fakeAd,
			result;

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

	/**
	 * fillInSlot decorator. Returns function to call instead.
	 *
	 * @returns {function}
	 */
	function decorator(fillInSlot) {
		log(['decorator', fillInSlot], 'debug', logGroup);

		return function (decoratedSlot) {
			log(['decorated', decoratedSlot], 'debug', logGroup);

			var decoratedSlotName = decoratedSlot[0];

			if (slotName !== decoratedSlotName) {
				return fillInSlot(decoratedSlot);
			}

			if (doesNotBreakContent()) {
				return fillInSlot(decoratedSlot);
			}

			log(['decorated', decoratedSlot, 'return null'], 'debug', logGroup);
			return;
		};
	}

	return decorator;
});
