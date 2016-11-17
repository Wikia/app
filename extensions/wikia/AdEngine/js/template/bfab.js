/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.domElementTweaker',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (adHelper, slotTweaker, videoAdFactory, log, doc, DOMElementTweaker, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slotSizes,
		animationDuration = 400,
		imageContainer,
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function getSlotSize(element, params) {
		var width = element.clientWidth;
		return {
			width: width,
			videoHeight: width / params.videoAspectRatio,
			adHeight: width / params.aspectRatio
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

	function loadVideoAd(iframe, params) {
		try {
			var video = videoAdFactory.create(
				slotSizes.width,
				slotSizes.videoHeight,
				slot,
				{
					src: 'gpt',
					pos: params.slotName,
					uap: params.uap,
					passback: 'vuap'
				}
			);

			window.addEventListener('resize', adHelper.throttle(function () {
				slotSizes = getSlotSize(params);
				video.resize(slotSizes.width, slotSizes.videoHeight);
			}));

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
			imageContainer = slot.querySelector('div');

			slotSizes = getSlotSize(iframe, params);
			loadVideoAd(iframe, params);
		});

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
