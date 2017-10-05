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

	return function (featuredVideoPlayer) {
		featuredVideoPlayer.on('play', function () {
			track({
				label: 'featured-video-play'
			});
		});

		featuredVideoPlayer.on('pause', function () {
			track({
				label: 'featured-video-paused'
			});
		});

		featuredVideoPlayer.on('mute', function (isMuted) {
			if (!isMuted && state.wasAlreadyUnmuted) {
				track({
					label: 'featured-video-unmuted'
				});
			}
		});

		featuredVideoPlayer.on('playlist', function () {
			track({
				action: 'impression',
				label: 'recommended-video'
			});
		});

		featuredVideoPlayer.on('playlistItem', function (newIndex) {
			track({
				action: 'impression',
				label: 'recommended-video-' + newIndex
			});
		});

		featuredVideoPlayer.on('firstFrame', function () {
			debugger
			track({
				action: 'impression',
				label: 'recommended-video-'
			});
		});
	}
});
