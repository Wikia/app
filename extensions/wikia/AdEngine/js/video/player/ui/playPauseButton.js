/*global define*/
define('ext.wikia.adEngine.video.player.ui.playPauseButton', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.playPauseButton',
		animateCssClass = 'animate',
		playSvg = '<svg width="12" height="16" viewBox="0 0 12 16" xmlns="http://www.w3.org/2000/svg"><path d="M11.767 8.437L.857 15.903a.553.553 0 0 1-.564.037.53.53 0 0 1-.293-.473V.533c0-.2.113-.38.293-.473a.557.557 0 0 1 .565.036l10.91 7.467A.53.53 0 0 1 12 8a.53.53 0 0 1-.233.437z"/></svg>',
		pauseSvg = '<svg width="14" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg"><g><rect width="5" height="16" rx="1"/><rect x="9" width="5" height="16" rx="1"/></g></svg>',
		pauseCssClass = 'paused';

	function pause(elements) {
		elements.button.classList.add(pauseCssClass);
		elements.button.innerHTML = playSvg;

		elements.pauseShadow.classList.add(animateCssClass);

		log(['pause', log.levels.debug, logGroup]);
	}

	function resume(elements) {
		elements.button.classList.remove(pauseCssClass);
		elements.button.innerHTML = pauseSvg;

		elements.pauseShadow.classList.remove(animateCssClass);

		log(['resume', log.levels.debug, logGroup]);
	}

	function add(video, params) {
		var button = doc.createElement('a'),
			pauseShadow = doc.createElement('div'),
			elements = {
				button: button,
				pauseShadow: pauseShadow,
				video: video
			};

		button.classList.add('play-pause-button', 'control-bar-item');
		pauseShadow.classList.add('pause-shadow');

		button.innerHTML = pauseSvg;
		pauseShadow.innerHTML = pauseSvg;

		button.addEventListener('click', function () {
			if (video.isPaused()) {
				video.resume();
			} else {
				video.pause();
			}
		});

		video.addEventListener('pause', function () {
			pause(elements);
		});

		video.addEventListener('resume', function () {
			resume(elements);
		});

		params.controlBarItems.appendChild(button);
		video.container.appendChild(pauseShadow);
	}

	return {
		add: add
	};
});
