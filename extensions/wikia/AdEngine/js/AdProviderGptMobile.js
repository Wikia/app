/*global define*/

define(
	'ext.wikia.adengine.provider.gptmobile',
	['wikia.log', 'wikia.window', 'wikia.document', 'ext.wikia.adengine.slottweaker', 'ext.wikia.adengine.gpthelper', 'ext.wikia.adengine.gptslotconfig'],
	function (log, window, document, slotTweaker, wikiaGpt, gptSlotConfig) {
		'use strict';

		var logGroup = 'AdProviderGptMobile',
			slotMap = gptSlotConfig.getConfig('mobile');

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
