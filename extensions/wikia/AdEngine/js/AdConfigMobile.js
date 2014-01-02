var AdConfigMobile = function (
	adProviderGpt,
	adProviderNull
) {
	'use strict';

	function getProvider(slot) {
		if (slot[2] === 'Liftium') {
			return adProviderNull;
		}
		return adProviderGpt;
	}

	return {
		getDecorators: function () {return [];},
		getProvider: getProvider
	};
};
