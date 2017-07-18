/*global define*/
define('ext.wikia.adEngine.ml.hivi.leaderboard', [
	'ext.wikia.adEngine.ml.hivi.leaderboardInputParser',
	'ext.wikia.adEngine.ml.model.logisticRegression',
	'wikia.geo',
	'wikia.instantGlobals'
], function (leaderboardInputParser, logisticRegression, geo, instantGlobals) {
	'use strict';

	var coefficients = [
			-0.65132532,
			-0.552271,
			0.02118517,
			-0.16399251,
			-0.05091575,
			-0.01180468,
			0.32166968,
			0.09480829,
			-0.16919703,
			-0.01577001,
			-0.01615974,
			0.00449124,
			-0.04075191,
			-0.07798134,
			-0.18118635,
			0.47026201,
			-0.24732248,
			-0.22541781,
			-0.43997969,
			-0.3474756,
			-0.25889304,
			-0.06113919,
			-0.49083244,
			-0.2380395,
			-2.09138503
		],
		intercept = 0.04175317,
		experimentId = '5515_',

		lr = logisticRegression.create(coefficients, intercept);

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverHiViLeaderboardCountries);
	}

	function predictViewability() {
		var data = leaderboardInputParser.getData();

		return lr.predict(data);
	}

	function getValue() {
		if (!isEnabled()) {
			return [];
		}

		return [ experimentId + predictViewability() ];
	}

	return {
		getValue: getValue
	};
});
