/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [
	'wikia.log'
], function (log) {
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
		],
		featureVideo = [
			'progressBar',
			'playPauseButton',
			'soundControl'
		],
		logGroup = 'ext.wikia.adEngine.video.player.uiTemplate';

	function selectTemplate(videoSettings) {
		var template = defaultLayout;

		if (!videoSettings.isAutoPlay() && videoSettings.isSplitLayout()) {
			template = clickToPlaySplitLayout;
		} else if (videoSettings.isSplitLayout()) {
			template = splitLayout;
		} else if (videoSettings.isAutoPlay()) {
			template = autoPlayLayout;
		}

		log(['VUAP UI elements', template], log.levels.debug, logGroup);
		return template;
	}

	return {
		autoPlayLayout: autoPlayLayout,
		defaultLayout: defaultLayout,
		splitLayout: splitLayout,
		featureVideo: featureVideo,
		selectTemplate: selectTemplate
	};
});
