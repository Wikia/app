/*global define*/
define('ext.wikia.adEngine.video.player.ui.progressBar', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document',
	'wikia.log'
], function (DOMElementTweaker, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.progressBar';

	function add(video, params) {
		var progressBar = doc.createElement('div'),
			currentTime = doc.createElement('div');

		progressBar.classList.add('progress-bar');
		currentTime.classList.add('current-time');

		progressBar.currentTime = currentTime;
		progressBar.appendChild(currentTime);

		progressBar.pause = function () {
			var currentStatus = (currentTime.offsetWidth / progressBar.offsetWidth * 100) + '%';

			currentTime.style.width = currentStatus;
			log(['pause', currentStatus], log.levels.debug, logGroup);
		};
		progressBar.reset = function () {
			currentTime.style.transitionDuration = '';
			currentTime.style.width = '0';
			log(['update, reset'], log.levels.debug, logGroup);
		};
		progressBar.start = function () {
			var remainingTime = video.getRemainingTime();

			if (remainingTime) {
				currentTime.style.transitionDuration = remainingTime + 's';
				DOMElementTweaker.forceRepaint(currentTime);
				currentTime.style.width = '100%';
			} else {
				currentTime.style.width = '0';
			}
			log(['update, remaining time:', remainingTime], log.levels.debug, logGroup);
		};

		video.addEventListener('wikiaAdPlay', progressBar.start);
		video.addEventListener('wikiaAdCompleted', progressBar.reset);
		video.addEventListener('wikiaAdPause', progressBar.pause);

		if (params.controlBar) {
			params.controlBar.insertBefore(progressBar, params.controlBar.firstChild);
		} else {
			video.container.appendChild(progressBar);
		}
	}

	return {
		add: add
	};
});
