var WikiaTracker = {
	profileAliases:{
		'default':       'UA-2871474-1',
		'main':          'UA-2871474-1',
		'main.sampled':  'UA-2871474-1',
		'main.unsampled':'UA-2871474-2',
		'main.test':     'UA-2871474-3',
		
		'ab.main':'UA-19473076-35',
		'liftium.beacon':'UA-17475676-5',
		'liftium.beacon2':'UA-17475676-14',
		'liftium.errors':'UA-17475676-12',
		'liftium.hop':'UA-17475676-8',
		'liftium.init':'UA-17475676-4',
		'liftium.init2':'UA-17475676-15',
		'liftium.quantcast':'UA-17475676-9',
		'liftium.slot':'UA-17475676-6',
		'liftium.slot2':'UA-17475676-16',
		'liftium.test':'UA-17475676-11',
		'liftium.varia':'UA-17475676-10',
		'lyrics':'UA-12241505-1',
		'lyrics.unsampled':'UA-12241505-2'
	},
	defaultRate:10,
	profileRates:{
		'UA-2871474-1':100, // main.sampled (FIXME temporary, remove)
		'UA-2871474-2':100, // main.unsampled
		'UA-2871474-3':1, // main.test
		'UA-12241505-2':100, // lyrics.unsampled
		'UA-17475676-16':100, // liftium.slot2
		'UA-17475676-12':100, // liftium.errors
		'UA-19473076-35':100 // ab.main
	},
	ABtests:{
		'test1':['C', 'D'],
		'test2':['A']
	},
	debugLevel:0,
	_in_group_cache:{}
	//_in_ab_cache:[] dont declare, leave undefined
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

WikiaTracker.trackGA = function(page, profile) {
	if (typeof page == 'object') { // TODO instanceof Array
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

WikiaTracker.track = function(page, profile) {
	if (typeof page == 'object') { // TODO instanceof Array
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

	this.debug('sample rate is ' + sample, 5); // FIXME NEF 7

	if (sample == 100) {
		// just track it
	} else if (sample == 1) {
		if (!this.inGroup('O')) { return false; }
	} else {
		if (!this.isTracked()) { return false; }
	}

	return this._track(page, profile, 100);
};

WikiaTracker._track = function(page, profile, sample) {
	this.debug('(internal) ' + page + ' in ' + profile + ' at ' + sample + '%', 5);

	_gaq.push(['WikiaTracker._setAccount', profile]);
	_gaq.push(['WikiaTracker._setSampleRate', sample]);

	var hub = window.wgCatId || 'unknown'; // FIXME expand cat id to name
	var lang = window.wgContentLanguage || 'unknown';
	var db = window.wgDBname || window.wgDB || 'unknown';

	_gaq.push(['WikiaTracker._setCustomVar', 1, 'db',   db,   3]);
	_gaq.push(['WikiaTracker._setCustomVar', 2, 'hub',  hub,  3]);
	_gaq.push(['WikiaTracker._setCustomVar', 3, 'lang', lang, 3]);

	_gaq.push(['WikiaTracker._trackPageview', page]);

	return true;
};

WikiaTracker.trackEvent3 = function(page, param) { // FIXME NEF deprecated, remove
	return false;
};

WikiaTracker._track2 = function(page, profile, sample) { // FIXME NEF deprecated, remove
	return false;
};

WikiaTracker._simpleHash = function(s, tableSize) {
		var i, hash = 0;
		for (i = 0; i < s.length; i++) {
			hash += (s.charCodeAt(i) * (i+1));
		}
		return Math.abs(hash) % tableSize;
 };

WikiaTracker._inGroup = function(hash_id, group_id) {
	// TODO rethink group schema, get rid of start/stop?
	var groups = {
		A : { rangeStart: 80, rangeStop: 80, id: 'UA-A' },
		B : { rangeStart: 81, rangeStop: 81, id: 'UA-B' },
		C : { rangeStart: 82, rangeStop: 82, id: 'UA-C' },
		D : { rangeStart: 83, rangeStop: 83, id: 'UA-D' },
		E : { rangeStart: 84, rangeStop: 84, id: 'UA-E' },
		F : { rangeStart: 85, rangeStop: 85, id: 'UA-F' },
		G : { rangeStart: 86, rangeStop: 86, id: 'UA-G' },
		H : { rangeStart: 87, rangeStop: 87, id: 'UA-H' },
		I : { rangeStart: 88, rangeStop: 88, id: 'UA-I' },
		J : { rangeStart: 89, rangeStop: 89, id: 'UA-J' },
		N : { rangeStart: 80, rangeStop: 89, id: 'UA-N' },
		O : { rangeStart: 13, rangeStop: 13, id: 'UA-O' }
	};

		if( groups[group_id].rangeStart <= hash_id && hash_id <= groups[group_id].rangeStop ) {
			return true;
		}

	return false;
};

WikiaTracker.inGroup = function(group) {
	var in_group = false;

	if (typeof this._in_group_cache[group] != 'undefined') {
		in_group = this._in_group_cache[group];
		this.debug('inGroup from cache', 5); // FIXME NEF 7
	} else {
		if (typeof window.beacon_id == 'undefined') {
			this.debug('beacon_id unavailable (yet?), bailing out', 3);
			// TODO track it...
			return false;
		}

		this.debug('beacon_id: ' + window.beacon_id, 5); // FIXME NEF 7
		var hash = this._simpleHash(window.beacon_id, 100);
		this.debug('beacon hashed: ' + hash, 5); // FIXME NEF 7

		in_group = this._inGroup(hash, group);
		this._in_group_cache[group] = in_group;
	}

	this.debug('inGroup(' + group + '): ' + in_group, 5);

	return in_group;
};

WikiaTracker.isTracked = function() {
	return this.inGroup('N');
};

WikiaTracker._abData = function() {
	var in_ab = [];

	if (typeof this._in_ab_cache != 'undefined') {
		in_ab = this._in_ab_cache;
		this.debug('abData from cache', 5); // FIXME NEF 7
	} else {
		for (var test in this.ABtests) {
			for (var i in this.ABtests[test]) {
				var group = this.ABtests[test][i];
				this.debug('abData: ' + group, 5);
				if (this.inGroup(group)) {
					this.debug('AB test ' + test + ', group ' + group, 5);
					in_ab.push(test + '/' + group);
				}
			}
		}
		this._in_ab_cache = in_ab;
	}

	return in_ab;	
};

WikiaTracker.AB = function(page) {
	var ab = this._abData();
	for (var i in ab) {
		WikiaTracker.track('/' + ab[i] + page, 'ab.main');
	}

	return true;
};
