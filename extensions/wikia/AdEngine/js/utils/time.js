/*global define*/
define('ext.wikia.adEngine.utils.time', [], function () {
	'use strict';

	var MULTIPLIER = {
		SECOND: 1000,
		MINUTE: 1000 * 60,
		HOUR: 1000 * 60 * 60
	}, UNITS = {
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

	return {
		getInterval: getInterval
	};
});
