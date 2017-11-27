function wikiaJWPlayerHandleTabNotActive(playerInstance, willAutoplay) {
	function canPlayVideo(willAutoplay) {
		return !document.hidden && willAutoplay && (['playing', 'paused', 'complete'].indexOf(playerInstance.getState()) === -1 || pausedOnRelated);
	}

	var pausedOnRelated = false;

	document.addEventListener('visibilitychange', function () {
		if (canPlayVideo(willAutoplay)) {
			playerInstance.play(true);
			pausedOnRelated = false;
		}
	}, false);

	playerInstance.on('relatedVideoPlay', function () {
		if (document.hidden) {
			playerInstance.pause();
			pausedOnRelated = true;
		}
	});
}
