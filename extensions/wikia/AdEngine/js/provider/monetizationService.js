/*global define*/
define('ext.wikia.adEngine.provider.monetizationService', [
	'ext.wikia.adEngine.provider.monetizationService.helper',
	'wikia.log',
	'wikia.nirvana',
	'wikia.window'
], function (monetizationServiceHelper, log, nirvana, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.monetizationService',
		slotMap = {
			MON_ABOVE_TITLE: 'above_title',
			MON_BELOW_TITLE: 'below_title',
			MON_IN_CONTENT: 'in_content',
			MON_BELOW_CATEGORY: 'below_category',
			MON_ABOVE_FOOTER: 'above_footer',
			MON_FOOTER: 'footer'
		},
		modules;

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);

		if (slotMap[slotName]) {
			log(['canHandleSlot', slotName, true], 'debug', logGroup);
			return true;
		}

		log(['canHandleSlot', slotName, false], 'debug', logGroup);
		return false;
	}

	function initialize(success) {
		log(['initialize', 'send request'], 'debug', logGroup);
		nirvana.getJson(
			'MonetizationModule',
			'getModules',
			{
				adEngine: true,
				articleId: window.wgArticleId, // TODO: use ad context
				fromSearch: window.fromsearch, // TODO: convert window.fromsearch to a module
				max: monetizationServiceHelper.getMaxAds(),
				geo: monetizationServiceHelper.getCountryCode()
			}
		).done(function (json) {
			modules = json.data;
			success();
		});
	}

	function fillInSlot(slotName, slotElement, success, hop) {
		log(['fillInSlot', slotName, slotElement], 'debug', logGroup);

		var moduleContent = modules[slotMap[slotName]];

		if (moduleContent) {
			log(['fillInSlot', slotName, 'injectContent'], 'debug', logGroup);
			monetizationServiceHelper.injectContent(slotElement, moduleContent, success);
		} else {
			log(['fillInSlot', slotName, 'empty data'], 'debug', logGroup);
			hop();
		}
	}

	return {
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot,
		initialize: initialize,
		name: 'MonetizationService'
	};
});
