/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidSettings', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.bidHelper'
], function (adContext, bidHelper) {
	'use strict';

	function create() {
		return {
			standard: {
				alwaysUseBid: false,
				adserverTargeting: [{
					key: 'hb_bidder',
					val: function (bidResponse) {
						return bidResponse.bidderCode;
					}
				}, {
					key: 'hb_adid',
					val: function (bidResponse) {
						return bidResponse.adId;
					}
				}, {
					key: 'hb_pb',
					val: function (bidResponse) {
						return bidHelper.transformPriceFromBid(bidResponse);
					}
				}, {
					key: 'hb_size',
					val: function (bidResponse) {
						return bidResponse.size;
					}
				}, {
					key: 'hb_uuid',
					val: function (bidResponse) {
						return (
							bidResponse.bidderCode === 'appnexusAst' && adContext.get('bidders.appnexusDfp')) || (
							bidResponse.bidderCode === 'rubicon' && adContext.get('bidders.rubiconDfp'))
							? bidResponse.videoCacheKey : 'disabled';
					}
				}]
			}
		}
	}

	return {
		create: create
	};
});
