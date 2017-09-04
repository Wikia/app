/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.dynamicReveal', [
	'ext.wikia.adEngine.slotTweaker',
	'wikia.document'
], function (slotTweaker, doc) {
	'use strict';

	var videoAspectRatio = 640 / 360;

	function add(video, params) {
		var slot = doc.getElementById(params.slotName),
			slotExpanded = false,
			slotWidth;

		video.addEventListener('start', function () {
			if (params.isDynamic && !slotExpanded) {
				slotTweaker.expand(params.slotName);
				slotExpanded = true;
				video.ima.dispatchEvent('wikiaSlotExpanded');
			}

			if (params.isDynamic) {
				slotWidth = slot.scrollWidth;
				video.resize(slotWidth, slotWidth / videoAspectRatio);
			}
		});

		video.addEventListener('allAdsCompleted', function () {
			video.ima.getAdsManager().pause();
			if (params.isDynamic) {
				slotTweaker.collapse(params.slotName);
				video.ima.dispatchEvent('wikiaSlotCollapsed');
			}
		});
	}

	return {
		add: add
	};
});
