/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.gptSraHelper', [
	'ext.wikia.adEngine.gptHelper',
	'wikia.log'
], function (gptHelper, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.gptSraHelper',
		flushed = false,
		sraSlots = [
			'CORP_TOP_LEADERBOARD',
			'HOME_TOP_LEADERBOARD',
			'HUB_TOP_LEADERBOARD',
			'INVISIBLE_SKIN',
			'TOP_LEADERBOARD'
		];

	function shouldPush(slotName, slotTargeting) {
		var result = !(slotTargeting && slotTargeting.flushOnly);

		log(['shouldPush', slotName, result], 'debug', logGroup);
		return result;
	}

	function shouldFlush(slotName) {
		if (sraSlots.indexOf(slotName) === -1) {
			flushed = true;
		}

		log(['shouldFlush', slotName, flushed], 'debug', logGroup);
		return flushed;
	}

	function pushAd(slotName, slotPath, slotTargeting, success, error, forcedAdType) {
		if (shouldPush(slotName, slotTargeting)) {
			gptHelper.pushAd(slotName, slotPath, slotTargeting, success, error, forcedAdType);
			log(['pushAd', 'Pushed slot:', slotName], 'debug', logGroup);
		} else {
			success({});
		}

		if (shouldFlush(slotName)) {
			gptHelper.flushAds();
			log(['pushAd', 'Flushing slot:', slotName], 'debug', logGroup);
		}
	}

	return {
		pushAd: pushAd
	}
});
