define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.adEngine.utils.env'
], function (zoneParams, env) {
	'use strict';

	var placementsMap = {
		mercury: {
			entertainment: {
				dev: '9412980',
				prod: '9412992'
			},
			gaming: {
				dev: '9412981',
				prod: '9412993'
			},
			lifestyle: {
				dev: '9412982',
				prod: '9412994'
			}
		},
		oasis: {
			entertainment: {
				dev: '9412971',
				prod: '9412983'
			},
			gaming: {
				dev: '9412972',
				prod: '9412984'
			},
			lifestyle: {
				dev: '9412973',
				prod: '9412985'
			}
		}
	};

	function getPlacement(skin) {
		var environment = env.isDevEnvironment() ? 'dev' : 'prod';

		return placementsMap[skin][zoneParams.getVertical()][environment];
	}

	return {
		getPlacement: getPlacement
	};
});
