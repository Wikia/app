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
	require.optional('ext.wikia.adEngine.lookup.openXBidder'),
	require.optional('ext.wikia.adEngine.lookup.rubiconFastlane')
], function (log, amazonMatch, oxBidder, rubiconFastlane) {
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
			},
			{
				module: rubiconFastlane,
				tracked: false
			}
		];

	function trackState(providerName, slotName, params) {
		bidders.forEach(function (bidder) {
			if (bidder.module && bidder.module.wasCalled()) {
				bidder.module.trackState(false, providerName, slotName, params);
			}
		});
	}

	function addParameters(slotName, slotTargeting) {
		var params = {};
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

		return params;
	}

	function extendSlotTargeting(slotName, slotTargeting, providerName) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);
		var params = addParameters(slotName, slotTargeting);
		providerName = providerName.toLowerCase().replace('gpt', '');
		trackState(providerName, slotName, params);
	}

	return {
		extendSlotTargeting: extendSlotTargeting
	};
});
