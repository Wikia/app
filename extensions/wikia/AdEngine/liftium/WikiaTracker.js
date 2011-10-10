var WikiaTracker = {
	profileAliases:{
		'default':       'UA-2871474-1',
		'main':          'UA-2871474-1',
		'main.sampled':  'UA-2871474-1',
		'main.unsampled':'UA-2871474-2',

		'liftium.beacon':'UA-17475676-5',
		'liftium.beacon2':'UA-17475676-14',
		'liftium.errors':'UA-17475676-12',
		'liftium.hop':'UA-17475676-8',
		'liftium.init':'UA-17475676-4',
		'liftium.init2':'UA-17475676-15',
		'liftium.quantcast':'UA-17475676-9',
		'liftium.slot':'UA-17475676-6',
		'liftium.slot2':'UA-17475676-16',
		'liftium.varia':'UA-17475676-10',
		'lyrics':'UA-12241505-1',
		'lyrics.unsampled':'UA-12241505-2'
	},
	defaultRate:10,
	profileRates:{
		'UA-2871474-1':100, // main.sampled (FIXME temporary, remove)
		'UA-2871474-2':100, // main.unsampled
		'UA-12241505-2':100, // lyrics.unsampled
		'UA-17475676-14':100, // liftium.beacon2
		'UA-17475676-15':100, // liftium.init2
		'UA-17475676-12':100 // liftium.errors
	},
	debugLevel:5
};

WikiaTracker.debug = function (msg, level, obj) {
	if (!this.debugLevel){
		return false;
	} else if (level > this.debugLevel){
		return false;
	}

	// Firebug enabled
	if (typeof console == "object" && console.dir){
		console.log("WikiaTracker: " + msg);
		if (arguments.length > 2){
			console.dir(obj);
		}
	// Default console, available on IE 8+, FF 3+ Safari 4+
	} else if (typeof console == "object" && console.log){
		console.log("WikiaTracker: " + msg);
		if (arguments.length > 2){
			console.log(obj);
		}
	}

	return true;
};

WikiaTracker.track = function(page, profile) {
	if (typeof page == 'object') {
		page = page.join('/');
	}
	if (page.indexOf('/') != 0) {
		page = '/' + page;
	}

	this.debug(page + ' in ' + profile, 3);

	if (typeof profile == 'undefined') {
		profile = 'default';
	}

	if (typeof this.profileAliases[profile] != 'undefined') {
		profile = this.profileAliases[profile];
	}
	
	var sample = this.defaultRate;
	if (typeof this.profileRates[profile] != 'undefined') {
		sample = this.profileRates[profile];
	}

	return this._track(page, profile, sample);
};

WikiaTracker._track = function(page, profile, sample) {
	this.debug('(internal) ' + page + ' in ' + profile + ' at ' + sample + '%', 5);

	_gaq.push(['WikiaTracker._setAccount', profile]);
	_gaq.push(['WikiaTracker._setSampleRate', sample]);

	var hub = Liftium.getPageVar("Hub", "unknown");
	var lang = Liftium.langForTracking(Liftium.getPageVar("cont_lang", "unknown"));
	var db = Liftium.dbnameForTracking(Liftium.getPageVar("wgDBname", "unknown"));

	_gaq.push(['WikiaTracker._setCustomVar', 1, 'db',   db,   3]);
	_gaq.push(['WikiaTracker._setCustomVar', 2, 'hub',  hub,  3]);
	_gaq.push(['WikiaTracker._setCustomVar', 3, 'lang', lang, 3]);

	_gaq.push(['WikiaTracker._trackPageview', page]);

	return true;
};

WikiaTracker.trackEvent3 = function(page, param) {
	var profile = 'UA-17475676-10';
	var sample = 10;
	if (!Liftium.e(param)) {
		// {profile:'profile-id', sample:10|'10%'}
		if (typeof param == 'object') {
			if (!Liftium.e(param['profile'])) {
				profile = param['profile'];
				this.debug("using custom profile: " + profile, 7);
			}
			if (!Liftium.e(param['sample'])) {
				sample = parseInt(param['sample']);
				this.debug("using custom sample rate: " + sample, 7);
			}
		} else {
			param = param.toString();
			// 'profile-id'
			if (param.search(/\d-\d/) != -1) {
				profile = param;
				this.debug("using custom profile: " + profile, 7);
			// 10|'10%'
			} else if (parseInt(param)) {
				sample = parseInt(param);
				this.debug("using custom sample rate: " + sample, 7);
			}
		}
	}

	return this._track(page, profile, sample);
};

WikiaTracker._track2 = function(page, profile, sample) {
	if (!this._isTracked()) { return false; }

	this.debug('(internal2) ' + page + ' in ' + profile + ' at ' + sample + '%', 5);

	_gaq.push(['WikiaTracker._setAccount', profile]);
	_gaq.push(['WikiaTracker._setSampleRate', 100]);

	var hub = Liftium.getPageVar("Hub", "unknown");
	var lang = Liftium.langForTracking(Liftium.getPageVar("cont_lang", "unknown"));
	var db = Liftium.dbnameForTracking(Liftium.getPageVar("wgDBname", "unknown"));

	_gaq.push(['WikiaTracker._setCustomVar', 1, 'db',   db,   3]);
	_gaq.push(['WikiaTracker._setCustomVar', 2, 'hub',  hub,  3]);
	_gaq.push(['WikiaTracker._setCustomVar', 3, 'lang', lang, 3]);

	_gaq.push(['WikiaTracker._trackPageview', page]);

	return true;
};

WikiaTracker._simpleHash = function(s, tableSize) {
		var i, hash = 0;
		for (i = 0; i < s.length; i++) {
			hash += (s[i].charCodeAt() * (i+1));
		}
		return Math.abs(hash) % tableSize;
 };

WikiaTracker._inGroup = function(hash_id, group_id) {
	var groups = {
		all : { rangeStart: 0, rangeStop: 99, id: 'UA-1' },
		A : { rangeStart: 20, rangeStop: 29, id: 'UA-2' },
		B : { rangeStart: 30, rangeStop: 39, id: 'UA-3' },
		N : { rangeStart: 80, rangeStop: 89, id: 'UA-8' }
	};

		if( groups[group_id].rangeStart <= hash_id && hash_id <= groups[group_id].rangeStop ) {
			return true;
		}

	return false;
};

WikiaTracker._isTracked = function() {
	var is_tracked = false;

	if (typeof this._is_tracked_cache != 'undefined') {
		is_tracked = this._is_tracked_cache;
		this.debug('isTracked from cache', 5); // FIXME NEF 7
	} else {
		this.debug('beacon_id: ' + window.beacon_id, 5); // FIXME NEF 7
		var hash = this._simpleHash(window.beacon_id, 100);
		this.debug('beacon hashed: ' + hash, 5); // FIXME NEF 7

		is_tracked = this._inGroup(hash, 'N');
		this._is_tracked_cache = is_tracked;
	}

	this.debug('isTracked: ' + is_tracked, 5);

	return is_tracked;
};
