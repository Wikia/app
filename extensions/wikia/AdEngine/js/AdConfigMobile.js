/*global define*/
define('ext.wikia.adEngine.adConfigMobile', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.provider.directGptMobile',
	'ext.wikia.adEngine.provider.remnantGptMobile',
	'ext.wikia.adEngine.provider.null'
], function (log, window, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull) {
	'use strict';

	function getProvider(slot) {
		var slotName = slot[0];

		// if we need to hop to particular provider
		switch (slot[2]) {
		case 'Null':
			return adProviderNull;
		case 'RemnantGptMobile':
			if (adProviderRemnantGpt.canHandleSlot(slotName)) {
				return adProviderRemnantGpt;
			}

			return adProviderNull;
		default:
			if (adProviderDirectGpt.canHandleSlot(slotName)) {
				return adProviderDirectGpt;
			}
		}

		return adProviderNull;

	}

	return {
		getDecorators: function () { return []; },
		getProvider: getProvider
	};
});
