/*global define*/
define('ext.wikia.adEngine.adConfigMobile', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.null'
], function (log, window, document, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull) {
	'use strict';

	function getProvider(slot) {
		var slotName = slot[0];

		// If wgShowAds set to false, hide slots
		if (!window.wgShowAds) {
			return adProviderNull;
		}

		if (slot[2] === 'Null') {
			return adProviderNull;
		}

		if (slot[2] === 'RemnantGptMobile') {
			if (adProviderRemnantGpt.canHandleSlot(slotName)) {
				return adProviderRemnantGpt;
			}
			return adProviderNull;
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
