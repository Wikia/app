var Ad = Ad || {};

Ad.Logic = (function (
	// dependencies
	Util, Wikia,

	// providers
	ProviderEvolve,
	ProviderOldAdDriver,

	// undefined variable
	undef
) {
	'use strict';

	var getCountry = function () {
			var qs = new Wikia.Querystring()
				, countryInUrl = qs.getVal('usegeo', null)
				, cookie = decodeURIComponent(Wikia.Cookies.get('Geo'));

			if (countryInUrl) {
				return countryInUrl;
			}

			if (cookie) {
				try {
					return JSON.parse(cookie).country;
				} catch (e) {
				}
			}
			return 'error';
		}
		, evolveSlots = {
			'HOME_TOP_LEADERBOARD': true,
			'HOME_TOP_RIGHT_BOXAD': true,
			'LEFT_SKYSCRAPER_2': true,
			'TOP_LEADERBOARD': true,
			'TOP_RIGHT_BOXAD': false
		}
		, getProviderForSlot = function(slotName) {
			Util.log('getProviderForSlot', slotName);
			var country = getCountry();
			if ((country === 'AU' || country === 'CA') && evolveSlots[slotName]) {
				return ProviderEvolve;
			}
			return ProviderOldAdDriver;
		};

	return {
		getProviderForSlot: getProviderForSlot
	};
}(
	// dependencies
	Ad.Util, window.Wikia,

	// providers
	Ad.ProviderEvolve,
	Ad.ProviderOldAdDriver
));
