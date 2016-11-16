/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.log',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (slotTweaker, videoAdFactory, log, doc, win, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function calculateVideoSize(element, videoAspectRatio) {
		return {
			width: element.clientWidth,
			height: element.clientWidth / videoAspectRatio
		};
	}

	function initializeVideoAd(iframe, params) {
		try {
			var providerContainer = slot.querySelector('div'),
				video = videoAdFactory.create(
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
