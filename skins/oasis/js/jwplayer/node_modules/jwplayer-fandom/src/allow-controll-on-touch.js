function wikiaJWPlayerAllowControllOnTouchDevices(playerInstance) {
	playerInstance.on('playerStart', function () {
		var unmuteIcon = document.querySelector('.jw-autostart-mute');

		if (unmuteIcon) {
			playerInstance.getContainer().classList.remove('jw-flag-autostart');
			unmuteIcon.style.display = 'none';
		}
	});
}
