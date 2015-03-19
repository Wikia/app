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
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.amazonMatchOld'),
	require.optional('ext.wikia.adEngine.lookup.rubiconRtp')
], function (log, win, amazonMatch, amazonMatchOld, rtp) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.services',
		rtpLookupTracked = false,
		amazonLookupTracked = false,
		amazonOldLookupTracked = false;

	function trackState(module) {
		if (module && module.wasCalled()) {
			module.trackState();
		}
	}

	function extendSlotTargeting(slotName, slotTargeting) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);

		var rtpSlots, rtpTier, amazonParams;

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
	}

	// Copied from AdLogicPageParams
	// No longer needed when AmazonOld is removed
	function decodeLegacyDartParams(dartString) {
		var params = {},
			kvs,
			kv,
			key,
			value,
			i,
			len;

		log(['decodeLegacyDartParams', dartString], 'debug', logGroup);

		if (typeof dartString === 'string') {
			kvs = dartString.split(';');
			for (i = 0, len = kvs.length; i < len; i += 1) {
				kv = kvs[i].split('=');
				key = kv[0];
				value = kv[1];
				if (key && value) {
					params[key] = params[key] || [];
					params[key].push(value);
				}
			}
		}

		return params;
	}

	// No longer needed when AmazonOld is removed
	function extendPageTargeting(pageTargeting) {
		var amazonParams;

		if (!amazonOldLookupTracked) {
			amazonOldLookupTracked  = true;
			trackState(amazonMatchOld);
		}

		if (amazonMatchOld && amazonMatchOld.wasCalled() && Object.keys) {
			amazonParams = decodeLegacyDartParams(win.amzn_targs);
			Object.keys(amazonParams).forEach(function (key) {
				pageTargeting[key] = amazonParams[key];
			});
		}
	}

	return {
		extendSlotTargeting: extendSlotTargeting,
		extendPageTargeting: extendPageTargeting
	};
});
