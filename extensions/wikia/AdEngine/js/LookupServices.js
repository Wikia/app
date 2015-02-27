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
define('ext.wikia.adEngine.lookupServices', [
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.rubiconRtp'),
	require.optional('ext.wikia.adEngine.amazonMatch'),
	require.optional('ext.wikia.adEngine.amazonMatchOld')
], function (log, win, rtp, amazonMatch, amazonMatchOld) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookupServices',
		rtpLookupTracked = false,
		amazonLookupTracked = false;

	// Copied from AdLogicPageParams
	// TODO: DRY
	function extend(target, obj) {
		var key;

		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				target[key] = obj[key];
			}
		}

		return target;
	}

	// Copied from AdLogicPageParams
	// TODO: DRY
	function decodeLegacyDartParams(dartString) {
		var params = {},
			kvs,
			kv,
			key,
			value,
			i,
			len;

		log(['decodeLegacyDartParams', dartString], 9, logGroup);

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

	function trackState(module) {
		if (module && module.wasCalled()) {
			module.trackState();
		}
	}

	function extendSlotTargeting(slotName, slotTargeting) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);

		var rtpSlots, rtpTier;

		if (!rtpLookupTracked) {
			rtpLookupTracked = true;
			trackState(rtp);
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
	}

	function extendPageTargeting(pageTargeting) {
		var amazonParams;

		if (!amazonLookupTracked) {
			amazonLookupTracked  = true;
			trackState(amazonMatch);
			trackState(amazonMatchOld);
		}

		if (amazonMatchOld && amazonMatchOld.wasCalled()) {
			extend(pageTargeting, decodeLegacyDartParams(win.amzn_targs));
		}

		if (amazonMatch && amazonMatch.wasCalled() && Object.keys) {
			amazonParams = amazonMatch.getPageParams();
			Object.keys(amazonParams).forEach(function (key, i) {
				// Only return 10 first params from Amazon
				// TODO: Fix with ADEN-1770
				if (i < 10) {
					pageTargeting[key] = amazonParams[key];
				}
			});
		}
	}

	return {
		extendSlotTargeting: extendSlotTargeting,
		extendPageTargeting: extendPageTargeting
	};
});
