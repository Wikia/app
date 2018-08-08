/*global define*/
define('ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.browserDetect',
	'ext.wikia.adEngine.geo',
	'wikia.log'
], function (pageParams, browserDetect, geo, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.n1.n1DecisionTreeClassifierInputParser';

	function getData() {
		var data,
			params = pageParams.getPageLevelParams(),
			countryCode = geo.getCountryCode();

		data = [
			browserDetect.getBrowser().indexOf('Firefox') === 0 ? 1 : 0,
			browserDetect.getBrowser().indexOf('Netscape') === 0 ? 1 : 0,
			browserDetect.getBrowser().indexOf('Safari') === 0 ? 1 : 0,
			countryCode === 'CA' ? 1 : 0,
			countryCode === 'CN' ? 1 : 0,
			countryCode === 'DK' ? 1 : 0,
			countryCode === 'FR' ? 1 : 0,
			countryCode === 'IN' ? 1 : 0,
			countryCode === 'KR' ? 1 : 0,
			countryCode === 'NO' ? 1 : 0,
			countryCode === 'PK' ? 1 : 0,
			countryCode === 'RU' ? 1 : 0,
			countryCode === 'TW' ? 1 : 0,
			countryCode === 'UA' ? 1 : 0,
			countryCode === 'VE' ? 1 : 0,
			countryCode ? 0 : 1,
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
