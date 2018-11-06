function wikiaJWPlayerHandleTabNotActive(playerInstance) {
	function canPlayVideo() {
		return !document.hidden && (['playing', 'paused', 'complete'].indexOf(
			playerInstance.getState()) === -1 || pausedOnRelated);
	}

	var pausedOnRelated = false;

	playerInstance.on('playerStart', function () {
		document.addEventListener('visibilitychange', function () {
			if (canPlayVideo()) {
				playerInstance.play();
				pausedOnRelated = false;
				playerInstance.trigger('playerResumedByBrowserTabSwitch');
			}
		}, false);
	});

	playerInstance.on('relatedVideoPlay', function () {
		if (document.hidden) {
			playerInstance.once('play', function () {
				playerInstance.pause();
				pausedOnRelated = true;
				playerInstance.trigger('playerPausedByBrowserTabSwitch');
			});
		}
	});
}
