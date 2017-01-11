/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openx.openXBidderHelper', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.log',
	'wikia.window'
], function (adContext, slotsContext, adLogicZoneParams, log, win) {
	'use strict';

	var slots = {},
		openXTimeoutChanged = false,
		logGroup = 'ext.wikia.adEngine.lookup.openx.openXBidderHelper',
		config = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: ['728x90', '970x250']
				},
				HOME_TOP_LEADERBOARD: {
					sizes: ['728x90', '970x250']
				},
				TOP_RIGHT_BOXAD: {
					sizes: ['300x250', '300x600']
				},
				HOME_TOP_RIGHT_BOXAD: {
					sizes: ['300x250', '300x600']
				},
				LEFT_SKYSCRAPER_2: {
					sizes: ['160x600', '300x600']
				},
				LEFT_SKYSCRAPER_3: {
					sizes: ['160x600', '300x600']
				},
				INCONTENT_BOXAD_1: {
					sizes: ['300x250', '300x600', '160x600']
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: ['300x250']
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: ['300x250']
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: ['300x250']
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: ['300x250', '320x50']
				},
				MOBILE_PREFOOTER: {
					sizes: ['300x250', '320x50']
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: ['300x250', '320x50']
				}
			}
		};

	function getSlots() {
		return slots;
	}

	function addSlot(slotName, properties) {
		slots[slotName] = properties;
	}

	function removeSlot(slotName) {
		delete slots[slotName];
	}

	function isOpenXRemnantEnabledInGeo() {
		var context = adContext.getContext();
		return context.opts.openXRemnantEnabled;
	}

	function setupSlots(skin) {
		slots = slotsContext.filterSlotMap(config[skin]);
	}

	function isSlotSupported(slotName) {
		var isSupported = !!slots[slotName];

		log(['isSupported', slotName, isSupported], 'debug', logGroup);
		return isSupported;
	}

	function changeTimeout() {
		if (!openXTimeoutChanged) {
			if (win.OXHBConfig) {
				win.OXHBConfig.DFP_mapping.timeout = 0;
				log(['changeTimeout'], 'debug', logGroup);
			}
			openXTimeoutChanged = true;
		}
	}

	function getPagePath() {
		return [
			'/5441',
			'wka.' + adLogicZoneParams.getSite(),
			adLogicZoneParams.getName(),
			'',
			adLogicZoneParams.getPageType()
		].join('/');
	}

	function getSlothPath(slotName, src) {
		src = src || 'remnant';

		return 'wikia_gpt' + getPagePath() + '/' + src + '/' + slotName;
	}

	function addOpenXSlot(slotName) {
		if (isOpenXRemnantEnabledInGeo() && isSlotSupported(slotName) && win.OX) {
			log(['addOpenXSlot', slotName], 'debug', logGroup);
			changeTimeout();
			win.OX.dfp_bidder.addSlots([[getPagePath(), slots[slotName].sizes, getSlothPath(slotName)]]);
		}
	}

	return {
		addOpenXSlot: addOpenXSlot,
		getSlots: getSlots,
		addSlot: addSlot,
		removeSlot: removeSlot,
		isSlotSupported: isSlotSupported,
		setupSlots: setupSlots,
		getPagePath: getPagePath,
		getSlotPath: getSlothPath
	};
});
