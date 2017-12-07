function wikiaJWPlayerRelatedVideoSound(playerInstance) {
	// Unmutes the sound if related video was played by the user interaction, not autoplayed
	playerInstance.on('relatedVideoPlay', function (data) {
		if (!data.auto) {
			playerInstance.setMute(false);
		}
	});
}
