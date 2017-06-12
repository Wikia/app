/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyStore', [], function () {
	'use strict';

	var store = [];

	function save(data) {
		store.push(data);
	}

	function getAll() {
		return store;
	}

	function numberOfVideosSeenInLast(value, unit) {
		var minDate = (new Date()).getTime() - getInterval(value, unit);

		return getAll()
			.filter(function (item) { return item.date >= minDate; })
			.length;
	}

	function getMultiplier(unit) {
		var s = 1000;
		switch (unit) {
			case 's':
			case 'sec':
			case 'second':
			case 'seconds':
				return s;
			case 'm':
			case 'minute':
			case 'minutes':
				return s * 60;
			default:
				throw 'Unsupported time unit';
		}
	}

	function getInterval(value, unit) {
		return value * getMultiplier(unit);
	}

	return {
		save: save,
		numberOfVideosSeenInLast: numberOfVideosSeenInLast
	};
});
