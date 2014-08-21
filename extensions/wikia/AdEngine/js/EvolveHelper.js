/*global define*/
define('ext.wikia.adEngine.evolveHelper', ['wikia.log', 'ext.wikia.adEngine.adContext'], function (log, adContext) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.evolveHelper',
		getSect;

	getSect = function () {
		log('getSect', 5, logGroup);

		var kv = adContext.targeting.wikiCustomKeyValues || '',
			vertical = adContext.targeting.wikiVertical || '',
			sect;

		if (adContext.targeting.wikiDbName === 'wikiaglobal') {
			sect = 'home';
			if (adContext.targeting.pageName === 'Video_Games') {
				sect = 'gaming';
			}
			if (adContext.targeting.pageName === 'Entertainment') {
				sect = 'entertainment';
			}
		} else if (kv.indexOf('movie') !== -1) {
			sect = 'movies';
		} else if (kv.indexOf('tv') !== -1) {
			sect = 'tv';
		} else if (vertical === 'Entertainment') {
			sect = 'entertainment';
		} else if (vertical === 'Gaming') {
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
