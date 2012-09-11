window.AdConfig2 = window.AdConfig2 || (function (
	// regular dependencies
	log, Wikia, window,

	// AdProviders
	AdProviderGamePro,
	AdProviderEvolve,
	AdProviderAdDriver2
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

		if (isSlotGamePro(slot[0], window.wgContentLanguage)) {
			return AdProviderGamePro;
		}

		if (isSlotEvolve(slot[0], getCountry())) {
			return AdProviderEvolve;
		}

		return AdProviderAdDriver2;
	}

	// TODO refactor to adProviderGamePro
	function isSlotGamePro(slotname, city_lang) {
		log('isSlotGamePro', 5, 'AdConfig2');
		log([slotname, city_lang], 5, 'AdConfig2');

		var slotMap = {
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'LEFT_SKYSCRAPER_2':true,
			'PREFOOTER_LEFT_BOXAD':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true
		};
		if (city_lang == 'de' && typeof slotMap[slotname] != 'undefined') {
			return true;
		}

		return false;
	}

	// TODO refactor to adProviderEvolve ?
	function isSlotEvolve(slotname, country) {
		log('isSlotEvolve', 5, 'AdConfig2');
		log([slotname, country], 5, 'AdConfig2');

		var slotMap = {
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'LEFT_SKYSCRAPER_2':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true
		};
		if ((country == 'AU' || country == 'NZ' || country == 'CA') && typeof slotMap[slotname] != 'undefined') {
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
			} catch (e) {
				_cache_geo = {country:'error'};
			}
			log('cookie', 7, 'AdConfig2');
			log(_cache_geo.country, 7, 'AdConfig2');
		}

		return _cache_geo.country;
	}

	return {getProvider:getProvider};

})(
	// regular dependencies:
	Wikia.log, Wikia, window,

	// AdProviders:
	AdProviderGamePro,
	AdProviderEvolve,
	AdProviderAdDriver2
);
