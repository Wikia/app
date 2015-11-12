/**
 * Module for getting information from "lookup" services such as Amazon Match
 *
 * It exposes only a single method called extendSlotTargeting that given a slot name and
 * slot targeting object will consult the lookup services and update the slot targeting object
 * with the targeting information from them (e.g. amznslots from Amazon).
 *
 * This module also causes the lookup services to track their state when they are consulted
 * (but only once).
 */
/*global define, require*/
define('ext.wikia.adEngine.lookup.services', [
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.openXBidder')
], function (log, amazonMatch, oxBidder) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.lookup.services',
		bidders = [
			{
				module: amazonMatch,
				tracked: false
			},
			{
				module: oxBidder,
				tracked: false
			}
		];

	function trackState() {
		bidders.forEach(function (bidder) {
			if (!bidder.tracked && bidder.module && bidder.module.wasCalled()) {
				bidder.tracked = true;
				bidder.module.trackState();
			}
		});
	}

	function addParameters(slotName, slotTargeting) {
		var params;
		if (!Object.keys) {
			return;
		}
		bidders.forEach(function (bidder) {
			if (bidder.module && bidder.module.wasCalled()) {
				params = bidder.module.getSlotParams(slotName);
				Object.keys(params).forEach(function (key) {
					slotTargeting[key] = params[key];
				});
			}
		});
	}

	function extendSlotTargeting(slotName, slotTargeting) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);
		trackState();
		addParameters(slotName, slotTargeting);
	}

	return {
		extendSlotTargeting: extendSlotTargeting
	};
});
