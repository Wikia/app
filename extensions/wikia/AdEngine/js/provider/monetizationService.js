define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.monetizationsServiceHelper',
	'jquery',
	'wikia.log',
	'wikia.nirvana',
	'wikia.window',
], function (adContext, monetizationService, $, log, nirvana, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.monetizationService',
		isLoaded = false,
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

		if (!isLoaded) {
			log(['fillInSlot', slot, 'getModules'], 'debug', logGroup);
			getModules(success, hop);
			isLoaded = true;
		}
	}

	function getModules(success, hop) {
		log(['getModules', 'Send request'], 'debug', logGroup);
		nirvana.getJson(
			'MonetizationModule',
			'getModules',
			{
				adEngine: true,
				articleId: window.wgArticleId,
				fromSearch: window.fromsearch,
				max: monetizationService.getMaxAds(),
				geo: monetizationService.getCountryCode()
			}
		).done(function (json) {
			var modules = json.data;
			if (modules) {
				$.each(slotMap, function (slot, slotName) {
					if (modules[slotName] && validateSlot(slotName)) {
						log(['getModules', slot, 'injectScript'], 'debug', logGroup);
						monetizationService.injectContent(slot, modules[slotName], success);
					} else {
						log(['getModules', slot, 'Empty data'], 'debug', logGroup);
						hop();
					}
				});
			}
		});
	}

	function validateSlot(slot) {
		log(['validateSlot', slot], 'debug', logGroup);

		if (slot === 'MON_BELOW_CATEGORY' && $('#MON_IN_CONTENT').hasClass('end-content')) {
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
