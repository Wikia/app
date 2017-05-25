/*global define*/
define('ext.wikia.adEngine.lookup.prebid.priceGranularityHelper', function () {
	'use strict';

	function transformPriceFromCpm(cpm, maxSupportedCpm) {
		var defaultMaxCpm = 20,
			result;

		if (typeof maxSupportedCpm === 'undefined' || maxSupportedCpm < defaultMaxCpm) {
			maxSupportedCpm = defaultMaxCpm;
		}

		result = Math.floor(maxSupportedCpm).toFixed(2);

		if (cpm === 0) {
			result = '0.00';
		} else if (cpm < 0.05) {
			result = '0.01';
		} else if (cpm < 5.00) {
			result = (Math.floor(cpm * 20) / 20).toFixed(2);
		} else if (cpm < 10.00) {
			result = (Math.floor(cpm * 10) / 10).toFixed(2);
		} else if (cpm < 20.00) {
			result = (Math.floor(cpm * 2) / 2).toFixed(2);
		} else if (cpm < maxSupportedCpm) {
			result = Math.floor(cpm).toFixed(2);
		}

		return result;
	}

	return {
		transformPriceFromCpm: transformPriceFromCpm
	};
});
