/*global define, require*/
define('ext.wikia.adEngine.video.player.playerTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.slot.slotTargeting',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.bidders'),
	require.optional('ext.wikia.adEngine.ml.billTheLizard'),
	require.optional('ext.wikia.adEngine.video.player.porvata.floater')
], function (
	adContext,
	pageLevel,
	adTracker,
	bridge,
	slotTargeting,
	browserDetect,
	log,
	win,
	bidders,
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
			now = new Date(),
			trackingData = {
				'pv_unique_id': win.pvUID,
				'pv_number': pageLevelParams.pv,
				'country': bridge.geo.getCountryCode(),
				'timestamp': now.getTime(),
				'tz_offset': now.getTimezoneOffset(),
				'skin': pageLevelParams.skin,
				'wsi': params.src ? slotTargeting.getWikiaSlotId(params.slotName, params.src) : emptyValue.string,
				'player': playerName,
				'ad_product': params.adProduct,
				'position': (params.trackingpos || params.slotName || emptyValue.string).toLowerCase(),
				'event_name': eventName,
				'ad_error_code': errorCode || params.errorCode || emptyValue.int,
				'content_type': params.contentType || contentType || emptyValue.string,
				'line_item_id': params.lineItemId || emptyValue.int,
				'creative_id': params.creativeId || emptyValue.int,
				'ctp': params.withCtp ? 1 : 0,
				'audio': params.withAudio ? 1 : 0,
				'price': emptyValue.price,
				'browser': [ browserDetect.getOS(), browserDetect.getBrowser() ].join(' '),
				'additional_1': canFloat,
				'additional_2': floatingState,
				'additional_3': params.conflictingAdSlot || '',
				'vast_id': params.vastId || emptyValue.string,
				'video_id': params.videoId || '',
				'btl': billTheLizard ?
					(billTheLizard.getResponseStatus('fv') || billTheLizard.BillTheLizard.NOT_USED) :
					'',
				'document_visibility': bridge.geo.getDocumentVisibilityStatus()
			};

		if (bidders && params.bid) {
			trackingData['price'] = bidders.transformPriceFromBid(params.bid);
			trackingData['vast_id'] = params.bid.creativeId || emptyValue.string;
		}

		if ([-1, 0, 1].indexOf(params.userBlockAutoplay) > -1) {
			trackingData['user_block_autoplay'] = params.userBlockAutoplay;
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
