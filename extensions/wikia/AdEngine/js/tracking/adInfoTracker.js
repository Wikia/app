/*global define, require*/
define('ext.wikia.adEngine.tracking.adInfoTracker',  [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.tracking.pageLayout',
	'ext.wikia.adEngine.utils.device',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.trackingOptIn',
	'wikia.window',
	require.optional('ext.wikia.adEngine.ml.billTheLizard'),
	require.optional('ext.wikia.adEngine.ml.rabbit')
], function (
	adTracker,
	bridge,
	slotRegistry,
	pageLayout,
	deviceDetect,
	browserDetect,
	log,
	trackingOptIn,
	win,
	billTheLizard,
	rabbit
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.adInfoTracker';

	function getPosParameter(slotParams) {
		var pos = (slotParams.trackingpos || slotParams.pos || ''),
			posArray = Array.isArray(pos) ? pos : pos.split(',');

		return posArray[0].toLowerCase();
	}

	function prepareData(slotName, pageParams, slotParams, creative, bidders) {
		var data,
			isStickyEvent,
			now = new Date(),
			timestamp = now.getTime();

		function transformBidderPrice(bidderName) {
			if (bidders.realSlotPrices && bidders.realSlotPrices[bidderName]) {
				return bidders.realSlotPrices[bidderName];
			}

			if (bidders.slotPricesIgnoringTimeout && bidders.slotPricesIgnoringTimeout[bidderName]) {
				return bidders.slotPricesIgnoringTimeout[bidderName] + 'not_used';
			}

			return '';
		}

		pageParams = pageParams || {};
		slotParams = slotParams || {};
		creative = creative || {};
		bidders = bidders || {};

		isStickyEvent = ['sticky-ready', 'sticked', 'unsticked', 'force-unstick'].indexOf(creative.status) > -1;

		data = {
			'pv': pageParams.pv || '',
			'pv_unique_id': win.pvUID,
			'browser': [ browserDetect.getOS(), browserDetect.getBrowser() ].join(' '),
			'device': deviceDetect.getDevice(pageParams),
			'country': pageParams.geo || '',
			'time_bucket': now.getHours(),
			'timestamp': timestamp,
			'ad_load_time': timestamp - win.performance.timing.connectStart,
			'slot_size': creative.slotSize && creative.slotSize.length ? creative.slotSize.join('x') : '',
			'kv_s0': pageParams.s0 || '',
			'kv_s1': pageParams.s1 || '',
			'kv_s2': pageParams.s2 || '',
			'kv_s0v': pageParams.s0v || '',
			'kv_pos': getPosParameter(slotParams),
			'kv_rv': slotParams.rv || '',
			'kv_wsi': slotParams.wsi || '',
			'kv_lang': pageParams.lang || '',
			'kv_skin': pageParams.skin || '',
			'kv_esrb': pageParams.esrb || '',
			'kv_ref': pageParams.ref || '',
			'kv_top': pageParams.top || '',
			'kv_ah': win.document.body.scrollHeight || '',
			'kv_abi': slotParams.abi || '',
			'bidder_won': bidders.bidderWon || '',
			'bidder_won_price': bidders.bidderWon ? bidders.realSlotPrices[bidders.bidderWon] : '',
			'bidder_1': transformBidderPrice('indexExchange'),
			'bidder_2': transformBidderPrice('appnexus'),
			'bidder_4': transformBidderPrice('rubicon'),
			'bidder_6': transformBidderPrice('aol'),
			'bidder_7': transformBidderPrice('audienceNetwork'),
			'bidder_9': transformBidderPrice('openx'),
			'bidder_10': transformBidderPrice('appnexusAst'),
			'bidder_11': transformBidderPrice('rubicon_display'),
			'bidder_12': transformBidderPrice('a9'),
			'bidder_13': transformBidderPrice('onemobile'),
			'bidder_14': transformBidderPrice('pubmatic'),
			'bidder_15': transformBidderPrice('beachfront'),
			'bidder_16': transformBidderPrice('appnexusWebAds'),
			'bidder_17': transformBidderPrice('kargo'),
			'product_chosen': creative.adProduct || 'unknown',
			'product_lineitem_id': creative.lineItemId || '',
			'creative_id': creative.creativeId || '',
			'creative_size': (creative.creativeSize || '').replace('[', '').replace(']', '').replace(',', 'x'),
			'viewport_height': win.innerHeight || 0,
			'ad_status': creative.status || 'unknown',
			'scroll_y': isStickyEvent ? slotRegistry.getCurrentScrollY() : slotRegistry.getScrollY(slotName),
			'rabbit': (rabbit && rabbit.getAllSerializedResults()) || '',
			'btl': (billTheLizard && billTheLizard.serialize()) || '',
			'page_width': win.document.body.scrollWidth || '',
			'page_layout': pageLayout.getSerializedData(slotName) || '',
			'document_visibility': bridge.geo.getDocumentVisibilityStatus(),
			'labrador': bridge.geo.getSamplingResults().join(';'),
			'opt_in': trackingOptIn.geoRequiresTrackingConsent() ? trackingOptIn.isOptedIn() ? 'yes' : 'no' : ''
		};

		log(['prepareData', slotName, data], log.levels.debug, logGroup);

		return data;
	}

	function track(slotName, pageParams, slotParams, adInfo, bidders) {
		var data = prepareData(slotName, pageParams, slotParams, adInfo, bidders);

		adTracker.trackDW(data, 'adengadinfo');
		log(['logSlotInfo', data], log.levels.debug, logGroup);
	}

	return {
		track: track
	};
});
