/*global define, require*/
define('ext.wikia.adEngine.tracking.adInfoTracker',  [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.tracking.pageLayout',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.ml.rabbit')
], function (adTracker, slotRegistry, pageLayout, browserDetect, log, win, rabbit) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.adInfoTracker';

	function prepareData(slotName, pageParams, slotParams, creative, bidders) {
		var data;

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

		data = {
			'pv': pageParams.pv || '',
			'pv_unique_id': win.pvUID,
			'browser': [ browserDetect.getOS(), browserDetect.getBrowser() ].join(' '),
			'country': pageParams.geo || '',
			'time_bucket': (new Date()).getHours(),
			'slot_size': creative.slotSize && creative.slotSize.length ? creative.slotSize.join('x') : '',
			'kv_s0': pageParams.s0 || '',
			'kv_s1': pageParams.s1 || '',
			'kv_s2': pageParams.s2 || '',
			'kv_s0v': pageParams.s0v || '',
			'kv_pos': slotParams.pos || '',
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
			'product_chosen': creative.adProduct || 'unknown',
			'product_lineitem_id': creative.lineItemId || '',
			'creative_id': creative.creativeId || '',
			'creative_size': (creative.creativeSize || '').replace('[', '').replace(']', '').replace(',', 'x'),
			'viewport_height': win.innerHeight || 0,
			'ad_status': creative.status || 'unknown',
			'scroll_y': slotRegistry.getScrollY(slotName) || 0,
			'rabbit': (rabbit && rabbit.getSerializedResults()) || '',
			'page_width': win.document.body.scrollWidth || '',
			'page_layout': pageLayout.getSerializedData(slotName) || ''
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
