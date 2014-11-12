/*global define*/
define('ext.wikia.adEngine.slot.topInContentBoxad', [
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
			contentDiv;

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
		result = adPlacementChecker.doesAdFit([300, 250], contentDiv) ;

		if (result) {
			adPlace = contentDiv.parentNode.querySelector('.home-top-right-ads');
			adPlace.className += ' top-right-ads-in-content';
		}

		log(['doesNotBreakContent result', result], 'debug', logGroup);
		return result;

	}

	function init() {
		log(['init', slotName], 'debug', logGroup);

		eventDispatcher.bind('ext.wikia.adEngine.adDecoratorPageDimensions fillInSlot', doesNotBreakContent);
	}

	return {
		init: init
	};
});
