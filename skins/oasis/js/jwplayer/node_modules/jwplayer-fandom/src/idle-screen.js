function wikiaJWPlayerIdleScreen(playerInstance, i18n) {
	function showDuration() {
		var id = playerInstance.id,
			playerElement = document.getElementById(id),
			title = playerElement.querySelector('.jw-title'),
			titlePrimary = playerElement.querySelector('.jw-title-primary'),
			durationElement = document.createElement('div'),
			durationWatchElement = document.createElement('span'),
			durationTimeElement = document.createElement('span');

		durationElement.className = 'wikia-jw-title-duration';
		durationWatchElement.className = 'wikia-jw-title-duration-watch';
		durationTimeElement.className = 'wikia-jw-title-duration-time';
		durationWatchElement.innerText = i18n.watch;
		durationTimeElement.innerText = getUserFriendlyDuration(playerInstance.getDuration());

		durationElement.appendChild(durationWatchElement);
		durationElement.appendChild(durationTimeElement);

		title.insertBefore(durationElement, titlePrimary);
	}

	function getUserFriendlyDuration(duration) {
		var minutes = Math.floor(duration / 60),
			seconds = duration % 60;

		if (seconds < 10) {
			seconds  = '0' + seconds;
		}

		if (minutes < 10) {
			minutes  = '0' + minutes;
		}

		return minutes + ':' + seconds;
	}

	playerInstance.on('ready', showDuration);
}

window.wikiaJWPlayerIdleScreen = wikiaJWPlayerIdleScreen;
