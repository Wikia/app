window.AdConfig2 = window.AdConfig2 || (function (log, Wikia, window) {
	var _cache_geo = null;

	function getProvider(slot) {
		log('getProvider', 5, 'AdConfig2');
		log(slot, 5, 'AdConfig2');

		var providers = {
			'GamePro':true,
			'Evolve':true,
			'AdDriver2':true
		}
		if (slot[2] != 'AdEngine2' && typeof providers[slot[2]] != 'undefined') {
			return slot[2];
		}

		if (isSlotGamePro(slot[0], window.wgContentLanguage)) {
			return 'GamePro';
		}

		if (isSlotEvolve(slot[0], getCountry())) {
			return 'Evolve';
		}

		return 'AdDriver2';
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
		if (window.testUseCountry) return window.testUseCountry;

		if (_cache_geo) {
			return _cache_geo.country;
		}

		var qs = new Wikia.Querystring;
		var country = qs.getVal('usegeo', null);
		if (country) {
			_cache_geo = {country:country};
			return country;
		}

		var cookie = decodeURIComponent(Wikia.Cookies.get('Geo'));
		if (typeof cookie != 'undefined' && cookie) {
			try {
				_cache_geo = JSON.parse(cookie);
			} catch (e) {
				_cache_geo = {country:'error'};
			}
		}

		return _cache_geo.country;
	}

	return {getProvider:getProvider};

})(Wikia.log, Wikia, window);