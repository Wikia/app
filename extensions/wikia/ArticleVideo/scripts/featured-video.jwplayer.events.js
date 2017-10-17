define('wikia.articleVideo.featuredVideo.events', function () {
	var state = getNewState(),
		wasAlreadyUnmuted = false,
		depth = 0,
		wasStartEventFired = false,
		prefixes = {
			ad: 'ad',
			video: 'video'
		},
		playerInstance;

	function getDefaultState() {
		return {
			wasFirstQuartileTriggered: false,
			wasMidPointTriggered: false,
			wasThirdQuartileTriggered: false,
			progress: {
				durationWatched: 0,
				percentWatched: 0
			}
		}
	}

	function getNewState() {
		return {
			ad: getDefaultState(),
			video: getDefaultState()
		}
	}

	function handleTime(prefix, data) {
		var positionFloor = Math.floor(data.position),
			percentPlayed = Math.floor(positionFloor * 100 / data.duration);

		if (positionFloor > state[prefix].progress.durationWatched && positionFloor % 5 === 0) {
			playerInstance.trigger(prefix + 'SecondsPlayed', { value: positionFloor });

			state[prefix].progress.durationWatched = positionFloor;
		}

		if (percentPlayed >= 25 && !state[prefix].wasFirstQuartileTriggered) {
			playerInstance.trigger(prefix + 'FirstQuartile');
			state[prefix].wasFirstQuartileTriggered = true;
		}

		if (percentPlayed >= 50 && !state[prefix].wasMidPointTriggered) {
			playerInstance.trigger(prefix + 'MidPoint');
			state[prefix].wasMidPointTriggered = true;
		}

		if (percentPlayed >= 75 && !state[prefix].wasThirdQuartileTriggered) {
			playerInstance.trigger(prefix + 'ThirdQuartile');
			state[prefix].wasThirdQuartileTriggered = true;
		}

		if (percentPlayed > state[prefix].progress.percentWatched && percentPlayed % 10 === 0) {
			playerInstance.trigger(prefix + 'PercentPlayed', { value: percentPlayed });

			state[prefix].progress.percentWatched = percentPlayed;
		}
	}

	return function (providedPlayerInstance, willAutoplay) {
		playerInstance = providedPlayerInstance;

		console.log('playerInstance create ready!!');
		playerInstance.once('ready', function () {
			console.log('playerInstance ready!!');
			var relatedPlugin = playerInstance.getPlugin('related');
			console.log('relatedPlugin', relatedPlugin);

			relatedPlugin.on('open', function () {
				playerInstance.trigger('relatedVideosImpression');
				state[prefixes.video] = getDefaultState();
			});

			relatedPlugin.on('play', function (data) {
				depth++;

				playerInstance.trigger('relatedVideoPlay', {
					auto: data.auto,
					item: data.item,
					position: data.position,
					depth: depth
				});
			});
		});

		playerInstance.on('play', function () {
			if (wasStartEventFired) {
				playerInstance.trigger('videoResumed');
			} else {
				if (depth === 0) {
					playerInstance.trigger('playerStart', { auto: willAutoplay });
				}

				playerInstance.trigger('videoStart');
				wasStartEventFired = true;
			}
		});

		playerInstance.on('mute', function () {
			if (!playerInstance.getMute() && !wasAlreadyUnmuted) {
				playerInstance.trigger('firstUnmute');
				wasAlreadyUnmuted = true;
			}
		});

		playerInstance.on('time', function (data) {
			handleTime(prefixes.video, data);
		});

		playerInstance.on('adTime', function (data) {
			handleTime(prefixes.ad, data);
		});

		playerInstance.on('adRequest', function () {
			state[prefixes.ad] = getDefaultState();
		});
	}
});
