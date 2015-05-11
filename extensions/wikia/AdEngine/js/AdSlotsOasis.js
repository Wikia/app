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
		context = adContext.getContext(),
		medrecId = 'TOP_RIGHT_BOXAD',
		experimentName = 'ADS_VIEWABILITY_MEDREC',
		experimentClassName = 'ads-viability-test';

	function init() {
		var elementsBeforeSlots = $(adSlotsInContent.selector).get(),
			maxSlots = 1;

		log('init()', 'debug', logGroup);
		elementsBeforeSlots.unshift(null);
		adSlotsInContent.init(elementsBeforeSlots, maxSlots);

		function isValidAbTestingGroup() {
			return !!abTest.getGroup(experimentName);
		}

		if (isValidAbTestingGroup()) {
			log([experimentName + ' turned on'], 'debug', logGroup);

			$('#' + medrecId)
				.addClass(experimentClassName)
				.addClass(abTest.getGroup(experimentName));
		} else {
			log([experimentName + ' turned off'], 'debug', logGroup);
		}
	}

	// Don't start those slots on no_ads, corporate, home etc
	if (context.opts.pageType === 'all_ads') {
		$(doc).ready(init);
	}
});
