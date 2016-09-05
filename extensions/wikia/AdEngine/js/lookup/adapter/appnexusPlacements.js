define('ext.wikia.adEngine.lookup.adapter.appnexusPlacements', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.window'
], function (zoneParams, win) {
	'use strict';

	var placements = {
		mercury: {
			entertainment: isDevEnviroment() ? '9412980' : '9412992',
			gaming: isDevEnviroment() ? '9412981' : '9412993',
			lifestyle: isDevEnviroment() ? '9412982' : '9412994'
		},
		oasis: {
			entertainment: isDevEnviroment() ? '9412971' : '9412983',
			gaming: isDevEnviroment() ? '9412972' : '9412984',
			lifestyle: isDevEnviroment() ? '9412973' : '9412985'
		}
	};

	function getPlacement(skin) {
		return placements[skin][zoneParams.getVertical()];
	}

	function isDevEnviroment() {
		//thisis needed because all the bidding happens very early on the page - wgDevelEnvironment is not set yet
		return /.+wikia-dev\.com$/.test(win.location.host);
	}

	return {
		getPlacement: getPlacement
	};
});
