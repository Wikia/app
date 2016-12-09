/*global define*/
define('ext.wikia.adEngine.video.player.ui.progressBar', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.progressBar';

	function add(video) {
		var container = doc.createElement('div'),
			currentTime = doc.createElement('div'),
			progressBar;

		container.classList.add('progress-bar');
		currentTime.classList.add('current-time');

		container.appendChild(currentTime);

		progressBar = {
			pause: function () {
				var currentStatus = (currentTime.offsetWidth / container.offsetWidth * 100) + '%';

				currentTime.style.width = currentStatus;
				log(['pause', currentStatus], log.levels.debug, logGroup);
			},
			reset: function () {
				currentTime.style.transitionDuration = '';
				currentTime.style.width = '0';
			},
			start: function () {
				var remainingTime = video.getRemainingTime();

				if (remainingTime) {
					currentTime.style.transitionDuration = remainingTime + 's';
					currentTime.style.width = '100%';
				} else {
					currentTime.style.width = '0';
				}
				log(['update, remaining time:', remainingTime], log.levels.debug, logGroup);
			}
		};

		video.addEventListener('start', progressBar.start);
		video.addEventListener('resume', progressBar.start);
		video.addEventListener('allAdsCompleted', progressBar.reset);
		video.addEventListener('pause', progressBar.pause);

		video.container.appendChild(container);

		return progressBar;
	}

	return {
		add: add
	};
});
