/*global WikiaLogger: true, WikiaTracker_ABtests: true, _gaq: true */
var WikiaTracker = {
	profileAliases:{
		'default':       'UA-2871474-1',
		'main':          'UA-2871474-1',
		'main.sampled':  'UA-2871474-1',
		'main.unsampled':'UA-2871474-2',
		'main.test':     'UA-2871474-3',
		'main.private':  'UA-2871474-4',

		'Wikia':         'UA-288915-1',
		'Wikia.main':    'UA-288915-1',
		'Wikia.hub':     'UA-288915-2',
		'Wikia.pagetime':'UA-288915-42',
		'Wikia.varnish': 'UA-288915-48',

		'ab.main':'UA-19473076-35',
		'liftium.admeldapiclient':'UA-17475676-18',
		'liftium.beacon':'UA-17475676-5',
		'liftium.beacon2':'UA-17475676-14',
		'liftium.error':'UA-17475676-12',
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
	_groups:{A:80, B:81, C:82, D:83, E:84, F:85, G:86, H:87, I:88, J:89, N:[80, 89], O:13},
	_user_group_cache:null,
	_in_group_cache:{}
	//_in_ab_cache:[] dont declare, leave undefined FIXME make it null and refactor accordingly
	//_beacon_hash_cache:0 dont declare, leave undefined FIXME make it null and refactor
};

// FIXME refactor inGroup / userGroup / isTracked, it should be much simpler now
WikiaTracker.debug = function (msg, level, obj) {
	return WikiaLogger.log(msg, level, 'tracker') &&
		(typeof obj != 'undefined') ? WikiaLogger.log(obj, level, 'tracker') : true;
};

WikiaTracker.track = function(page, profile, events) {
	if (typeof page != 'undefined' && page instanceof Array) {
		page = page.join('/');
	}

	this.debug(page + ' in ' + profile, 3, events);

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

	// temp switched to GA sampling (BugId: 20284)
	return this._track(page, profile, sample, events);
/*
	if (sample == 100) {
		// just track it
	} else if (sample == 1) {
		if (!this.inGroup('O')) { return false; }
	} else {
		if (!this.isTracked()) { return false; }
	}

	return this._track(page, profile, 100, events);
*/
};

WikiaTracker._track = function(page, profile, sample, events) {
	this.debug(page + ' in ' + profile + ' at ' + sample + '%', 7);

	sample = '10';

	if (page != 'AnalyticsEngine::EVENT_PAGEVIEW' && profile != 'UA-288915-42' && profile != 'UA-2871474-1') {
		return;
	}

	_gaq.push(['WikiaTracker._setAccount', profile]);
	_gaq.push(['WikiaTracker._setSampleRate', sample]);

//	temp change - BugId: 20284
//	_gaq.push(['WikiaTracker._setDomainName', window.wgCookieDomain || '.wikia.com']);
	_gaq.push(['WikiaTracker._setDomainName', '.wikia.com']);

	//_gaq.push(['WikiaTracker._setCustomVar', 1, 'db',    window.wgDBname || window.wgDB || 'unknown', 3]);
	//_gaq.push(['WikiaTracker._setCustomVar', 2, 'hub',   window.wgCatId || 'unknown', 3]);
	//_gaq.push(['WikiaTracker._setCustomVar', 3, 'lang',  window.wgContentLanguage || 'unknown', 3]);
//	temp disable - BugId: 20284
//	var wiki = 'db=' + (window.wgDBname || window.wgDB || 'unknown') + ';hub=' + (window.wgCatId || 'unknown') + ';lang=' + (window.wgContentLanguage || 'unknown');
//	_gaq.push(['WikiaTracker._setCustomVar', 1, 'wiki',  wiki, 3]);

//	_gaq.push(['WikiaTracker._setCustomVar', 3, 'AB',    this._userGroup() || 'unknown', 3]);
//	_gaq.push(['WikiaTracker._setCustomVar', 4, 'skin',  window.skin || 'unknown', 3]);
//	_gaq.push(['WikiaTracker._setCustomVar', 5, 'user', (window.wgUserName == null) ? 'anon' : 'user', 3]);
/*
	if (typeof events != 'undefined' && events instanceof Array) {
		this.debug('...with events: ' + events.join('/'), 7);

//		events.unshift('WikiaTracker._trackEvent');
//		temp disable - BugId: 20284
//		_gaq.push(events);
	}
*/
	if (page == 'AnalyticsEngine::EVENT_PAGEVIEW') {
		_gaq.push(['WikiaTracker._trackPageview']);
//		_gaq.push(['WikiaTracker._trackPageLoadTime']);
	} else if (page != null) {
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
	var g = this._groups[group_id] || -1;
	if (g instanceof Array) {
		if (g[0] <= hash_id && hash_id <= g[1]) {
			return true;
		}
	} else {
		if (g == hash_id) {
			return true;
		}
	}

	return false;
};

WikiaTracker._userGroup = function() {
	if (this._user_group_cache) {
		return this._user_group_cache;
	}

	for (var i in this._groups) {
		if (this.inGroup(i)) {
			this._user_group_cache = i;
			return i;
		}
	}

	return null;
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

if (typeof jQuery == 'function') {
	if ($.getUrlVar('wikiatracker_is_tracked') || $.cookies.get('wikiatracker_is_tracked')) {
		WikiaTracker._in_group_cache['N'] = true;
	}
	var _temp_ab_group = $.getUrlVar('wikiatracker_ab_group') || $.cookies.get('wikiatracker_ab_group');
	if (_temp_ab_group) {
		WikiaTracker._in_group_cache[_temp_ab_group] = true;
		WikiaTracker._in_group_cache['N'] = true;
	}
}
