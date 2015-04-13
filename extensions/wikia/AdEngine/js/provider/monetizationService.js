define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.monetizationsServiceHelper',
	'jquery',
	'wikia.log',
	'wikia.scriptwriter',
], function (adContext, monetizationService, $, log, scriptWriter) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.monetizationService',
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

	function fillInSlot(slot, success) {
		log(['fillInSlot', slot], 'info', logGroup);

		var slotName = slotMap[slot],
			context = adContext.getContext();

		if (context.providers.monetizationServiceAds[slotName]) {
			log(['fillInSlot', slot, 'injectScript'], 'info', logGroup);

			monetizationService.loadAssets();

			scriptWriter.injectScriptByText(slot, context.providers.monetizationServiceAds[slotName], function () {
				success();
			});
		}
	}

	return {
		name: 'MonetizationService',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
