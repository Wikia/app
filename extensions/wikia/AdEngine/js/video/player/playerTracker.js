/*global define, require*/
define('ext.wikia.adEngine.video.player.playerTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.slot.slotTargeting',
	'wikia.browserDetect',
	'ext.wikia.adEngine.geo',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.prebid.bidHelper'),
	require.optional('ext.wikia.adEngine.ml.billTheLizard'),
	require.optional('ext.wikia.adEngine.video.player.porvata.floater')
], function (
	adContext,
	pageLevel,
	adTracker,
	slotTargeting,
	browserDetect,
	geo,
	log,
	win,
	bidHelper,
	billTheLizard,
	floater
) {
	'use strict';
	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.video.player.playerTracker',
		emptyValue = {
			int: 0,
			string: '(none)',
			price: -1
		};

	function isEnabled() {
		return !!context.opts.playerTracking;
	}

	function prepareData(params, playerName, eventName, errorCode, contentType) {
		var pageLevelParams = pageLevel.getPageLevelParams(),
			canFloat = floater && floater.canFloat(params) ? 'canFloat' : '',
			floatingState = (params.floatingContext && params.floatingContext.state) || (canFloat ? 'never' : ''),
			trackingData = {
				'pv_unique_id': win.pvUID,
				'pv_number': pageLevelParams.pv,
				'country': geo.getCountryCode(),
				'timestamp': (new Date()).getTime(),
				'skin': pageLevelParams.skin,
				'wsi': params.src ? slotTargeting.getWikiaSlotId(params.slotName, params.src) : emptyValue.string,
				'player': playerName,
				'ad_product': params.adProduct,
				'position': (params.trackingpos || params.slotName || emptyValue.string).toLowerCase(),
				'event_name': eventName,
				'ad_error_code': errorCode || emptyValue.int,
				'content_type': params.contentType || contentType || emptyValue.string,
				'line_item_id': params.lineItemId || emptyValue.int,
				'creative_id': params.creativeId || emptyValue.int,
				'ctp': params.withCtp ? 1 : 0,
				'audio': params.withAudio ? 1 : 0,
				'price': emptyValue.price,
				'browser': [ browserDetect.getOS(), browserDetect.getBrowser() ].join(' '),
				'additional_1': canFloat,
				'additional_2': floatingState,
				'vast_id': params.vastId || emptyValue.string,
				'video_id': params.videoId || '',
				'btl': billTheLizard && billTheLizard.hasResponse() ? 1 : 0
			};

		if (bidHelper && params.bid) {
			trackingData['price'] = bidHelper.transformPriceFromBid(params.bid);
			trackingData['vast_id'] = params.bid.creativeId || emptyValue.string;
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
	 * @param {string} contentType
	 */
	function track(params, playerName, eventName, errorCode, contentType) {
		// Possibility to turn off tracking from single creative/player instance
		if (!isEnabled() || params.trackingDisabled) {
			log(['track', 'Tracking disabled', params], log.levels.debug, logGroup);
			return;
		}

		if (!params.adProduct || !playerName || !eventName) {
			log(['track', 'Missing argument', params.adProduct, playerName, eventName], log.levels.debug, logGroup);
			return;
		}

		var data = prepareData(params, playerName, eventName, errorCode, contentType);

		log(['track', data], log.levels.debug, logGroup);
		adTracker.trackDW(data, 'adengplayerinfo');

		return data;
	}

	return {
		isEnabled: isEnabled,
		track: track
	};
});
