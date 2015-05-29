/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.gptSraHelper', [
	'wikia.log'
], function (log) {
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

	function shouldFlush(slotName) {
		if (sraSlots.indexOf(slotName) === -1) {
			flushed = true;
		}

		log(['shouldFlush', slotName, flushed], 'debug', logGroup);
		return flushed;
	}

	return {
		shouldFlush: shouldFlush
	}
});
