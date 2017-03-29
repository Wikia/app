/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.veles', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.priceParsingHelper',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (adContext, priceParsingHelper, prebid, vastUrlBuilder, geo, instantGlobals, win) {
	'use strict';

	var bidderName = 'veles',
		allowedSlots = {
			IC: ['INCONTENT_PLAYER', 'INCONTENT_LEADERBOARD', 'MOBILE_IN_CONTENT'],
			LB: ['TOP_LEADERBOARD'],
			XX: ['TOP_LEADERBOARD', 'INCONTENT_PLAYER', 'INCONTENT_LEADERBOARD', 'MOBILE_IN_CONTENT'],
		},
		slots = {
			// Order of slots is important - first slot name in group will be used to create ad unit
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[640, 480]
					]
				},
				INCONTENT_PLAYER: {
					sizes: [
						[640, 480]
					]
				},
				INCONTENT_LEADERBOARD: {
					sizes: [
						[640, 480]
					]
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[640, 480]
					]
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverVelesBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
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

	function addEmptyBids(bidderRequest) {
		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(2);

			bidResponse.bidderCode = bidderRequest.bidderCode;
			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function addBids(bidderRequest, vastResponse, velesParams) {
		bidderRequest.bids.forEach(function (bid) {
			if (allowedSlots[velesParams.position].indexOf(bid.placementCode) > -1 ) {
				var bidResponse = prebid.get().createBid(1);

				bidResponse.ad = vastResponse;
				bidResponse.bidderCode = bidderRequest.bidderCode;
				bidResponse.bidderRequestId = bidderRequest.bidderRequestId;
				bidResponse.cpm = velesParams.price;
				bidResponse.mediaType = 'video';
				bidResponse.width = bid.sizes[0][0];
				bidResponse.height = bid.sizes[0][1];

				prebid.get().addBidResponse(bid.placementCode, bidResponse);
			}
		});
	}

	function isValidResponse(status) {
		return status !== 0 && status < 400;
	}

	function onVastResponse(vastRequest, bidderRequest) {
		var velesParams;

		if (isValidResponse(vastRequest.status)) {
			velesParams = priceParsingHelper.analyze(vastRequest);

			addBids(bidderRequest, vastRequest.response, velesParams);
		} else {
			addEmptyBids(bidderRequest);
		}
	}

	function requestVast(bidderRequest) {
		var request = new win.XMLHttpRequest(),
			skin = adContext.getContext().targeting.skin,
			vastUrl = vastUrlBuilder.build(640 / 480, {
				pos: Object.keys(slots[skin]),
				src: 'gpt',
				passback: bidderName
			});

		request.onreadystatechange = function () {
			if (this.readyState === 4) {
				onVastResponse(request, bidderRequest);
			}
		};
		request.open('GET', vastUrl, true);
		request.send();
	}

	function create() {
		return {
			callBids: function (bidderRequest) {
				prebid.push(function () {
					requestVast(bidderRequest);
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
