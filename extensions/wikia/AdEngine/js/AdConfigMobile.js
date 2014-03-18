/*global define*/

define(
	'ext.wikia.adengine.config.mobile',
	['wikia.log', 'wikia.window', 'ext.wikia.adengine.provider.gptmobile','ext.wikia.adengine.provider.remnantdartmobile', 'ext.wikia.adengine.provider.null'],
	function (log, window, adProviderGpt, adProviderRemnantDart, adProviderNull) {
		'use strict';

		var slotTried = {},
			logGroup = 'AdConfigMobile',
			logLevel = log.levels.info;

		function registerProvider(slotName, adProvider) {
			log( slotName + ' slot will be handled by ' + adProvider.name, logLevel, logGroup );
			slotTried[slotName + adProvider.name] = true;

			return adProvider;
		}

		function getProvider(slot) {
			var slotName = slot[0];

			// if we need to hop to particular provider
			switch(slot[2]) {
				case 'Null':
					return registerProvider(slotName, adProviderNull);
				case 'RemnantDartMobile':
					return registerProvider(slotName, adProviderRemnantDart);
				default:
					// ordinary way
					if (!slotTried[slotName + 'GptMobile'] && adProviderGpt.canHandleSlot(slotName)) {
						return registerProvider(slotName, adProviderGpt);
					}

					if (window.wgEnableRHonMobile && !slotTried[slotName + 'RemnantDartMobile'] && adProviderRemnantDart.canHandleSlot(slotName)) {
						return registerProvider(slotName, adProviderRemnantDart);
					}

					return registerProvider(slotName, adProviderNull);
			}
		}

		return {
			getDecorators: function () { return []; },
			getProvider: getProvider
		};
	}
);
