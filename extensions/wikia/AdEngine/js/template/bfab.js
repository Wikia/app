/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.uapVideo',
	'wikia.log',
	'wikia.document',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (slotTweaker, uapVideo, log, doc, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function show(params) {
		slot.classList.add('bfab-template');
		slotTweaker.makeResponsive(slot.id, params.aspectRatio);

		slotTweaker.onReady(slot.id, function (iframe) {
			if (recoveryTweaker && recoveryTweaker.isTweakable()) {
				recoveryTweaker.tweakSlot(slot.id, iframe);
			}

			uapVideo.init()
				.then(function () {
					uapVideo.loadVideoAd(params, slot, slot.querySelector('div'));
				});
		});

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
