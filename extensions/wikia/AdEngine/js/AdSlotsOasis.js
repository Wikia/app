/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adSlotsInContent',
	'jquery',
	'wikia.document'
], function (adContext, adSlotsInContent, $, doc) {
	'use strict';

	function init() {
		var elementsBeforeSlots = $(adSlotsInContent.selector).get(),
			maxSlots = 1;
		elementsBeforeSlots.unshift(null);
		adSlotsInContent.init(elementsBeforeSlots, maxSlots);
	}

	var context = adContext.getContext();

	// Don't start those slots on no_ads, corporate, home etc
	if (context.opts.pageType === 'all_ads') {
		$(doc).ready(init);
	}
});
