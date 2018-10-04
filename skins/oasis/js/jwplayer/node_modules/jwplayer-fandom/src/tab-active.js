function wikiaJWPlayerHandleTabNotActive(playerInstance, willAutoplay) {
	var isPausedByBrowserTabSwitch = false;

	function onBrowserTabFocus(event) {
		if (isPausedByBrowserTabSwitch) {
			isPausedByBrowserTabSwitch = false;
			playerInstance.play();
		}
	}

	function onBrowserTabBlur(event) {
		if (playerInstance.getState() !== 'paused') {
			playerInstance.pause();
			isPausedByBrowserTabSwitch = true;
		}
	}

	window.addEventListener('blur', onBrowserTabBlur);
	window.addEventListener('focus', onBrowserTabFocus);
}
