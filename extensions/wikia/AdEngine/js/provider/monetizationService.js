define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.monetizationsServiceHelper',
	'wikia.log',
], function (adContext, monetizationService, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.monetizationService',
		isLoaded = false,
		slotInContent = 'MON_IN_CONTENT',
		slotMap = {
			MON_ABOVE_TITLE: 'above_title',
			MON_BELOW_TITLE: 'below_title',
			MON_IN_CONTENT: 'in_content',
			MON_BELOW_CATEGORY: 'below_category',
			MON_ABOVE_FOOTER: 'above_footer',
			MON_FOOTER: 'footer'
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);

		if (slotMap[slotName]) {
			log(['canHandleSlot', slotName, true], 'debug', logGroup);
			return true;
		}

		log(['canHandleSlot', slotName, false], 'debug', logGroup);
		return false;
	}

	function fillInSlot(slot, success, hop) {
		log(['fillInSlot', slot], 'debug', logGroup);

		var slotName = slotMap[slot],
			context = adContext.getContext();

		init();

		if (context.providers.monetizationServiceAds[slotName] && monetizationService.validateSlot(slotName)) {
			log(['fillInSlot', slot, 'injectScript'], 'debug', logGroup);
			monetizationService.injectContent(slot, context.providers.monetizationServiceAds[slotName], success);
		} else {
			hop();
		}
	}

	function init() {
		if (isLoaded) {
			return;
		}

		var slotName = slotMap[slotInContent];

		if (adContext.getContext().providers.monetizationServiceAds[slotName]) {
			log(['init', 'addInContentSlot', slotInContent], 'info', logGroup);
			monetizationService.addInContentSlot(slotInContent);
		}

		isLoaded = true;
	}

	return {
		name: 'MonetizationService',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
