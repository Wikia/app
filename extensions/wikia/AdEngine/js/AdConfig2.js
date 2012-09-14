window.AdConfig2 = function (
	// regular dependencies
	log, Wikia, window,

	// AdProviders
	AdProviderGamePro,
	AdProviderEvolve,
	AdProviderEvolveRS,
	AdProviderAdDriver2,
	AdProviderAdDriver,
	AdProviderLiftium2
) {
	var _cache_geo = null;

	function getProvider(slot) {
		log('getProvider', 5, 'AdConfig2');
		log(slot, 5, 'AdConfig2');


		// To be removed later:
		if (slot[2] === 'GamePro') {
			return AdProviderGamePro;
		}
		if (slot[2] === 'Evolve') {
			return AdProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			return AdProviderAdDriver2;
		}
		if (slot[2] === 'Liftium2') {
			return AdProviderLiftium2;
		}

		if (AdProviderGamePro.canHandleSlot(slot)) {
			return AdProviderGamePro;
		}

		if (AdProviderEvolve.canHandleSlot(slot)) {
			return AdProviderEvolve;
		}

		if (isSlotEvolveRS(slot[0], getCountry())) {
			return AdProviderEvolveRS;
		}

		if (isSlotHighValue(slot[0], getCountry())) {
			return AdProviderAdDriver2;
		}

		// TODO should be AdProviderLiftium2 eventually
		return AdProviderAdDriver;
	}

	// TODO refactor to adProviderEvolveRS ?
	function isSlotEvolveRS(slotname, country) {
		log('isSlotEvolveRS', 5, 'AdConfig2');
		log([slotname, country], 5, 'AdConfig2');

		if ((country == 'AU' || country == 'NZ' || country == 'CA') && slotname == 'INVISIBLE_1') {
			return true;
		}

		return false;
	}

	// TODO unit test!
	function isSlotHighValue(slotname, country) {
		log('isSlotHighValue', 5, 'AdConfig2');
		log([slotname, country], 5, 'AdConfig2');

		// copy of AdConfig.isHighValueSlot
		var slotMap = {
			'CORP_TOP_LEADERBOARD':true,
			'CORP_TOP_RIGHT_BOXAD':true,
			'EXIT_STITIAL_BOXAD_1':true,
			'HOME_INVISIBLE_TOP':true,
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'HUB_TOP_LEADERBOARD':true,
			'INVISIBLE_MODAL':true,
			'INVISIBLE_TOP':true,
			'LEFT_SKYSCRAPER_2':true,
			'MIDDLE_RIGHT_BOXAD':true,
			'MODAL_RECTANGLE':true,
			'MODAL_INTERSTITIAL':true,
			'MODAL_VERTICAL_BANNER':true,
			'TEST_HOME_TOP_RIGHT_BOXAD':true,
			'TEST_TOP_RIGHT_BOXAD':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true
		};
		// copy of CommonSettings wgHighValueCountries
		// TODO remove? dev only?
		var countryMap = window.wgHighValueCountries2 || window.wgHighValueCountries || {
			'CA':true,
			'DE':true,
			'DK':true,
			'ES':true,
			'FI':true,
			'FR':true,
			'GB':true,
			'IT':true,
			'NL':true,
			'NO':true,
			'SE':true,
			'UK':true,
			'US':true
		};
		if (typeof countryMap[country] != 'undefined' && typeof slotMap[slotname] != 'undefined') {
			return true;
		}

		return false;
	}

	// TODO refactor when fb:45432 is done
	function getCountry() {
		log('getCountry', 5, 'AdConfig2');

		if (window.testUseCountry) {
			log('test', 7, 'AdConfig2');
			log(window.testUseCountry, 7, 'AdConfig2');
			return window.testUseCountry;
		}

		if (_cache_geo) {
			log('cache', 7, 'AdConfig2');
			log(_cache_geo.country, 7, 'AdConfig2');
			return _cache_geo.country;
		}

		var qs = new Wikia.Querystring;
		var country = qs.getVal('usegeo', null);
		if (country) {
			_cache_geo = {country:country};

			log('querystring', 7, 'AdConfig2');
			log(country, 7, 'AdConfig2');
			return country;
		}

		var cookie = decodeURIComponent(Wikia.Cookies.get('Geo'));
		if (typeof cookie != 'undefined' && cookie) {
			try {
				_cache_geo = JSON.parse(cookie);
				_cache_geo.country;
			} catch (e) {
				_cache_geo = {country:'error'};
			}
			log('cookie', 7, 'AdConfig2');
			log(_cache_geo.country, 7, 'AdConfig2');
		}

		return _cache_geo.country;
	}

	return {getProvider:getProvider};

};
