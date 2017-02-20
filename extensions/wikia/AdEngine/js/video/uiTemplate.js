/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [], function () {
	'use strict';

	var autoPlayLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleAnimation'
		],
		defaultLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'closeButton',
			'toggleAnimation'
		],
		splitLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleVideo',
			'replayOverlay'
		],
		clickToPlaySplitLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleVideo',
			'replayOverlay',
			'closeButton'
		];

	function selectTemplate(videoSettings) {
		var template = defaultLayout;

		if (!videoSettings.isAutoPlay() && videoSettings.isSplitLayout()) {
			template = clickToPlaySplitLayout;
		} else if (videoSettings.isSplitLayout()) {
			template = splitLayout;
		} else if (videoSettings.isAutoPlay()) {
			template = autoPlayLayout;
		}

		return template;
	}

	return {
		autoPlayLayout: autoPlayLayout,
		defaultLayout: defaultLayout,
		splitLayout: splitLayout,
		selectTemplate: selectTemplate
	};
});
