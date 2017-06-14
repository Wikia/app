/*global define*/
define('ext.wikia.adEngine.utils.time', [], function () {
	'use strict';

	var MULTIPLIER = {
			SECOND: 1000,
			MINUTE: 1000 * 60,
			HOUR: 1000 * 60 * 60
		},
		UNITS = {
			SECOND: ['s', 'sec', 'second', 'seconds'],
			MINUTE: ['m', 'min', 'minute', 'minutes'],
			HOUR: ['h', 'hour', 'hours']
		};

	function getMultiplier(unit) {
		var keys = Object.keys(UNITS);
		for (var i = 0; i < keys.length; i++) {
			if (UNITS[keys[i]].indexOf(unit) > -1) {
				return MULTIPLIER[keys[i]];
			}
		}

		throw 'Unsupported time unit';
	}

	function getInterval(value, unit) {
		return value * getMultiplier(unit);
	}

	function getSupportedUnits() {
		return UNITS.SECOND.concat(UNITS.MINUTE, UNITS.HOUR);
	}

	function guessTimeUnit(txt) {
		var possibleResults = getSupportedUnits()
			.filter(function (unit) {
				return txt.indexOf(unit) > -1;
			});

		return possibleResults.length > 0 ? possibleResults[possibleResults.length - 1] : null;
	}

	function hasTimeUnit(txt) {
		return guessTimeUnit(txt) !== null;
	}

	return {
		getInterval: getInterval,
		getSupportedUnits: getSupportedUnits,
		guessTimeUnit: guessTimeUnit,
		hasTimeUnit: hasTimeUnit
	};
});
