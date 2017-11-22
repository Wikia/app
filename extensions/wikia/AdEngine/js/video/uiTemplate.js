/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [
	'ext.wikia.adEngine.video.player.ui.panel',
	'wikia.log'
], function (Panel, log) {
	'use strict';

	var createBottomPanel = function (uiElements) {
			return new Panel('bottom-panel', uiElements);
		},
		autoPlayLayout = [
			'progressBar',
			'pauseOverlay',
			'toggleAnimation',
			createBottomPanel(['volumeControl'])
		],
		defaultLayout = [
			'progressBar',
			'pauseOverlay',
			'closeButton',
			'toggleAnimation',
			createBottomPanel(['volumeControl'])
		],
		splitLayout = [
			'progressBar',
			'pauseOverlay',
			'toggleVideo',
			'replayOverlay',
			createBottomPanel(['volumeControl'])
		],
		clickToPlaySplitLayout = [
			'progressBar',
			'pauseOverlay',
			'toggleVideo',
			'replayOverlay',
			'closeButton',
			createBottomPanel(['volumeControl'])
		],
		outstreamIncontent = [
			'dynamicReveal',
			'mouseEvents',
			'progressBar',
			createBottomPanel(['volumeControl'])
		],
		outstreamLeaderboard = [
			'mouseEvents',
			'progressBar',
			createBottomPanel(['volumeControl'])
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
		outstreamIncontent: outstreamIncontent,
		outstreamLeaderboard: outstreamLeaderboard,
		selectTemplate: selectTemplate
	};
});
