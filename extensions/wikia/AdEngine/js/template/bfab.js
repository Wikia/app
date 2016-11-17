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

	var animationDuration = 400,
		logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD'),
		imageContainer,
		slotSizes;

	function calculateSizes(element, params) {
		return {
			width: element.clientWidth,
			height: element.clientWidth / params.videoAspectRatio,
			adHeight: element.clientWidth / params.aspectRatio,
			videoHeight: element.clientWidth / params.videoAspectRatio
		};
	}

	function showVideo(videoContainer) {
		slot.style.height = slotSizes.adHeight + 'px';
		DOMElementTweaker.hide(imageContainer, false);
		DOMElementTweaker.removeClass(videoContainer, 'hidden');
		setTimeout(function () {
			slot.style.height = slotSizes.videoHeight + 'px';
		}, 0);

		setTimeout(function () {
			slot.style.height = '';
		}, animationDuration);
	}

	function hideVideo(videoContainer) {
		slot.style.height = slotSizes.videoHeight + 'px';
		setTimeout(function () {
			slot.style.height = slotSizes.adHeight + 'px';
		}, 0);

		setTimeout(function () {
			DOMElementTweaker.hide(videoContainer, false);
			DOMElementTweaker.removeClass(imageContainer, 'hidden');
		}, animationDuration);

		setTimeout(function () {
			slot.style.height = '';
		}, animationDuration);
	}

	function initializeVideoAd(iframe, params) {
		try {
			slotSizes = calculateSizes(iframe, params);
			imageContainer = slot.querySelector('div');

			var video = videoAdFactory.create(
				slotSizes.width,
				slotSizes.height,
				slot,
				{
					src: 'gpt',
					slotName: params.pos,
					uap: params.uap,
					passback: 'vuap'
				}
			);

			win.addEventListener('resize', function () {
				var size = calculateSizes(iframe, params);
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
