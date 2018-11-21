function wikiaJWPlayerUserIntendedPlayControl(isInitiallyUserIntendedPlay, playerInstance, tracker, willAutoplay) {
	var isUserIntendedPlay = null;
	var isUserIntendedByUnmuting = false;
	var wasPausedByUserInteraction = false;
	var customDimensionNumber = 39;
	var customDimensionValueWhenIntended = 'user-intended';
	var customDimensionValueWhenNotIntended = 'not-user-intended';

	function setUserIntendedPlay(isUserIntended) {
		if (isUserIntendedPlay === isUserIntended) {
			return;
		}

		isUserIntendedPlay = isUserIntended;

		if (typeof tracker.setCustomDimension !== 'function') {
			return;
		}

		tracker.setCustomDimension(
			customDimensionNumber, isUserIntended ?customDimensionValueWhenIntended : customDimensionValueWhenNotIntended
		);
	}

	function onPause(data) {
		if (data.pauseReason === 'interaction') {
			wasPausedByUserInteraction = true;
		}
	}

	function onPlay() {
		if (wasPausedByUserInteraction) {
			setUserIntendedPlay(true);
		}
	}

	function onFullScreen() {
		setUserIntendedPlay(true);
	}

	function onUnmute() {
		setUserIntendedPlay(true);
		isUserIntendedByUnmuting = true;
	}

	function onMute() {
		if (isUserIntendedPlay && isUserIntendedByUnmuting) {
			setUserIntendedPlay(false);
		}
	}

	function onVideoThumbnailInsidePlayerClicked() {
		setUserIntendedPlay(true);
	}

	function init() {
		playerInstance.on('mute', function () {
			if (playerInstance.getMute()) {
				onMute();
			} else {
				onUnmute();
			}
		});

		playerInstance.on('pause', onPause);
		playerInstance.on('play', onPlay);
		playerInstance.on('fullscreen', onFullScreen);

		playerInstance.on('relatedVideoPlay', function (data) {
			if (!data.auto) {
				onVideoThumbnailInsidePlayerClicked();
			}
		});

		if (!willAutoplay) {
			setUserIntendedPlay(true);
		} else if (isInitiallyUserIntendedPlay) {
			setUserIntendedPlay(true);
		} else {
			setUserIntendedPlay(false);
		}
	}

	playerInstance.once('ready', init);
}

window.wikiaJWPlayerUserIntendedPlayControl = wikiaJWPlayerUserIntendedPlayControl;
