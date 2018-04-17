/*global define*/
define('ext.wikia.adEngine.ml.n1.n1mInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.geo',
	'wikia.log'
], function (pageParams, geo, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.n1.n1mInputParser';

	function getData() {
		var data,
			params = pageParams.getPageLevelParams();

		data = [
			geo.getCountryCode() === 'RU' ? 1 : 0,
			geo.getCountryCode() === 'UA' ? 1 : 0,
			geo.getCountryCode() ? 0 : 1,
			params.s0v === 'books' ? 1 : 0,
			params.s0v === 'comics' ? 1 : 0,
			params.s0v === 'games' ? 1 : 0,
			params.s0v === 'lifestyle' ? 1 : 0,
			params.s0v === 'music' ? 1 : 0,
			params.s0v === 'tv' ? 1 : 0,
			params.esrb === 'mature' ? 1 : 0,
			params.ref === 'direct' ? 1 : 0,
			params.ref === 'external_search' ? 1 : 0,
			params.ref === 'wiki' ? 1 : 0,
			params.s2 === 'file' ? 1 : 0,
			params.s2 === 'home' ? 1 : 0,
		];

		log(['N+1 mobile data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});
