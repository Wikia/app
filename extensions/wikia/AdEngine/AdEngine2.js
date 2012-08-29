var AdEngine2 = {
	_cache_geo:null,
	debug:true,

	log:function (msg, obj) {
		if (typeof console == 'undefined') return;

		// FIXME WikiaLogger...
		if (!this.debug) return;

		console.log('AdEngine2: ' + msg);
		if (typeof obj != 'undefined') {
			console.log(obj);
		}
	},

	init:function () {
		this.log('init');

		this.moveQueue();
	},

	fillInSlot:function (slot) {
		this.log('fillInSlot', slot);

		var provider = this.getProvider(slot);
		this.log(provider);
		slot[2] = provider;
		window['adProvider' + provider].fillInSlot(slot);
	},

	// based on WikiaTrackerQueue by macbre
	moveQueue:function () {
		this.log('moveQueue');

		var slots = window.adslots2 || [], slot;
		this.log('slots', slots);
		while ((slot = slots.shift()) !== undefined) {
			this.fillInSlot(slot);
		}

		slots.push = this.proxy(this.fillInSlot, this);
		this.log('ad queue moved');
	},

	proxy:function (fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	},

	getProvider:function (slot) {
		this.log('getProvider', slot);

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
		this.log('isSlotGamePro', [slotname, city_lang]);

		var slotMap = {
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'LEFT_SKYSCRAPER_2':true,
			'PREFOOTER_LEFT_BOXAD':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true,
		};
		if (city_lang == 'de' && typeof slotMap[slotname] != 'undefined') {
			return true;
		}

		return false;
	},

	// TODO refactor to adProviderEvolve ?
	isSlotEvolve:function (slotname, country) {
		this.log('isSlotEvolve', [slotname, country]);

		var slotMap = {
			'HOME_TOP_LEADERBOARD':true,
			'HOME_TOP_RIGHT_BOXAD':true,
			'LEFT_SKYSCRAPER_2':true,
			'TOP_LEADERBOARD':true,
			'TOP_RIGHT_BOXAD':true,
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