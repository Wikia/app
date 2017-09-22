/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.veles', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.prebid.priceParsingHelper',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.log',
	'wikia.window'
], function (adContext, slotsContext, priceParsingHelper, prebid, vastUrlBuilder, instartLogic, log, win) {
	'use strict';

	var bidderName = 'veles',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.veles',
		allowedSlots = {
			IC: ['INCONTENT_PLAYER', 'MOBILE_IN_CONTENT'],
			LB: ['TOP_LEADERBOARD'],
			XX: ['TOP_LEADERBOARD', 'INCONTENT_PLAYER', 'MOBILE_IN_CONTENT']
		},
		slots = {
			// Order of slots is important - first slot name in group will be used to create ad unit
			oasis: {
				INCONTENT_PLAYER: {
					sizes: [
						[640, 480]
					]
				},
				TOP_LEADERBOARD: {
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
		var isVelesEnabled = adContext.getContext().bidders.veles && !instartLogic.isBlocking();
		log(['isEnabled', isVelesEnabled], log.levels.debug, logGroup);

		return isVelesEnabled;
	}

	function prepareAdUnit(slotName, config) {
		var adUnit = {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName
				}
			]
		};

		log(['prepareAdUnit', adUnit], log.levels.debug, logGroup);
		return adUnit;
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function getName() {
		return bidderName;
	}

	function addEmptyBids(bidderRequest) {
		log(['addEmptyBids', bidderRequest], log.levels.debug, logGroup);

		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(2);

			bidResponse.bidderCode = bidderRequest.bidderCode;
			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function addBids(bidderRequest, vastResponse, velesParams) {
		log(['addBids', bidderRequest, vastResponse, velesParams], log.levels.debug, logGroup);

		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1);

			bidResponse.ad = '';
			bidResponse.bidderCode = bidderRequest.bidderCode;
			bidResponse.bidderRequestId = bidderRequest.bidderRequestId;
			bidResponse.cpm = 0.00;
			bidResponse.mediaType = 'video';
			bidResponse.moatTracking = velesParams.moatTracking;
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];
			bidResponse.vastId = velesParams.vastId;
			bidResponse.vastUrl = velesParams.vastUrl;

			if (velesParams.valid && allowedSlots[velesParams.position].indexOf(bid.placementCode) > -1 ) {
				bidResponse.ad = vastResponse;
				bidResponse.cpm = velesParams.price;
			} else if (velesParams.valid) {
				bidResponse.notInvolved = true;
			}

			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function isValidResponse(status) {
		var result = status !== 0 && status < 400;

		log(['isValidResponse', result], log.levels.debug, logGroup);
		return result;
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
				pos: (adContext.getContext().opts.megaAdUnitBuilderEnabled ? 'OUTSTREAM' : Object.keys(getSlots(skin))),
				src: skin === 'oasis' ? 'gpt' : 'mobile',
				passback: bidderName
			}, {
				numberOfAds: 1
			});

		request.onreadystatechange = function () {
			if (this.readyState === 4) {
				onVastResponse(request, bidderRequest);
			}
		};
		request.open('GET', vastUrl, true);
		request.send();

		log(['requestVast', vastUrl], log.levels.debug, logGroup);
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

	function markBidsAsUsed(adId) {
		win.pbjs._bidsReceived.forEach(function (bid) {
			if (bid.bidderCode === bidderName && bid.adId !== adId) {
				bid.cpm = 0.00;
				bid.used = true;
			}
		});
	}

	return {
		create: create,
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		markBidsAsUsed: markBidsAsUsed,
		prepareAdUnit: prepareAdUnit
	};
});
