/*global define, JSON*/
define('ext.wikia.adEngine.tracking.adInfoListener',  [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.services',
	'ext.wikia.adEngine.tracking.adInfoTracker',
	'ext.wikia.adEngine.video.vastParser',
	'wikia.log',
	'wikia.querystring',
	'wikia.window'
], function (adContext, lookupServices, tracker, vastParser, log, Querystring, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.adInfoListener',
		enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true,
			INCONTENT_BOXAD_1: true,
			INCONTENT_PLAYER: true,
			BOTTOM_LEADERBOARD: true,
			MOBILE_TOP_LEADERBOARD: true,
			MOBILE_BOTTOM_LEADERBOARD: true,
			MOBILE_IN_CONTENT: true,
			MOBILE_PREFOOTER: true
		};

	function isEnabled() {
		return adContext.getContext().opts.enableAdInfoLog;
	}

	function getBidderWon(slotParams, realSlotPrices) {
		var slotPricesKeys = Object.keys(realSlotPrices).filter(function(key) {
				return parseFloat(realSlotPrices[key]) > 0;
			}),
			highestPrice = Math.max.apply(
				null,
				slotPricesKeys.map(function(key) { return parseFloat(realSlotPrices[key]); })
			),
			highestPriceBidders = [];

		slotPricesKeys.forEach(function(key) {
			if (parseFloat(realSlotPrices[key]) === highestPrice) {
				highestPriceBidders.push(key);
			}
		});

		// In case of a tie in prebid bidders prebid.js picks the fastest bidder
		if (slotParams.hb_bidder && highestPriceBidders.indexOf(slotParams.hb_bidder) >= 0) {
			return slotParams.hb_bidder;
		}

		return '';
	}

	function trackSlot(slot, status, adInfo) {
		var slotFirstChildData = slot.container.firstChild.dataset,
			pageParams = JSON.parse(slotFirstChildData.gptPageParams || '{}'),
			slotParams = JSON.parse(slotFirstChildData.gptSlotParams || '{}'),
			slotPricesIgnoringTimeout = lookupServices.getCurrentSlotPrices(slot.name),
			realSlotPrices = lookupServices.getDfpSlotPrices(slot.name),
			slotSize = JSON.parse(slotFirstChildData.gptCreativeSize || '[]'),
			bidderWon = getBidderWon(slotParams, realSlotPrices);

		adInfo = adInfo || {};

		tracker.track(
			slot.name,
			pageParams,
			slotParams,
			{
				adProduct: adInfo.adProduct,
				creativeId: slotFirstChildData.gptCreativeId,
				creativeSize: slotFirstChildData.gptCreativeSize,
				lineItemId: slotFirstChildData.gptLineItemId,
				slotSize: slotSize,
				status: status
			},
			{
				bidderWon: bidderWon,
				realSlotPrices: realSlotPrices,
				slotPricesIgnoringTimeout: slotPricesIgnoringTimeout
			}
		);
	}

	function trackVideo(adInfo) {
		var vastInfo = vastParser.parse(adInfo.vastUrl),
			slotPrices = {};

		if (vastInfo.amznbid) {
			slotPrices.a9 = vastInfo.amznbid;
		}

		tracker.track(
			vastInfo.pos,
			vastInfo,
			vastInfo,
			{
				adProduct: vastInfo.position,
				creativeId: adInfo.creativeId,
				creativeSize: vastInfo.size,
				lineItemId: adInfo.lineItemId,
				status: adInfo.status
			},
			{
				realSlotPrices: slotPrices
			});
	}

	function shouldHandleSlot(slot) {
		var dataGptDiv = slot.container && slot.container.firstChild;

		return (
			enabledSlots[slot.name] &&
			dataGptDiv &&
			dataGptDiv.dataset.gptPageParams
		);
	}

	function run() {
		if (isEnabled()) {
			log('run', log.levels.debug, logGroup);

			win.addEventListener('adengine.slot.status', function (event) {
				var adInfo = event.detail.adInfo || {},
					adType = adInfo && adInfo.adType,
					slot = event.detail.slot,
					status = adType === 'blocked' ? 'blocked' : event.detail.status;

				if (shouldHandleSlot(slot)) {
					log(['adengine.slot.status', event], log.levels.debug, logGroup);
					trackSlot(slot, status, adInfo);
				}
			});

			win.addEventListener('adengine.video.status', function (event) {
				var adInfo = event.detail || {};

				if (adInfo.vastUrl) {
					log(['adengine.video.status', event], log.levels.debug, logGroup);
					trackVideo(adInfo);
				}
			});
		}
	}

	return {
		run: run
	};
});
