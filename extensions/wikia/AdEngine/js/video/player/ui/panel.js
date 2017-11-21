/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.panel', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.panel';

	function Panel(className, uiElements) {
		var panelContainer;

		if (!(uiElements instanceof Array)) {
			log(['Panel', name, uiElements, 'uiElements must be an array'], 'error', logGroup);
		}

		panelContainer = doc.createElement('div')
		panelContainer.className = className;
		uiElements = uiElements.map(function (element) {
			return 'ext.wikia.adEngine.video.player.ui.' + element;
		});

		this.getClassName = function () {
			return className;
		};

		this.add = function (video, params) {
			if (!params) {
				params = {};
			}

			params.panelContainer = panelContainer;
			require(uiElements, function () {
				Array.prototype.forEach.call(arguments, function (uiElement) {
					uiElement.add(video, params);
				});

				video.container.appendChild(panelContainer);
				log(['add', arguments, video], 'debug', logGroup);
			});
		};
	}

	return Panel;
});
