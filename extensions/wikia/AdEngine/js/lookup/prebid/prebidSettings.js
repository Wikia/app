/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidSettings', [
	'ext.wikia.adEngine.lookup.prebid.bidHelper'
], function (bidHelper) {
	'use strict';

	/*
	 * Documentation:
	 * - http://prebid.org/dev-docs/publisher-api-reference.html#module_pbjs.setPriceGranularity
	 * - http://prebid.org/dev-docs/publisher-api-reference.html#module_pbjs.bidderSettings
	 * - http://prebid.org/dev-docs/examples/custom-price-bucket.html
	 */
	function create() {
		return {
			standard: {
				alwaysUseBid: false,
				adserverTargeting: [{
					key: "hb_bidder",
					val: function (bidResponse) {
						return bidResponse.bidderCode;
					}
				}, {
					key: "hb_adid",
					val: function (bidResponse) {
						return bidResponse.adId;
					}
				}, {
					key: "hb_pb",
					val: function(bidResponse) {
						return bidHelper.transformPriceFromBid(bidResponse);
					}
				}, {
					key: 'hb_size',
					val: function (bidResponse) {
						return bidResponse.size;
					}
				}]
			}
		}
	}

	return {
		create: create
	};
});
