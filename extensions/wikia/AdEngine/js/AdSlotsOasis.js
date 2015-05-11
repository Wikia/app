/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adSlotsInContent',
	'jquery',
	'wikia.document',
	'wikia.abTest',
	'wikia.log'
], function (adContext, adSlotsInContent, $, doc, abTest, log) {
	'use strict';

	var logGroup = 'AdSlotOasis.js',
		context = adContext.getContext();

	function init() {
		var elementsBeforeSlots = $(adSlotsInContent.selector).get(),
			maxSlots = 1;

		log('init()', 'debug', logGroup);
		elementsBeforeSlots.unshift(null);
		adSlotsInContent.init(elementsBeforeSlots, maxSlots);
	}

	// Don't start those slots on no_ads, corporate, home etc
	if (context.opts.pageType === 'all_ads') {
		$(doc).ready(init);
	}
});
