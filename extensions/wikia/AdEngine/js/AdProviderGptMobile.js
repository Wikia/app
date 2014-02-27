/*global define*/

define(
	'ext.wikia.adengine.provider.gptmobile',
	['wikia.log', 'wikia.window', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper'],
	function (log, window, slotTweaker, wikiaGpt) {
		'use strict';

		var logGroup = 'AdProviderGptMobile',
			srcName = 'mobile',
			slotMap = {
				MOBILE_TOP_LEADERBOARD: {size: '320x50'},
				MOBILE_IN_CONTENT: {size: '300x250'},
				MOBILE_PREFOOTER: {size: '300x250'}
			};

		wikiaGpt.init(slotMap, srcName);

		function canHandleSlot(slotname) {
			return !!slotMap[slotname];
		}

		function fillInSlot(slotname, success, hop) {
			log(['fillInSlot', slotname], 'debug', logGroup);

			function hopToNull() {
				hop({method: 'hop'}, 'Null');
			}

			wikiaGpt.pushAd(slotname, success, hopToNull, srcName);
			wikiaGpt.flushAds();
		}

		return {
			name: 'GptMobile',
			fillInSlot: fillInSlot,
			canHandleSlot: canHandleSlot
		};
	}
);
