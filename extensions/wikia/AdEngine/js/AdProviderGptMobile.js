/*global define*/

define(
	'ext.wikia.adengine.provider.gptmobile',
	['wikia.log', 'wikia.window', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper'],
	function (log, window, slotTweaker, wikiaGpt) {
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
	}
);
