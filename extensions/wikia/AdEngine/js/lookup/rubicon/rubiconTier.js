/*global define*/
define('ext.wikia.adEngine.lookup.rubicon.rubiconTier', [
	'ext.wikia.adEngine.utils.math'
], function (math) {
	'use strict';

	var cpmBuckets = [
		{
			maxValue: 4,
			bucket: 1
		},
		{
			maxValue: 99,
			bucket: 5
		},
		{
			maxValue: 499,
			bucket: 10
		},
		{
			maxValue: 1999,
			bucket: 50
		}
	];

	function create(sizeId, cpm) {
		var index = 0,
			tier = 2000;

		while (cpmBuckets[index] && cpm > cpmBuckets[index].maxValue) {
			index += 1;
		}
		if (cpmBuckets[index]) {
			tier = math.getBucket(cpm, cpmBuckets[index].bucket);
		}
		tier = Math.max(0, parseInt(tier, 10));

		return sizeId + '_tier' + math.leftPad(tier, 4);
	}

	function parsePrice(tier) {
		var matches = /^\d+_tier(\d+)/g.exec(tier);

		if (matches && matches[1]) {
			return parseInt(matches[1], 10);
		}

		return 0;
	}

	return {
		create: create,
		parsePrice: parsePrice
	};
});
