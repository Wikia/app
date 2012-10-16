var EvolveHelper = function (log, window) {
	'use strict';

	var logGroup = 'EvolveHelper'
		, getSect
	;

	getSect = function() {
		log('getSect', 5, logGroup);

		var kv = window.wgDartCustomKeyValues || ''
			, hub = window.cscoreCat || ''
			, sect
		;

		if (window.wgDBname === 'wikiaglobal') {
			sect = 'home';
		} else if (kv.indexOf('movie') !== -1) {
			sect = 'movies';
		} else if (kv.indexOf('tv') !== -1) {
			sect = 'tv';
		} else if (hub === 'Entertainment') {
			sect = 'entertainment';
		} else if (hub === 'Gaming') {
			sect = 'gaming';
		} else {
			sect = 'ros';
		}

		log(sect, 7, logGroup);
		return sect;
	};

	return {
		getSect: getSect
	};
};
