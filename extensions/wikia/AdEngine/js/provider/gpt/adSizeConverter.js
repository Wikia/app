/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.adSizeConverter', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeConverter',
		fallbackSize = [1, 1];

	function filterOutSizesBiggerThanScreenSize(sizes) {
		log(['filterOutSizesBiggerThanScreenSize', sizes], 'debug', logGroup);
		var goodSizes = [], i, len, minWidth;

		minWidth = doc.documentElement.offsetWidth;

		for (i = 0, len = sizes.length; i < len; i += 1) {
			if (sizes[i][0] <= minWidth) {
				goodSizes.push(sizes[i]);
			}
		}

		if (goodSizes.length === 0) {
			log(['filterOutSizesBiggerThanScreenSize', 'No sizes left. Returning fallbackSize only'], 'error', logGroup);
			goodSizes.push(fallbackSize);
		}

		log(['filterOutSizesBiggerThanScreenSize', 'result', goodSizes], 'debug', logGroup);
		return goodSizes;
	}

	function convertSize(slotName, slotSizes) {
		log(['convertSizeToGpt', slotName, slotSizes], 'debug', logGroup);
		var tmp1 = slotSizes.split(','),
			sizes = [],
			tmp2,
			i;

		for (i = 0; i < tmp1.length; i += 1) {
			tmp2 = tmp1[i].split('x');
			sizes.push([parseInt(tmp2[0], 10), parseInt(tmp2[1], 10)]);
		}

		if (slotName.match(/TOP_LEADERBOARD/)) {
			sizes = filterOutSizesBiggerThanScreenSize(sizes);
		}

		log(['convertSize', slotName, sizes], 'debug', logGroup);
		return sizes;
	}

	return {
		convert: convertSize
	}
});
