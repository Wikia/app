define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.monetizationsServiceHelper',
	'jquery',
	'wikia.log',
], function (adContext, monetizationService, $, log) {
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

	function fillInSlot(slot, success, hop) {
		log(['fillInSlot', slot], 'debug', logGroup);

		var slotName = slotMap[slot],
			context = adContext.getContext();

		if (context.providers.monetizationServiceAds[slotName] && validateSlot(slot)) {
			log(['fillInSlot', slot, 'injectScript'], 'debug', logGroup);
			monetizationService.injectContent(slot, context.providers.monetizationServiceAds[slotName], success);
		} else {
			hop();
		}
	}

	function validateSlot(slot) {
		log(['validateSlot', slot], 'debug', logGroup);

		var $inContent = $('#MON_IN_CONTENT');

		if (slot === 'MON_BELOW_CATEGORY' && ($inContent.length === 0 || $inContent.hasClass('end-content'))) {
			log(['validateSlot', slot, false], 'debug', logGroup);
			return false;
		}

		log(['validateSlot', slot, true], 'debug', logGroup);
		return true;
	}

	return {
		name: 'MonetizationService',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
