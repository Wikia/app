export default function wikiaJWPlayerAllowControllOnTouchDevices(playerInstance) {
	playerInstance.on('playerStart', function () {
		const unmuteIcon = document.querySelector('.jw-autostart-mute');

		if (unmuteIcon) {
			playerInstance.getContainer().classList.remove('jw-flag-autostart');
			unmuteIcon.style.display = 'none';
		}
	});
}
