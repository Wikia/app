/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openx.openXBidderHelper', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.geo',
	'wikia.log',
	'wikia.window'
], function (adLogicZoneParams, geo, log, win) {
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

	function openXRemnantEnabled() {
		return geo.getCountryCode() === 'NZ';
	}

	function addOpenXSlot(slotName) {
		if (openXRemnantEnabled() && isSlotSupported(slotName)) {
			log(['addOpenXSlot', slotName], 'debug', logGroup);
			changeTimeout();
			win.OX.dfp_bidder.addSlots([[getPagePath(), slots[slotName].sizes, getSlothPath(slotName)]]);
		} else {
			log(['addOpenXSlot', slotName, geo.getCountryCode(), 'Slot not supported'], 'debug', logGroup);
		}
	}

	function isSlotSupported(slotName) {
		return !!slots[slotName];
	}
	function changeTimeout() {
		if (!timeoutChanged) {
			log(['changeTimeout'], 'debug', logGroup);
			win.OXHBConfig.DFP_mapping.timeout = 0;
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
