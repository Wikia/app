/*global define*/
define('ext.wikia.adEngine.ml.n1.n1InputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.geo',
	'wikia.log'
], function (pageParams, geo, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.n1.n1InputParser';

	function getData() {
		var data,
			params = pageParams.getPageLevelParams();

		data = [
			geo.getCountryCode() ? 0 : 1,
			params.s0v === 'music' ? 1 : 0,
			params.ref === 'direct' ? 1 : 0,
			params.ref === 'external' ? 1 : 0,
			params.ref === 'external_search' ? 1 : 0,
			params.ref === 'wiki' ? 1 : 0
		];

		log(['N+1 data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});
