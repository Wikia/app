/*global define*/
/*jshint camelcase:false*/
/*jshint maxdepth:5*/
define('ext.wikia.adEngine.lookup.openXBidder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, adSlot, adLogicZoneParams, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.openXBidder',
		oxResponse = false,
		oxTiming,
		called = false,
		priceTimeout = 't',
		config = {
			oasis: {
				TOP_LEADERBOARD: '728x90',
				TOP_RIGHT_BOXAD: '300x250',
				LEFT_SKYSCRAPER_2: '160x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250'
			},
			mercury: {
				MOBILE_IN_CONTENT: '300x250',
				MOBILE_PREFOOTER: '300x250',
				MOBILE_TOP_LEADERBOARD: '320x50'
			}
		},
		name = 'ox_bidder',
		priceMap = {},
		slots = [];

	function getSlots(skin) {
		var context = adContext.getContext(),
			pageType = context.targeting.pageType,
			slotName;

		slots = config[skin];
		if (skin === 'oasis' && pageType === 'home') {
			for (slotName in slots) {
				if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
					slots['HOME_' + slotName] = slots[slotName];
					delete slots[slotName];
				}
			}
		}

		return slots;
	}

	function getAds(skin) {
		var ads = [],
			size,
			slotName,
			slotPath = [
				'/5441',
				'wka.' + adLogicZoneParams.getSite(),
				adLogicZoneParams.getMappedVertical(),
				'',
				adLogicZoneParams.getPageType()
			].join('/');

		slots = getSlots(skin);
		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				size = slots[slotName];
				ads.push([
					slotPath,
					[size],
					'wikia_gpt' + slotPath + '/gpt/' + slotName
				]);
			}
		}

		return ads;
	}

	function encodeParamsForTracking(params) {
		var key,
			encoded = [];
		for (key in params) {
			if (params.hasOwnProperty(key)) {
				encoded.push(key + '=' + params[key]);
			}
		}

		return encoded.join(';');
	}

	function trackState(providerName, slotName, params) {
		log(['trackState', oxResponse, providerName, slotName], 'debug', logGroup);
		var category,
			eventName = 'lookup_error';

		if (!slots[slotName]) {
			log(['trackState', 'Not supported slot', slotName], 'debug', logGroup);
			return;
		}
		if (oxResponse) {
			eventName = 'lookup_success';
		}
		category = name + '/' + eventName + '/' + providerName;
		adTracker.track(category, slotName, 0, encodeParamsForTracking(params) || 'nodata');
	}

	function trackLookupEnd() {
		adTracker.track(name + '/lookup_end', priceMap || 'nodata', 0);
	}

	function onResponse() {
		oxTiming.measureDiff({}, 'end').track();
		log('OpenX bidder done', 'info', logGroup);
		var prices = win.OX.dfp_bidder.getPriceMap(),
			slotName,
			shortSlotName;

		for (slotName in prices) {
			if (prices.hasOwnProperty(slotName) && prices[slotName].price !== priceTimeout) {
				shortSlotName = adSlot.getShortSlotName(slotName);
				priceMap[shortSlotName] = prices[slotName].price;
			}
		}
		oxResponse = true;
		log(['OpenX bidder prices', priceMap], 'info', logGroup);
		trackLookupEnd();
	}

	function call(skin) {
		log('call', 'debug', logGroup);

		var openx = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		if (adLogicZoneParams.getSite() !== 'life') {
			log(['call', 'Not wka.life vertical'], 'debug', logGroup);
			return;
		}

		oxTiming = adTracker.measureTime(name, {}, 'start');
		oxTiming.track();
		win.OX_dfp_ads = getAds(skin);

		win.OX_dfp_options = {
			callback: onResponse
		};

		openx.async = true;
		openx.type = 'text/javascript';
		openx.src = '//ox-d.wikia.servedbyopenx.com/w/1.0/jstag?nc=5441-Wikia';

		node.parentNode.insertBefore(openx, node);

		called = true;
	}

	function wasCalled() {
		log(['wasCalled', called], 'debug', logGroup);
		return called;
	}

	function getSlotParams(slotName) {
		log(['getSlotParams', slotName], 'debug', logGroup);
		var dfpParams = {},
			slotSize,
			dfpKey,
			price;

		if (oxResponse && slots[slotName]) {
			slotSize = slots[slotName];
			price = priceMap[slotName];
			if (price) {
				dfpKey = 'ox' + slotSize;
				dfpParams[dfpKey] = price;

				log(['getSlotParams', dfpKey, price], 'debug', logGroup);
				return dfpParams;
			}
		}
		log(['getSlotParams - no price since ad has been already displayed', slotName], 'debug', logGroup);
		return {};
	}

	return {
		call: call,
		getSlotParams: getSlotParams,
		trackState: trackState,
		wasCalled: wasCalled
	};
});
