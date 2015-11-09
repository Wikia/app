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
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.services', [
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.openXBidder')
], function (log, amazonMatch, oxBidder) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.services',
		oxLookupTracked = false,
		amazonLookupTracked = false;

	function trackState(module) {
		if (module && module.wasCalled()) {
			module.trackState();
		}
	}

	function addParameters(slotName, slotTargeting, modules) {
		var params;
		if (!Object.keys) {
			return;
		}
		modules.forEach(function (module) {
			if (module && module.wasCalled()) {
				params = module.getSlotParams(slotName);
				Object.keys(params).forEach(function (key) {
					slotTargeting[key] = params[key];
				});
			}
		});
	}

	function extendSlotTargeting(slotName, slotTargeting) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);

		if (!amazonLookupTracked) {
			amazonLookupTracked  = true;
			trackState(amazonMatch);
		}

		if (!oxLookupTracked) {
			oxLookupTracked  = true;
			trackState(oxBidder);
		}

		addParameters(slotName, slotTargeting, [amazonMatch, oxBidder]);
	}

	return {
		extendSlotTargeting: extendSlotTargeting
	};
});
