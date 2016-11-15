/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (slotTweaker, videoAd, log, doc, win, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function isVideoAd(params) {
		return params.videoAspectRatio && params.uap;
	}

	function calculateVideoSize(element, videoAspectRatio) {
		var width = parseInt(win.getComputedStyle(element).width.replace('px', ''));
		return {
			width: width,
			height: width / videoAspectRatio
		};
	}

	function initializeVideoAd(iframe, params) {
		var providerContainer = slot.querySelector('div');

		var video = videoAd.create(
			providerContainer,
			calculateVideoSize(iframe, params.videoAspectRatio),
			slot,
			{
				src: 'gpt',
				slotName: params.pos,
				uap: params.uap,
				passback: 'vuap'
			}
		);

		win.addEventListener('resize', function () {
			video.updateSize(calculateVideoSize(iframe, params.videoAspectRatio));
		});

		params.videoTriggerElement.addEventListener('click', video.play.bind(video));
	}

	function show(params) {
		slot.classList.add('bfab-template');
		slotTweaker.makeResponsive(slot.id, params.aspectRatio);

		slotTweaker.onReady(slot.id, function (iframe) {
			if (recoveryTweaker && recoveryTweaker.isTweakable()) {
				recoveryTweaker.tweakSlot(slot.id, iframe);
			}

			if (isVideoAd(params)) {
				initializeVideoAd(iframe, params);
			}
		});

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
