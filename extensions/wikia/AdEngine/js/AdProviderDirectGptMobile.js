/*global define*/

define(
	'ext.wikia.adengine.provider.directgptmobile',
	['wikia.log', 'wikia.window', 'wikia.document', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper', 'ext.wikia.adengine.gptslotconfig'],
	function (log, window, document, slotTweaker, wikiaGpt, gptSlotConfig) {
		'use strict';

		var logGroup = 'AdProviderDirectGptMobile',
			slotMap = gptSlotConfig.getConfig('mobile');

		function canHandleSlot(slotname) {
			return !!slotMap[slotname];
		}

		function fillInSlot(slotname, success, hop) {
			log(['fillInSlot', slotname], 'debug', logGroup);

			function hopToNull() {
				hop({method: 'hop'}, 'Null');
			}

			function hopToRemnant() {
				hop({method: 'hop'}, 'RemnantDart');
			}

			function showAdAndCallSuccess() {
				document.getElementById(slotname).className += ' show';
				success();
			}

			wikiaGpt.pushAd(slotname, showAdAndCallSuccess, (window.wgEnableRHonMobile ? hopToRemnant : hopToNull), 'mobile');
			wikiaGpt.flushAds();
		}

		return {
			name: 'DirectGptMobile',
			fillInSlot: fillInSlot,
			canHandleSlot: canHandleSlot
		};
	}
);
