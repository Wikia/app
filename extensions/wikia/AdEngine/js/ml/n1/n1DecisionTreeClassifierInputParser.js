/*global define*/
define('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.browserDetect',
	'wikia.geo',
	'wikia.log'
], function (pageParams, browserDetect, geo, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser';

	function getData() {
		var data,
			params = pageParams.getPageLevelParams();

		data = [
			browserDetect.getBrowser().indexOf('Firefox') === 0 ? 1 : 0,
			browserDetect.getBrowser().indexOf('Netscape') === 0 ? 1 : 0,
			browserDetect.getBrowser().indexOf('Safari') === 0 ? 1 : 0,
			geo.getCountryCode() === 'CA' ? 1 : 0,
			geo.getCountryCode() === 'CN' ? 1 : 0,
			geo.getCountryCode() === 'DK' ? 1 : 0,
			geo.getCountryCode() === 'FR' ? 1 : 0,
			geo.getCountryCode() === 'IN' ? 1 : 0,
			geo.getCountryCode() === 'KR' ? 1 : 0,
			geo.getCountryCode() === 'NO' ? 1 : 0,
			geo.getCountryCode() === 'PK' ? 1 : 0,
			geo.getCountryCode() === 'RU' ? 1 : 0,
			geo.getCountryCode() === 'TW' ? 1 : 0,
			geo.getCountryCode() === 'UA' ? 1 : 0,
			geo.getCountryCode() === 'VE' ? 1 : 0,
			geo.getCountryCode() ? 0 : 1,
			params.s0v === 'comics' ? 1 : 0,
			params.s0v === 'lifestyle' ? 1 : 0,
			params.s0v === 'movies' ? 1 : 0,
			params.s0v === 'music' ? 1 : 0,
			params.s0v === 'tv' ? 1 : 0,
			params.esrb === 'ec' ? 1 : 0,
			params.esrb === 'everyone' ? 1 : 0,
			params.esrb === 'mature' ? 1 : 0,
			params.esrb === 'teen' ? 1 : 0,
			params.ref === 'direct' ? 1 : 0,
			params.ref === 'external' ? 1 : 0,
			params.ref === 'external_search' ? 1 : 0,
			params.ref === 'wiki' ? 1 : 0,
			params.ref === 'wiki_search' ? 1 : 0
		];

		log(['N+1 DTC data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});