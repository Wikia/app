/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.dynamicReveal', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.player.porvata.floater',
	'wikia.document'
], function (slotTweaker, floater, doc) {
	'use strict';

	var videoAspectRatio = 640 / 360;

	function add(video, params) {
		var slot,
			slotExpanded = false,
			slotWidth;

		if (params.isDynamic) {
			slot = doc.getElementById(params.slotName);

			video.addEventListener('start', function () {
				if (!slotExpanded) {
					slotTweaker.expand(params.slotName);
					slotExpanded = true;
					// Delay dispatching event so it's run after browser really start expanding the slot
					setTimeout(function () {
						video.ima.dispatchEvent('wikiaSlotExpanded');
					}, 0);
				}

				slotWidth = slot.scrollWidth;

				if (!floater.isFloating(params.slotName)) {
					video.resize(slotWidth, slotWidth / videoAspectRatio);
				}
			});

			video.addEventListener('allAdsCompleted', function () {
				slotTweaker.collapse(params.slotName);
				video.ima.dispatchEvent('wikiaSlotCollapsed');
			});
		}
	}

	return {
		add: add
	};
});
