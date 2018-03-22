/*global define, require*/
define('ext.wikia.adEngine.video.player.ui.videoInterface', [
	'wikia.log'
], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.videoInterface';

	function setup(video, uiElements, params) {
		uiElements.forEach(function (element) {
			var module = 'ext.wikia.adEngine.video.player.ui.' + element;
			require([module], function (uiElement) {
				uiElement.add(video, params);
				log(['setup', element, video], 'debug', logGroup);
			});
		});
	}

	return {
		setup: setup
	};
});
