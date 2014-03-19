/*global define*/

define(
	'ext.wikia.adengine.config.mobile',
	['wikia.log', 'wikia.window', 'ext.wikia.adengine.provider.directgptmobile','ext.wikia.adengine.provider.remnantgptmobile', 'ext.wikia.adengine.provider.null'],
	function (log, window, adProviderDirectGpt, adProviderRemnantGpt, adProviderNull) {
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
				case 'RemnantGptMobile':
					return registerProvider(slotName, adProviderRemnantGpt);
				default:
					// ordinary way
					if (!slotTried[slotName + adProviderDirectGpt.name] && adProviderDirectGpt.canHandleSlot(slotName)) {
						return registerProvider(slotName, adProviderDirectGpt);
					}

					if (window.wgEnableRHonMobile && !slotTried[slotName + adProviderRemnantGpt.name] && adProviderRemnantGpt.canHandleSlot(slotName)) {
						return registerProvider(slotName, adProviderRemnantGpt);
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
