/*global define*/
define('ext.wikia.adEngine.video.videoFrequencySettings', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.time'
], function (adContext, timeUtil) {
	'use strict';

	var context = adContext.getContext();

	function get() {
		return {
			pv: parsePV(),
			time: parseTime()
		};
	}

	function parseTime() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(timeUtil.hasTimeUnit)
			.map(parseTimeRule);
	}

	function parsePV() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(function (item) {
				return item.indexOf('pv') > -1;
			})
			.map(function (item) {
				var data = item.replace('pv', '').split('/');
				return {
					frequency: parseInt(data[0]),
					limit: parseInt(data[1])
				};
			});
	}

	function parseTimeRule(item) {
		var unit = timeUtil.guessTimeUnit(item);
		var data = item.replace(unit, '').split('/');
		return {
			frequency: parseInt(data[0]),
			limit: parseInt(data[1]),
			unit: unit
		};
	}

	return {
		get: get
	};
});
