/*global define*/
define('ext.wikia.adEngine.ml.fmr.fmrInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.log'
], function (pageParams, log) {
	'use strict';

	var articleHeightMean = 12169.6328125,
		logGroup = 'ext.wikia.adEngine.ml.fmr.fmrInputParser';

	function getData() {
		var data,
			params = pageParams.getPageLevelParams();

		data = [
			parseInt(params.ah || 0, 10) / articleHeightMean,
			params.s2 === 'article' ? 1 : 0,
			params.s2 === 'extra' ? 1 : 0,
			params.s2 === 'file' ? 1 : 0,
			params.s2 === 'forum' ? 1 : 0,
			params.s2 === 'fv-article' ? 1 : 0,
			params.s2 === 'home' ? 1 : 0,
			params.s2 === 'search' ? 1 : 0,
			params.s2 === 'special' ? 1 : 0,
			params.s0v === 'books' ? 1 : 0,
			params.s0v === 'comics' ? 1 : 0,
			params.s0v === 'games' ? 1 : 0,
			params.s0v === 'lifestyle' ? 1 : 0,
			params.s0v === 'movies' ? 1 : 0,
			params.s0v === 'music' ? 1 : 0,
			params.s0v === 'other' ? 1 : 0,
			params.s0v === 'tv' ? 1 : 0,
			params.skin === 'mercury' ? 1 : 0,
			params.skin === 'oasis' ? 1 : 0,
			params.esrb === 'e10' ? 1 : 0,
			params.esrb === 'ec' ? 1 : 0,
			params.esrb === 'everyone' ? 1 : 0,
			params.esrb === 'mature' ? 1 : 0,
			params.esrb === 'rp' ? 1 : 0,
			params.esrb === 'teen' ? 1 : 0,
			params.esrb === 'tenn' ? 1 : 0,
			params.ref === 'direct' ? 1 : 0,
			params.ref === 'external' ? 1 : 0,
			params.ref === 'external_search' ? 1 : 0,
			params.ref === 'wiki' ? 1 : 0,
			params.ref === 'wiki_search' ? 1 : 0,
			params.ref === 'wikia' ? 1 : 0,
			params.ref === 'wikia_search' ? 1 : 0,
			params.top === '1k' ? 1 : 0
		];

		log(['FMR data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});
