define('wikia.articleVideo.featuredVideo.events', function () {
	var state = getNewState(),
		wasAlreadyUnmuted = false,
		depth = 0,
		prefixes = {
			ad: 'ad',
			video: 'video'
		},
		isPlayerPaused = false,
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

		console.info('jwplayer before ready');
		playerInstance.once('ready', function () {
			console.info('jwplayer player ready');
			var relatedPlugin = playerInstance.getPlugin('related');

			relatedPlugin.on('open', function () {
				console.info('jwplayer related plugin open');
				playerInstance.trigger('relatedVideoImpression');
				state[prefixes.video] = getDefaultState();
			});

			relatedPlugin.on('play', function (data) {
				console.info('jwplayer related plugin play');
				depth++;

				playerInstance.trigger('relatedVideoPlay', {
					auto: data.auto,
					item: data.item,
					position: data.position,
					depth: depth
				});
			});
		});

		playerInstance.on('play', function (data) {
			if (isPlayerPaused) {
				playerInstance.trigger('videoResumed');
				console.info('jwplayer videoResumed tiggered');
			}

			isPlayerPaused = false;
		});

		playerInstance.on('pause', function () {
			isPlayerPaused = true;
		});

		playerInstance.on('firstFrame', function () {
			if (depth === 0) {
				playerInstance.trigger('playerStart', { auto: willAutoplay });
				console.info('jwplayer playerStart tiggered');
			}

			playerInstance.trigger('videoStart');
			console.info('jwplayer videoStart tiggered');
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
