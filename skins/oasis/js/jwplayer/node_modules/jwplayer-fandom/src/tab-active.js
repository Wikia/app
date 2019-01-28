function wikiaJWPlayerHandleTabNotActive(playerInstance, willAutoplay) {
	var pausedOnRelated = false;

	function shouldPlayVideo() {
		if (document.hidden) {
			return false;
		}

		if (['playing', 'paused', 'complete'].indexOf(playerInstance.getState()) === -1) {
			return willAutoplay;
		}

		return pausedOnRelated;
	}

	function playVideoOnTabSwitch() {
		if (shouldPlayVideo()) {
			playerInstance.play();
			pausedOnRelated = false;
			playerInstance.trigger('playerResumedByBrowserTabSwitch');
		}
	}

	playerInstance.once('ready', function () {
		document.addEventListener('visibilitychange', playVideoOnTabSwitch, false);
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
