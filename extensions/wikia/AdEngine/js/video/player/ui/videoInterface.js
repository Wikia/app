/*global define, require*/
define('ext.wikia.adEngine.video.player.ui.videoInterface', [
	'ext.wikia.adEngine.video.player.ui.panel',
	'wikia.log'
], function (Panel, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.videoInterface';

	function setup(video, uiElements, params) {
		uiElements.forEach(function (element) {
			var module = 'ext.wikia.adEngine.video.player.ui.' + element;

			if (element instanceof Panel) {
				element.add(video, params);
			} else {
				require([module], function (uiElement) {
					uiElement.add(video, params);
					log(['setup', element, video], 'debug', logGroup);
				});
			}
		});
	}

	return {
		setup: setup
	};
});
