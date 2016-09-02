define('ext.wikia.adEngine.lookup.adapter.appnexusPlacements', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.window'
], function (zoneParams, win) {
	'use strict';

	var placements = {
		entertainment: isDevEnviroment() ? 9412971 : 9412983,
		gaming: isDevEnviroment() ? 9412972 : 9412984,
		lifestyle: isDevEnviroment() ? 9412973 : 9412985
	};

	function getPlacement() {
		return placements[zoneParams.getVertical()];
	}

	function isDevEnviroment() {
		return win.location.host.indexOf('wikia-dev.com') > -1;
	}

	return {
		getPlacement: getPlacement
	}
});
