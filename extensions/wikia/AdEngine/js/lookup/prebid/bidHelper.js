/*global define*/
define('ext.wikia.adEngine.lookup.prebid.bidHelper',
	['ext.wikia.adEngine.lookup.prebid.priceGranularityHelper'], function (priceGranularityHelper) {
	'use strict';

	function transformPriceFromBid(bid) {
		var maxSupportedCpm = 20;

		return priceGranularityHelper.transformPriceFromCpm(bid.cpm, maxSupportedCpm);
	}

	return {
		transformPriceFromBid: transformPriceFromBid
	};
});
