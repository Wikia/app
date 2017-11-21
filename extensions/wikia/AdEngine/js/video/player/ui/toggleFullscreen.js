/*global define*/
define('ext.wikia.adEngine.video.player.ui.toggleFullscreen', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.toggleFullscreen',
		fullscreenOnClassName = 'fullscreen-on',
		svgIcons = {
			off: '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 9H8V2H5v4H1v3h4.5zm13 0H16V2h3v4h4v3h-4.5zm-13 6H8v7H5v-4H1v-3h4.5zm13 0H16v7h3v-4h4v-3h-4.5z" fill-rule="evenodd"/></svg>',
			on: '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.5 22H23v-7h-3v4h-4v3h5.5zM23 3.5V9h-3V5h-4V2h7v1.5zm-22 17V15h3v4h4v3H1v-1.5zM2.5 2H1v7h3V5h4V2H2.5z" fill-rule="evenodd"/></svg>'
		};

	function add(video, params) {
		var parser = new win.DOMParser(),
			icons = {
				off: parser.parseFromString(svgIcons.off, 'image/svg+xml').documentElement,
				on: parser.parseFromString(svgIcons.on, 'image/svg+xml').documentElement
			},
			toggleFullscreenButton = doc.createElement('div');

		icons.off.classList.add('fullscreen-off-icon');
		icons.on.classList.add('fullscreen-on-icon');
		toggleFullscreenButton.classList.add('toggle-fullscreen');
		toggleFullscreenButton.appendChild(icons.off);
		toggleFullscreenButton.appendChild(icons.on);
		toggleFullscreenButton.addEventListener('click', function (event) {
			var isFullscreen = video.toggleFullscreen();

			if (isFullscreen) {
				toggleFullscreenButton.classList.add(fullscreenOnClassName);
			} else {
				toggleFullscreenButton.classList.remove(fullscreenOnClassName);
			}

			event.preventDefault();
			log(['toggleFullscreen', log.levels.debug, logGroup]);
		});

		(params.panelContainer || video.container).appendChild(toggleFullscreenButton);
	}

	return {
		add: add
	};
});
