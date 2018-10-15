/*global define*/
define('ext.wikia.adEngine.wrappers.prebid', [
	'ext.wikia.adEngine.adContext',
	// TODO: Remove wikia.cmp dependency after ADEN-7432
	// at this point it's a way to load cmp module (just require it)
	'wikia.cmp',
	'wikia.location',
	'wikia.window'
], function (adContext, cmp, loc, win) {
	'use strict';

	var validResponseStatusCode = 1,
		errorResponseStatusCode = 2,
		isCMPEnabled = adContext.get('opts.isCMPEnabled'),
		prebidConfig = {
			debug: loc.href.indexOf('pbjs_debug=1') >= 0,
			enableSendAllBids: true,
			bidderSequence: 'random',
			bidderTimeout: 2000,
			cache: {
				url: 'https://prebid.adnxs.com/pbc/v1/cache'
			},
			userSync: {
				iframeEnabled: true,
				enabledBidders: [],
				syncDelay: 6000
			}
		};

	win.pbjs = win.pbjs || {};
	win.pbjs.que = win.pbjs.que || [];

	if (isCMPEnabled) {
		prebidConfig.consentManagement = {
			cmpApi: 'iab',
			allowAuctionWithoutConsent: false
		};
	}

	if (!adContext.get('bidders.prebidAE3')) {
		win.pbjs.que.push(function() {
			win.pbjs.setConfig(prebidConfig);
		});
	}

	function get() {
		return win.pbjs;
	}

	function getBidByAdId(adId) {
		if (!win.pbjs || typeof win.pbjs.getBidResponses !== 'function') {
			return null;
		}

		var bids = win.pbjs.getAllPrebidWinningBids().filter(function (bid) {
			return adId === bid.adId;
		});

		if (!bids.length) {
			var responses = win.pbjs.getBidResponses();
			Object.keys(responses).forEach(function (adUnit) {
				var adUnitsBids = responses[adUnit].bids.filter(function (bid) {
					return adId === bid.adId;
				});

				bids = bids.concat(adUnitsBids);
			});
		}

		return bids.length ? bids[0] : null;
	}

	function getWinningVideoBidBySlotName(slotName, allowedBidders) {
		var bids;

		if (!win.pbjs || !win.pbjs.getBidResponsesForAdUnitCode) {
			return null;
		}

		bids = win.pbjs.getBidResponsesForAdUnitCode(slotName).bids || [];

		return bids.filter(function (bid) {
			var canUseThisBidder = !allowedBidders || allowedBidders.indexOf(bid.bidderCode) !== -1,
				hasVast = bid.vastUrl || bid.vastContent;

			return canUseThisBidder && hasVast && bid.cpm > 0;
		}).reduce(function (previousBid, currentBid) {
			if (previousBid === null || currentBid.cpm > previousBid.cpm) {
				return currentBid;
			}

			return previousBid;
		}, null);
	}

	function push(callback) {
		win.pbjs.que.push(callback);
	}

	return {
		validResponseStatusCode: validResponseStatusCode,
		errorResponseStatusCode: errorResponseStatusCode,
		get: get,
		getBidByAdId: getBidByAdId,
		getWinningVideoBidBySlotName: getWinningVideoBidBySlotName,
		push: push
	};
});
