/*global require*/
require([
	'jquery',
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adPlacementChecker',
	'ext.wikia.adEngine.adSlotsInContent'
], function ($, log, doc, adContext, adPlacementChecker, adSlotsInContent) {
	'use strict';

	function init () {
		var elementsBeforeSlots = $(adSlotsInContent.selector).get(),
			maxSlots = 1;
		elementsBeforeSlots.unshift(null);
		adSlotsInContent.init(elementsBeforeSlots, maxSlots);
	}

	if (adContext.getContext().opts.pageType !== 'corporate') {
		$(doc).ready(init);
	}
});
