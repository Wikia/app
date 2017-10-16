define('wikia.articleVideo.featuredVideo.tracking', ['wikia.tracker'], function (tracker) {
	var defaultGACategory = 'featured-video',
		//This will replace 'trackingevent' in internal tracker url path
		eventName = 'videoplayerevent',
		gaCategory,
		playerInstance;

	function updateVideoCustomDimensions(currentVideo) {
		window.guaSetCustomDimension(34, currentVideo.mediaid);
		window.guaSetCustomDimension(35, currentVideo.title);
		window.guaSetCustomDimension(36, currentVideo.tags);
	}

	function track(gaData) {
		if (!gaData.label) {
			throw new Error('No tracking label provided');
		}

		var trackingData = {
			action: gaData.action || 'click',
			category: gaCategory,
			label: gaData.label,
			//value tracks sound state: 1 for muted, 0 for unmuted
			value: Number(playerInstance.getMute()),

			// Internal tracking data
			eventName: eventName,
			videoId: playerInstance.getPlaylistItem().mediaid,
			player: 'jwplayer',
			trackingMethod: 'analytics'
		};

		// Will be replaced by connecting Internal + GA trackers
		tracker.track(trackingData);
	}

	return function (providedPlayerInstance, willAutoplay, providedGACategory) {
		playerInstance = providedPlayerInstance;
		gaCategory = providedGACategory || defaultGACategory;

		window.guaSetCustomDimension(37, willAutoplay ? 'Yes' : 'No');

		playerInstance.once('ready', function () {
			updateVideoCustomDimensions(
				playerInstance.getPlaylistItem()
			);

			track({
				label: 'load',
				action: 'impression'
			});
		});

		playerInstance.on('relatedVideoImpression', function () {
			track({
				label: 'recommended-video',
				action: 'impression'
			});
		});

		playerInstance.on('relatedVideoPlay', function (data) {
			updateVideoCustomDimensions(
				data.item
			);

			var labelPrefix = data.auto ? 'recommended-video-autoplay-' : 'recommended-video-select-';

			track({
				label: labelPrefix + data.position,
				action: 'impression'
			});

			track({
				label: 'recommended-video-depth-' + data.depth,
				action: 'impression'
			});
		});

		playerInstance.on('videoResumed', function () {
			track({
				label: 'play-resumed'
			})
		});

		playerInstance.on('playerStart', function (data) {
			var gaData = data.auto ?
				{ label:'autoplay-start', action: 'impression' } :
				{ label: 'user-start' };

			track(gaData);
		});

		playerInstance.on('pause', function () {
			track({
				label: 'paused'
			});
		});

		playerInstance.on('firstUnmute', function () {
			track({
				label: 'unmuted'
			});
		});

		playerInstance.on('videoSecondsPlayed', function (data) {
			track({
				label: 'played-seconds-' + data.value,
				action: 'view'
			});
		});

		playerInstance.on('videoPercentPlayed', function (data) {
			track({
				label: 'played-percentage-' + data.value,
				action: 'view'
			});
		});

		playerInstance.on('complete', function () {
			track({
				label: 'completed',
				action: 'impression'
			});
		});
	}
});
