/*global define, require*/
define('ext.wikia.adEngine.video.player.playerTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.slot.slotTargeting',
	'wikia.geo',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.rubicon.rubiconVulcan')
], function (adContext, pageLevel, adTracker, slotTargeting, geo, log, win, vulcan) {
	'use strict';
	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.video.player.playerTracker';

	function isEnabled() {
		return !!context.opts.playerTracking;
	}

	function prepareData(params, playerName, eventName, errorCode) {
		var pageLevelParams = pageLevel.getPageLevelParams(),
			trackingData = {
				'pv_unique_id': win.adEnginePvUID,
				'pv_number': pageLevelParams.pv,
				'country': geo.getCountryCode(),
				'skin': pageLevelParams.skin,
				'wsi': params.src ? slotTargeting.getWikiaSlotId(params.slotName, params.src) : '',
				'player': playerName,
				'ad_product': params.adProduct,
				'position': params.slotName || '',
				'event_name': eventName,
				'ad_error_code': errorCode || '',
				'line_item_id': params.lineItemId || '',
				'creative_id': params.creativeId || '',
				'vulcan_network': '',
				'vulcan_advertiser': '',
				'vulcan_price': ''
			},
			vulcanResponse;

		if (vulcan && params.slotName && params.adProduct === 'vulcan') {
			vulcanResponse = vulcan.getSingleResponse(params.slotName);
			trackingData['vulcan_network'] = vulcanResponse.network || '';
			trackingData['vulcan_advertiser'] = vulcanResponse.advertiser || '';
			trackingData['vulcan_price'] = vulcan.getBestSlotPrice(params.slotName).vulcan || '';
		}

		return trackingData;
	}

	/**
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.creativeId]
	 * @param {string} [params.lineItemId]
	 * @param {string} [params.slotName]
	 * @param {string} [params.src]
	 * @param {string} [params.trackingDisabled]
	 * @param {string} playerName
	 * @param {string} eventName
	 * @param {int} [errorCode]
	 */
	function track(params, playerName, eventName, errorCode) {
		// Possibility to turn off tracking from single creative/player instance
		if (!isEnabled() || params.trackingDisabled) {
			log(['track', 'Tracking disabled', params], log.levels.debug, logGroup);
			return;
		}

		if (!params.adProduct || !playerName || !eventName) {
			log(['track', 'Missing argument', params.adProduct, playerName, eventName], log.levels.debug, logGroup);
			return;
		}

		var data = prepareData(params, playerName, eventName, errorCode);

		log(['track', data], log.levels.debug, logGroup);
		adTracker.trackDW(data, 'adengplayerinfo');
	}

	return {
		isEnabled: isEnabled,
		track: track
	};
});
