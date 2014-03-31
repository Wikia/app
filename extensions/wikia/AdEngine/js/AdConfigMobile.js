/*global define*/

define(
	'ext.wikia.adengine.config.mobile',
	['wikia.log', 'wikia.window', 'ext.wikia.adengine.provider.directgptmobile','ext.wikia.adengine.provider.remnantgptmobile', 'ext.wikia.adengine.provider.null'],
	function (log, window, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull) {
		'use strict';

		var logGroup = 'AdConfigMobile',
			logLevel = log.levels.info;

		function getProvider(slot) {
			var slotName = slot[0];

			// if we need to hop to particular provider
			switch(slot[2]) {
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
	}
);
