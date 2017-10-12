define('wikia.articleVideo.featuredVideo.tracking', ['wikia.tracker'], function (tracker) {
	var state = getDefaultState(),
		defaultGACategory = 'featured-video',
		//This will replace 'trackingevent' in internal tracker url path
		eventName: 'videoplayerevent',
		wasAlreadyUnmuted = false,
		depth = 0,

		gaCategory,
		playerInstance;

	function getDefaultState() {
		return {
			wasStartTracked: false,
			progress: {
				durationTracked: 0,
				percentTracked: 0
			}
		}
	}

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

			var relatedPlugin = playerInstance.getPlugin('related');

			relatedPlugin.on('open', function () {
				track({
					label: 'recommended-video',
					action: 'impression'
				});

				state = getDefaultState();
			});

			relatedPlugin.on('play', function (data) {
				depth++;

				updateVideoCustomDimensions(
					data.item
				);

				var labelPrefix = data.auto ? 'recommended-video-autoplay-' : 'recommended-video-select-';

				track({
					label: labelPrefix + data.position,
					action: 'impression'
				});

				track({
					label: 'recommended-video-depth-' + depth,
					action: 'impression'
				});
			});
		});

		playerInstance.once('firstFrame', function () {
			if (!willAutoplay || state.wasStartTracked || depth > 0) {
				return;
			}

			track({
				label: 'autoplay-start',
				action: 'impression'
			});
		});

		playerInstance.on('play', function () {
			var gaData;

			if (state.wasStartTracked) {
				gaData = {
					label: 'play-resumed'
				}
			} else {
				if (depth === 0) {
					gaData = willAutoplay ?
						{ label:'autoplay-start', action: 'impression' } :
						{ label: 'user-start' };
				}

				state.wasStartTracked = true;
			}

			gaData && track(gaData);
		});

		playerInstance.on('pause', function () {
			track({
				label: 'paused'
			});
		});

		playerInstance.on('mute', function () {
			if (!playerInstance.getMute() && !wasAlreadyUnmuted) {
				track({
					label: 'unmuted'
				});

				wasAlreadyUnmuted = true;
			}
		});

		playerInstance.on('time', function (data) {
			var positionFloor = Math.floor(data.position),
				percentPlayed = Math.floor(positionFloor * 100 / data.duration);

			if (positionFloor > state.progress.durationTracked && positionFloor % 5 === 0) {
				track({
					label: 'played-seconds-' + positionFloor,
					action: 'view'
				});

				state.progress.durationTracked = positionFloor;
			}

			if (percentPlayed > state.progress.percentTracked && percentPlayed % 10 === 0) {
				track({
					label: 'played-percentage-' + percentPlayed,
					action: 'view'
				});

				state.progress.percentTracked = percentPlayed;
			}
		});

		playerInstance.on('complete', function () {
			track({
				label: 'completed',
				action: 'impression'
			});
		});
	}
});
