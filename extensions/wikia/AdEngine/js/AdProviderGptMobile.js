/*global define*/

define(
	'ext.wikia.adengine.provider.gptmobile',
	['wikia.log', 'wikia.window', 'wikia.document', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper'],
	function (log, window, document, slotTweaker, wikiaGpt) {
		'use strict';

		var logGroup = 'AdProviderGptMobile',
			slotMap = {
				MOBILE_TOP_LEADERBOARD: {size: '320x50'},
				MOBILE_IN_CONTENT: {size: '300x250'},
				MOBILE_PREFOOTER: {size: '300x250'}
			};

		function canHandleSlot(slotname) {
			return !!slotMap[slotname];
		}

		function fillInSlot(slotname, success, hop) {
			log(['fillInSlot', slotname], 'debug', logGroup);

			function hopToNull() {
				hop({method: 'hop'}, 'Null');
			}

			function showAdAndCallSuccess() {
				document.getElementById(slotname).className += ' show';
				success();
			}

			function hopToRemnant() {
				hop({method: 'hop'}, 'RemnantDart');
			}

			wikiaGpt.pushAd(slotname, showAdAndCallSuccess, (window.wgEnableRHonMobile ? hopToRemnant : hopToNull), 'mobile');
			wikiaGpt.flushAds();
		}

		return {
			name: 'GptMobile',
			fillInSlot: fillInSlot,
			canHandleSlot: canHandleSlot
		};
	}
);
