/* exported AdProviderGptMobile */
/* jshint maxparams: false */

var AdProviderGptMobile = function (log, window, slotTweaker, wikiaGpt) {
	'use strict';

	var logGroup = 'AdProviderGptMobile',
		slotMap = {
			MOBILE_TOP_LEADERBOARD: {size: '320x50'},
			MOBILE_IN_CONTENT: {size: '300x250'},
			MOBILE_PREFOOTER: {size: '300x250'}
		};

	wikiaGpt.init(slotMap, 'mobile');

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		wikiaGpt.pushAd(
			slotname,
			function () {
				// Success
				slotTweaker.removeDefaultHeight(slotname);
				success();
			},
			function () {
				// Hop
				hop({method: 'hop'}, 'Null');
			}
		);
		wikiaGpt.flushAds();
	}

	return {
		name: 'GptMobile',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
