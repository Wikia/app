/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openx.openXBidderHelper', [
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.log',
	'wikia.window'
], function (adLogicZoneParams, log, win) {
	'use strict';

	var slots = [],
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

	function addOpenXSlot(slotName) {
		log(['addOpenXSlot', slotName], 'debug', logGroup);
		OXHBConfig.DFP_mapping.timeout = 0;
		win.OX.dfp_bidder.addSlots([[getPagePath(), slots[slotName].sizes, getSlothPath(slotName)]]);
	}

	//function setSlotTargeting(slotName, src) {
	//	//var ads = getAdsWithNewSlot(slotName, src);
	//	//OX.dfp_bidder.setOxTargeting(ads);
	//	var ads = window.googletag.pubads().getSlots().slice();
	//	ads.push(ads[1]);
	//	ads[ads.length-1].G = "/5441/wka.life/_adtest//article/remnant/TOP_RIGHT_BOXAD";
	//	OX.dfp_bidder.setOxTargeting(ads);
	//}
	//
	//function getAdsWithNewSlot(slotName) {
	//	var ads = win.googletag.pubads().getSlots().slice(), adToPush;
	//
	//	ads.forEach( function(ad, index) {
	//		if (ad.G.indexOf(slotName) > -1) {
	//			adToPush = ads.slice(index, index+1);
	//			adToPush.G = getSlothPath(slotName);
	//		}
	//	});
	//
	//	adToPush && ads.push(adToPush);
	//
	//	return ads;
	//}
	//
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
