/*global define*/
define('ext.wikia.adEngine.adConfigMobile', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.null',
	'ext.wikia.adEngine.provider.ebay'
], function (log, window, document, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull, adProviderEbay) {
	'use strict';

	function getProvider(slot) {
		var slotName = slot[0];

		if (slot[2] === 'Null') {
			return adProviderNull;
		}

		if (slot[2] === 'RemnantGptMobile') {
			if (adProviderRemnantGpt.canHandleSlot(slotName)) {
				return adProviderRemnantGpt;
			}
			return adProviderNull;
		}

		if (window.wgAdDriverUseEbay && adProviderEbay.canHandleSlot(slotName)) {
			document.getElementById(slotName).className += ' show';
			return adProviderEbay;
		}

		if (adProviderDirectGpt.canHandleSlot(slotName)) {
			return adProviderDirectGpt;
		}

		return adProviderNull;

	}

	return {
		getDecorators: function () { return []; },
		getProvider: getProvider
	};
});
