/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slot.resolvedState',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.uapVideo',
	'ext.wikia.adEngine.video.videoSettings',
	'wikia.log',
	'wikia.document',
	require.optional('ext.wikia.aRecoveryEngine.tweaker')
], function (resolvedState, slotTweaker, uapVideo, VideoSettings, log, doc, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	/**
	 * @param {object} params
	 * @param {float} params.aspectRatio - Ad container aspect ratio
	 * @param {string} params.backgroundColor - Hex value of background color
	 * @param {string} params.slotName - Slot name key-value needed for VastUrlBuilder
	 * @param {float} [params.videoAspectRatio] - Video aspect ratio
	 * @param {object} [params.videoTriggerElement] - DOM element which triggers video (button or background)
	 */
	function show(params) {
		var videoSettings = VideoSettings.create(params);

		slot.classList.add('bfab-template');
		resolvedState.setImage(videoSettings);

		slotTweaker.makeResponsive(slot.id, params.aspectRatio);

		slotTweaker.onReady(slot.id, function (iframe) {
			if (recoveryTweaker && recoveryTweaker.isTweakable()) {
				recoveryTweaker.tweakSlot(slot.id, iframe);
			}

			if (uapVideo.isEnabled(params)) {
				uapVideo.loadVideoAd(videoSettings);
			}
		});

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
