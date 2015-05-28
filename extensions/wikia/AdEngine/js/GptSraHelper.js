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

	function pushAd(slotName, slotPath, slotTargeting, success, error, forcedAdType) {
		if (slotTargeting && slotTargeting.flushOnly) {
			success({});
		} else {
			gptHelper.pushAd(slotName, slotPath, slotTargeting, success, error, forcedAdType);
			log(['pushAd', 'Pushed slot', slotName], 'debug', logGroup);
		}

		if (flushed || sraSlots.indexOf(slotName) === -1) {
			gptHelper.flushAds();
			flushed = true;
			log(['pushAd', 'Flushing slot', slotName], 'debug', logGroup);
		}
	}

	return {
		pushAd: pushAd
	}
});
