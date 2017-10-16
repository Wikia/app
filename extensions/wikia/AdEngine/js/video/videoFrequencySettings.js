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
			.filter(function (item) {
				return timeUtil.hasTimeUnit(item) && validate(item);
			})
			.map(parseTimeRule);
	}

	function validate(item) {
		return item.match('^[0-9]+\/[0-9]+[a-z]+$');
	}

	function parsePV() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(function (item) {
				return item.indexOf('pv') > -1 && validate(item);
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
		var unit = timeUtil.guessTimeUnit(item),
			data = item.replace(unit, '').split('/');

		return {
			frequency: parseInt(data[0]),
			limit: parseInt(data[1]),
			unit: unit
		};
	}

	function getRequiredNumberOfItems() {
		if (!context.opts.outstreamVideoFrequencyCapping || context.opts.outstreamVideoFrequencyCapping.length === 0) {
			return 0;
		}

		var max = Math.max.apply(null, context.opts.outstreamVideoFrequencyCapping.map(function (value) {
			return parseInt(value.split('/')[0], 10);
		}));

		return max ? max : 0;
	}

	return {
		get: get,
		getRequiredNumberOfItems: getRequiredNumberOfItems
	};
});
