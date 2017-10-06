define('wikia.articleVideo.featuredVideo.tracking', [], function () {
	function getDefaultState() {
		return {
			wasAlreadyUnmuted: false
		}
	}

	function track(gaData) {
		console.log(gaData);
	}

	var state = getDefaultState();

	return function (playerInstance) {
		playerInstance.on('play', function () {
			track({
				label: 'featured-video-play'
			});
		});

		playerInstance.on('pause', function () {
			track({
				label: 'featured-video-paused'
			});
		});

		playerInstance.on('mute', function (isMuted) {
			if (!isMuted && state.wasAlreadyUnmuted) {
				track({
					label: 'featured-video-unmuted'
				});
			}
		});
	}
});
