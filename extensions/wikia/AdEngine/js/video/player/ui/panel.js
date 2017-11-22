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

		this.getContainer = function () {
			return panelContainer;
		}

		this.add = function (video, params, panel) {
			require(uiElements, function () {
				var container = panel ? panel.getContainer() : video.container;

				Array.prototype.forEach.call(arguments, function (uiElement) {
					uiElement.add(video, params, this);
				}.bind(this));

				container.appendChild(panelContainer);
				log(['add', arguments, video], 'debug', logGroup);
			}.bind(this));
		};
	}

	return Panel;
});
