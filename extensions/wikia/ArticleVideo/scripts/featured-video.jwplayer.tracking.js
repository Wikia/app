define('wikia.articleVideo.featuredVideo.tracking', [], function () {
	var state = getDefaultState();
	var gaCategory = 'featured-video';
	var playerInstance;
	var wasAlreadyUnmuted = false;
	var depth = 0;

	function getDefaultState() {
		return {
			wasStartTracked: false,
			progress: {
				durationTracked: 0,
				percentTracked: 0
			}
		}
	}

	function track(gaData) {
		if (!gaData.label) {
			throw new Error('No tracking label provided');
		}

		var finalGAData = {
			action: gaData.action || 'click',
			category: gaCategory,
			label: gaData.label,
			//value tracks sound state: 1 for muted, 0 for unmuted
			value: Number(playerInstance.getMute())
		};

		// Will be replaced by connecting Internal + GA trackers
		console.info(gaData);
	}

	return function (providedPlayerInstance, willAutoplay, gaCategory) {
		playerInstance = providedPlayerInstance;
		gaCategory = gaCategory;

		playerInstance.once('ready', function () {
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

				var labelPrefix = data.auto ? 'recommended-video-autoplay-' : 'recommended-video-select-';

				track({
					label: labelPrefix + data.position,
					action: 'impression'
				});

				track({
					label: 'recommended-video-depth' + depth,
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
			var label = 'play-resumed';
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
			if (!playerInstance.isMuted() && !wasAlreadyUnmuted) {
				track({
					label: 'unmuted'
				});

				wasAlreadyUnmuted = true;
			}
		});

		playerInstance.on('time', function (data) {
			var positionFloor = Math.floor(data.position);
			var durationFloor = Math.floor(data.duration);
			var percentPlayed = Math.floor(positionFloor * 100 / durationFloor);

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
