/*global define*/
define('ext.wikia.adEngine.evolveHelper', ['wikia.log', 'ext.wikia.adEngine.adContext'], function (log, adContext) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.evolveHelper',
		getSect;

	getSect = function () {
		log('getSect', 5, logGroup);

		var context = adContext.getContext(),
			kv = context.targeting.wikiCustomKeyValues || '',
			vertical = context.targeting.wikiVertical || '',
			sect;

		if (context.targeting.wikiDbName === 'wikiaglobal') {
			sect = 'home';
			if (context.targeting.pageName === 'Video_Games') {
				sect = 'gaming';
			}
			if (context.targeting.pageName === 'Entertainment') {
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
