/*global define*/
define('ext.wikia.adEngine.video.player.ui.progressBarFactory', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.progressBarFactory';

	function create(video) {
		var progressBar = doc.createElement('div'),
			currentTime = doc.createElement('div');

		progressBar.classList.add('progress-bar');
		currentTime.classList.add('current-time');

		progressBar.appendChild(currentTime);

		return {
			container: progressBar,
			currentTime: currentTime,
			pause: function () {
				var currentStatus = (currentTime.offsetWidth / progressBar.offsetWidth * 100) + '%';

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
	}

	return {
		create: create
	};
});
