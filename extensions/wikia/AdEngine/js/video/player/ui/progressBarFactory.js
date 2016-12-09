/*global define*/
define('ext.wikia.adEngine.video.player.ui.progressBarFactory', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.progressBarFactory';

	function create() {
		var progressBar = doc.createElement('div'),
			currentTime = doc.createElement('div');

		progressBar.classList.add('progress-bar');
		currentTime.classList.add('current-time');

		progressBar.appendChild(currentTime);

		return {
			container: progressBar,
			currentTime: currentTime,
			pause: function () {
				var currentStatus = (this.currentTime.offsetWidth / this.container.offsetWidth * 100) + '%';

				this.currentTime.style.width = currentStatus;
				log(['pause', currentStatus], log.levels.debug, logGroup);
			},
			update: function (video) {
				var remainingTime = video.getRemainingTime();

				if (remainingTime) {
					this.currentTime.style.transitionDuration = remainingTime + 's';
					this.currentTime.style.width = '100%';
				} else {
					this.currentTime.style.width = '0';
				}
				log(['update, remaining time:', remainingTime], log.levels.debug, logGroup);
			}
		};
	}

	return {
		create: create
	};
});
