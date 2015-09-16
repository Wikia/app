/**
 * Module for getting information from "lookup" services such as Rubicon RTP or Amazon Match
 *
 * It exposes only a single method called extendSlotTargeting that given a slot name and
 * slot targeting object will consult the lookup services and update the slot targeting object
 * with the targeting information from them (rp_tier from RTP and amznslots from Amazon).
 *
 * This module also causes the lookup services to track their state when they are consulted
 * (but only once).
 */

/*global define, require*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.services', [
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.openXBidder'),
	require.optional('ext.wikia.adEngine.lookup.rubiconRtp')
], function (log, amazonMatch, oxBidder, rtp) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.services',
		rtpLookupTracked = false,
		amazonLookupTracked = false;

	function trackState(module) {
		if (module && module.wasCalled()) {
			module.trackState();
		}
	}

	function extendSlotTargeting(slotName, slotTargeting) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);

		var rtpSlots, rtpTier, amazonParams, oxParams;

		if (!rtpLookupTracked) {
			rtpLookupTracked = true;
			trackState(rtp);
		}

		if (!amazonLookupTracked) {
			amazonLookupTracked  = true;
			trackState(amazonMatch);
		}

		if (rtp && rtp.wasCalled()) {
			rtpSlots = rtp.getConfig().slotname;
			if (rtpSlots.length && rtpSlots.indexOf(slotName) !== -1) {
				rtpTier = rtp.getTier();
				if (rtpTier) {
					slotTargeting.rp_tier = rtpTier;
				}
			}
		}

		if (amazonMatch && amazonMatch.wasCalled() && Object.keys) {
			amazonParams = amazonMatch.getSlotParams(slotName);

			Object.keys(amazonParams).forEach(function (key) {
				slotTargeting[key] = amazonParams[key];
			});
		}

		if (oxBidder && oxBidder.wasCalled() && Object.keys) {
			oxParams = oxBidder.getSlotParams(slotName);

			Object.keys(oxParams).forEach(function (key) {
				slotTargeting[key] = oxParams[key];
			});
		}
	}

	return {
		extendSlotTargeting: extendSlotTargeting
	};
});
