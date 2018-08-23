/*global define*/
define('ext.wikia.adEngine.lookup.prebid.bidHelper', [
	'ext.wikia.adEngine.lookup.prebid.priceGranularityHelper'
], function (priceGranularityHelper) {
	'use strict';

	function transformPriceFromBid(bid) {
		var maxCpm = 20;
		// Do not cap bids as $20 for AppNexus and Rubicon videos
		if (['appnexusAst', 'rubicon', 'wikiaVideo'].indexOf(bid.bidderCode) > -1) {
			maxCpm = 50;
		}

		return priceGranularityHelper.transformPriceFromCpm(bid.cpm, maxCpm);
	}

	return {
		transformPriceFromBid: transformPriceFromBid
	};
});
