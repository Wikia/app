/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidSettings', [], function () {
	'use strict';

	function transformPrice(bidResponse) {
		var cpm = bidResponse.cpm,
			result = '20.00';

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
		}

		return result;
	}

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
					val: transformPrice
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
