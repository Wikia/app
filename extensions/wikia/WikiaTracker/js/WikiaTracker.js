var WikiaTracker = {
	profileAliases:{
		'default':       'UA-2871474-1',
		'main':          'UA-2871474-1',
		'main.sampled':  'UA-2871474-1',
		'main.unsampled':'UA-2871474-2',
		'main.test':     'UA-2871474-3',

		'Wikia':         'UA-288915-1',
		'Wikia.main':    'UA-288915-1',
		'Wikia.hub':     'UA-288915-2',
		'Wikia.pagetime':'UA-288915-42',
		'Wikia.varnish': 'UA-288915-48',

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
		'lyrics.2':'UA-12241505-2'
	},
	defaultRate:10,
	profileRates:{
		'UA-2871474-2':100, // main.unsampled
		'UA-2871474-3':1, // main.test
		'UA-17475676-16':100, // liftium.slot2
		'UA-17475676-12':100, // liftium.errors
		'UA-19473076-35':100 // ab.main
	},
	debugLevel:0,
	_in_group_cache:{}
	//_in_ab_cache:[] dont declare, leave undefined FIXME make it null and refactor accordingly
	//_beacon_hash_cache:0 dont declare, leave undefined FIXME make it null and refactor
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

WikiaTracker.trackGA = function(page, profile) { // FIXME NEF deprecated, remove
	return false;
};

WikiaTracker.track = function(page, profile) {
	if (typeof page != 'undefined' && page instanceof Array) {
		page = page.join('/');
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

	this.debug('sample rate is ' + sample, 7);

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
	this.debug(page + ' in ' + profile + ' at ' + sample + '%', 7);

	_gaq.push(['WikiaTracker._setAccount', profile]);
	_gaq.push(['WikiaTracker._setSampleRate', sample]);

	_gaq.push(['WikiaTracker._setDomainName', window.wgCookieDomain || '.wikia.com']);

	_gaq.push(['WikiaTracker._setCustomVar', 1, 'db',    window.wgDBname || window.wgDB || 'unknown', 3]);
	_gaq.push(['WikiaTracker._setCustomVar', 2, 'hub',   window.wgCatId || 'unknown', 3]);
	_gaq.push(['WikiaTracker._setCustomVar', 3, 'lang',  window.wgContentLanguage || 'unknown', 3]);
	_gaq.push(['WikiaTracker._setCustomVar', 4, 'skin',  window.skin || 'unknown', 3]);
	_gaq.push(['WikiaTracker._setCustomVar', 5, 'user', (window.wgUserName == null) ? 'anon' : 'user', 3]);

	if (page == 'AnalyticsEngine::EVENT_PAGEVIEW') {
		_gaq.push(['WikiaTracker._trackPageview']);
		_gaq.push(['WikiaTracker._trackPageLoadTime']);
	} else {

	if (page.indexOf('/') != 0) {
		page = '/' + page;
	}

	_gaq.push(['WikiaTracker._trackPageview', page]);

	}

	return true;
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
		this.debug('inGroup from cache', 7);
	} else {
		var beacon_hash = null;

		if (typeof this._beacon_hash_cache != 'undefined') {
			beacon_hash = this._beacon_hash_cache;
			this.debug('beacon_hash from cache', 7)
		} else {
			if (typeof window.beacon_id == 'undefined') {
				this.debug('beacon_id unavailable (yet?), bailing out', 3);
				return false;
			}

			this.debug('beacon_id: ' + window.beacon_id, 5);
			beacon_hash = this._simpleHash(window.beacon_id, 100);
			this.debug('beacon_hash: ' + beacon_hash, 5);

			this._beacon_hash_cache = beacon_hash;
		}

		in_group = this._inGroup(beacon_hash, group);
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
		this.debug('abData from cache', 7);
	} else {
		var tests = WikiaTracker_ABtests || [];
		for (var test in tests) {
			this.debug('abData (test): ' + test, 9);
			for (var i=0; i < tests[test].length; i++) {
				var group = tests[test][i];
				this.debug('abData (group): ' + group, 9);
				if (this.inGroup(group)) {
					this.debug('AB test: ' + test + ', group: ' + group, 5);
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
	for (var i=0; i < ab.length; i++) {
		this.track('/' + ab[i] + page, 'ab.main');
	}

	return true;
};

WikiaTracker.debugLevel = $.getUrlVar('wikiatracker_debug') || $.cookies.get('wikiatracker_debug') || 0;
if ($.getUrlVar('wikiatracker_is_tracked') || $.cookies.get('wikiatracker_is_tracked')) {
	WikiaTracker._in_group_cache['N'] = true;
}
var _temp_ab_group = $.getUrlVar('wikiatracker_ab_group') || $.cookies.get('wikiatracker_ab_group');
if (_temp_ab_group) {
	WikiaTracker._in_group_cache[_temp_ab_group] = true;
	WikiaTracker._in_group_cache['N'] = true;
}
