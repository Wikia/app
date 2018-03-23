/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.wikiaVideo',[
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.document',
	'wikia.querystring'
], function (prebid, vastUrlBuilder, instartLogic, doc, QueryString) {
	'use strict';

	var bidderName = 'wikiaVideo',
		slots = {
			oasis: {
				INCONTENT_PLAYER: {}
			},
			mercury: {
				MOBILE_IN_CONTENT: {}
			}
		},
		qs = new QueryString();

	function getPrice() {
		var price = qs.getVal('wikia_video_adapter', 0);

		return parseInt(price, 10) / 100;
	}

	function isEnabled() {
		return qs.getVal('wikia_video_adapter', false) !== false && !instartLogic.isBlocking();
	}

	function prepareAdUnit(slotName) {
		return {
			code: slotName,
			sizes: [ 640, 480 ],
			mediaType: 'video-outstream',
			bids: [
				{
					bidder: bidderName
				}
			]
		};
	}

	function getSlots(skin) {
		return slots[skin];
	}

	function getName() {
		return bidderName;
	}

	function addBids(bidderRequest) {
		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1),
				price = getPrice();

			bidResponse.bidderCode = bidderRequest.bidderCode;
			bidResponse.cpm = price;
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];
			bidResponse.vastUrl = vastUrlBuilder.build(
				bidResponse.width / bidResponse.height,
				{
					src: 'test',
					pos: 'outstream',
					passback: 'wikiaVideo'
				}
			);

			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function create() {
		return {
			callBids: function (bidderRequest) {
				prebid.push(function () {
					addBids(bidderRequest);
				});
			}
		};
	}

	return {
		create: create,
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
