/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (DOMElementTweaker, slotTweaker, videoAdFactory, log, doc, win, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD'),
		imageContainer;

	function calculateVideoSize(element, videoAspectRatio) {
		return {
			width: element.clientWidth,
			height: element.clientWidth / videoAspectRatio
		};
	}

	function showVideo(videoContainer) {
		DOMElementTweaker.hide(imageContainer, false);
		DOMElementTweaker.removeClass(videoContainer, 'hidden');

	}

	function hideVideo(videoContainer) {
		DOMElementTweaker.hide(videoContainer, false);
		DOMElementTweaker.removeClass(imageContainer, 'hidden');

	}

	function initializeVideoAd(iframe, params) {
		try {
			imageContainer = slot.querySelector('div');
			var size = calculateVideoSize(iframe, params.videoAspectRatio),
				video = videoAdFactory.create(
				size.width,
				size.height,
				slot,
				{
					src: 'gpt',
					slotName: params.pos,
					uap: params.uap,
					passback: 'vuap'
				}
			);

			win.addEventListener('resize', function () {
				var size = calculateVideoSize(iframe, params.videoAspectRatio);
				video.resize(size.width, size.height);
			});

			params.videoTriggerElement.addEventListener('click', function () {
				video.play(showVideo, hideVideo);
			});
		} catch (error) {
			log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
		}
	}

	function show(params) {
		slot.classList.add('bfab-template');
		slotTweaker.makeResponsive(slot.id, params.aspectRatio);

		slotTweaker.onReady(slot.id, function (iframe) {
			if (recoveryTweaker && recoveryTweaker.isTweakable()) {
				recoveryTweaker.tweakSlot(slot.id, iframe);
			}

			if (videoAdFactory.isVideoAd(params)) {
				initializeVideoAd(iframe, params);
			}
		});

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
