/*global define*/
define('ext.wikia.adEngine.wrappers.prebid', [
	'wikia.location',
	'wikia.window'
], function (loc, win) {
	'use strict';

	var validResponseStatusCode = 1,
		errorResponseStatusCode = 2;

	win.pbjs = win.pbjs || {};
	win.pbjs.que = win.pbjs.que || [];

	if (win.pbjs) {
		win.pbjs.setConfig({
			debug: loc.href.indexOf('pbjs_debug=1') >= 0,
			enableSendAllBids: true,
			bidderSequence: 'random',
			bidderTimeout: 2000,
			userSync: {
				iframeEnabled: true,
				enabledBidders: [],
				syncDelay: 6000
			}
		});
	}

	function get() {
		return win.pbjs;
	}

	function getBidByAdId(adId) {
		if (!win.pbjs || typeof win.pbjs.getBidResponses !== 'function') {
			return null;
		}

		var bids = [],
			responses = win.pbjs.getBidResponses();

		Object.keys(responses).forEach(function (adUnit) {
			var adUnitsBids = responses[adUnit].bids.filter(function (bid) {
				return adId === bid.adId;
			});

			bids = bids.concat(adUnitsBids);
		});

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
