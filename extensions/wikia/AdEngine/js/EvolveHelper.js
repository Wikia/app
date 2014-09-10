/*global define*/
define('ext.wikia.adEngine.evolveHelper', ['wikia.log', 'wikia.window'], function (log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.evolveHelper',
		getSect;

	getSect = function () {
		log('getSect', 5, logGroup);

		var kv = window.wgDartCustomKeyValues || '',
			hub = window.cscoreCat || '',
			sect;

		if (window.wgDBname === 'wikiaglobal') {
			sect = 'home';
			if (window.wgPageName === 'Video_Games') {
				sect = 'gaming';
			}
			if (window.wgPageName === 'Entertainment') {
				sect = 'entertainment';
			}
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
});
