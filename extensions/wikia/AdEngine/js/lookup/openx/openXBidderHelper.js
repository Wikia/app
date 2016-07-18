/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openx.openXBidderHelper', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.instantGlobals',
	'wikia.geo',
	'wikia.log',
	'wikia.window'
], function (adLogicZoneParams, instantGlobals, geo, log, win) {
	'use strict';

	var slots = [],
		timeoutChanged = false,
		logGroup = 'ext.wikia.adEngine.lookup.openx.openXBidderHelper';

	function setSlots(newSlots) {
		slots = newSlots;
	}

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
		var isEnabled = geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountriesRemnant);
		log(['isOpenXRemnantEnabledInGeo', isEnabled], 'debug', logGroup);
		return !!isEnabled;
	}

	function addOpenXSlot(slotName) {
		log(['addOpenXSlot', slotName], 'debug', logGroup);
		if (isOpenXRemnantEnabledInGeo() && isSlotSupported(slotName)) {
			changeTimeout();
			win.OX.dfp_bidder.addSlots([[getPagePath(), slots[slotName].sizes, getSlothPath(slotName)]]);
		}
	}

	function isSlotSupported(slotName) {
		var isSlotSupported = !!slots[slotName];

		log(['isSlotSupported', slotName, isSlotSupported], 'debug', logGroup);
		return isSlotSupported;
	}

	function changeTimeout() {
		if (!timeoutChanged) {
			win.OXHBConfig.DFP_mapping.timeout = 0;
			log(['changeTimeout'], 'debug', logGroup);
			timeoutChanged = true;
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
		src = src || "remnant";
		return [
			'wikia_gpt',
			'5441',
			'wka.' + adLogicZoneParams.getSite(),
			adLogicZoneParams.getName(),
			'',
			adLogicZoneParams.getPageType(),
			src,
			slotName
		].join('/');
	}

	return {
		slots: slots,
		addOpenXSlot: addOpenXSlot,
		getSlots: getSlots,
		setSlots: setSlots,
		addSlot: addSlot,
		removeSlot: removeSlot
	}
});
