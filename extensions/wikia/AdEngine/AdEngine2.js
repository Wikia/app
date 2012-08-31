var AdEngine2 = {
	_cache_geo:null,

	log:function (msg, level, obj) {
		Wikia.log(msg, level, 'AdEngine2');

		if (typeof obj != 'undefined') {
			Wikia.log(obj, level, 'AdEngine2');
		}
	},

	init:function () {
		this.log('init', 5);

		this.moveQueue();
	},

	fillInSlot:function (slot) {
		this.log('fillInSlot', 5, slot);

		var provider = this.getProvider(slot);
		this.log('calling ' + provider + ' for ' + slot[0], 3);
		slot[2] = provider;
		window['adProvider' + provider].fillInSlot(slot);
	},

	// based on WikiaTrackerQueue by macbre
	moveQueue:function () {
		this.log('moveQueue', 5);

		var slots = window.adslots2 || [], slot;
		this.log('queue', 7, slots);
		while ((slot = slots.shift()) !== undefined) {
			this.fillInSlot(slot);
		}

		slots.push = this.proxy(this.fillInSlot, this);
		this.log('queue moved', 6);
	},

	proxy:function (fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	},

	getProvider:function (slot) {
		this.log('getProvider', 5, slot);

		var providers = {
			'GamePro':true,
			'Evolve':true,
			'AdDriver2':true
		}
		if (slot[2] != 'AdEngine2' && typeof providers[slot[2]] != 'undefined') {
			return slot[2];
		}

		if (this.isSlotGamePro(slot[0], window.wgContentLanguage)) {
			return 'GamePro';
		}

		if (this.isSlotEvolve(slot[0], this.getCountry())) {
			return 'Evolve';
		}

		return 'AdDriver2';
	},

	// TODO refactor to adProviderGamePro
	isSlotGamePro:function (slotname, city_lang) {
		this.log('isSlotGamePro', 5, [slotname, city_lang]);

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
	},

	// TODO refactor to adProviderEvolve ?
	isSlotEvolve:function (slotname, country) {
		this.log('isSlotEvolve', 5, [slotname, country]);

		var slotMap = {
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'LEFT_SKYSCRAPER_2':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true
		};
		if ((country == 'AU' || country == 'CA') && typeof slotMap[slotname] != 'undefined') {
			return true;
		}

		return false;
	},

	// TODO refactor when fb:45432 is done
	getCountry: function () {
		if (this._cache_geo) {
			return this._cache_geo.country;
		}

		var qs = new Wikia.Querystring;
		var country = qs.getVal('usegeo', null);
		if (country) {
			this._cache_geo = {country:country};
			return country;
		}

		var cookie = decodeURIComponent(Wikia.Cookies.get('Geo'));
		if (typeof cookie != 'undefined' && cookie) {
			try {
				this._cache_geo = JSON.parse(cookie);
			} catch (e) {
				this._cache_geo = {country:'error'};
			}
		}

		return this._cache_geo.country;
	}
};

if (!window.wgInsideUnitTest) {
	AdEngine2.init();
}