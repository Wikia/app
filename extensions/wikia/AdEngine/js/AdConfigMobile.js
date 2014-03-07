/*global define*/

define(
	'ext.wikia.adengine.config.mobile',
	['ext.wikia.adengine.provider.gptmobile', 'ext.wikia.adengine.provider.null'],
	function (adProviderGpt, adProviderNull) {
		'use strict';

		function getProvider(slot) {
			if (slot[2] === 'Null') {
				return adProviderNull;
			}
			if (adProviderGpt.canHandleSlot(slot[0])) {
				return adProviderGpt;
			}
			return adProviderNull;
		}

		return {
			getDecorators: function () { return []; },
			getProvider: getProvider
		};
	}
);
