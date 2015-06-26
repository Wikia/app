/*global define*/
define('ext.wikia.adEngine.provider.gpt.adSizeConverter', [
	'wikia.log'
], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adSizeConverter';

	function convertSize(slotSizes) {
		log(['convertSizeToGpt', slotSizes], 'debug', logGroup);
		var tmp1 = slotSizes.split(','),
			sizes = [],
			tmp2,
			i;

		for (i = 0; i < tmp1.length; i += 1) {
			tmp2 = tmp1[i].split('x');
			sizes.push([parseInt(tmp2[0], 10), parseInt(tmp2[1], 10)]);
		}

		log(['convertSize', slotSizes, sizes], 'debug', logGroup);
		return sizes;
	}

	return {
		convert: convertSize
	};
});
