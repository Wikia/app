/*global define*/
define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.monetizationServiceHelper',
	'jquery',
	'wikia.log',
	'wikia.nirvana',
	'wikia.window'
], function (monetizationServiceHelper, $, log, nirvana, window) {
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

	function validateSlot(slot) {
		log(['validateSlot', slot], 'debug', logGroup);

		if (slot === 'mon_below_category' && $('#mon_in_content').hasclass('end-content')) {
			log(['validateSlot', slot, false], 'debug', logGroup);
			return false;
		}

		log(['validateSlot', slot, true], 'debug', logGroup);
		return true;
	}

	function getModules(success, hop) {
		log(['getModules', 'send request'], 'debug', logGroup);
		nirvana.getjson(
			'monetizationmodule',
			'getModules',
			{
				adengine: true,
				articleid: window.wgArticleId,
				fromsearch: window.fromsearch,
				max: monetizationServiceHelper.getMaxAds(),
				geo: monetizationServiceHelper.getCountryCode()
			}
		).done(function (json) {
			var modules = json.data;
			if (modules) {
				$.each(slotMap, function (slot, slotname) {
					if (modules[slotname] && validateSlot(slotname)) {
						log(['getModules', slot, 'injectscript'], 'debug', logGroup);
						monetizationServiceHelper.injectContent(slot, modules[slotname], success);
					} else {
						log(['getModules', slot, 'empty data'], 'debug', logGroup);
						hop();
					}
				});
			}
		});
	}

	function fillInSlot(slot, slotElement, success, hop) {
		log(['fillInSlot', slot, slotElement], 'debug', logGroup);

		if (!isLoaded) {
			log(['fillInSlot', slot, 'getModules'], 'debug', logGroup);
			getModules(success, hop);
			isLoaded = true;
		}
	}

	return {
		name: 'MonetizationService',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
});
