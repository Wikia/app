function wikiaJWPlayerEvents(playerInstance, willAutoplay, logger) {
	var state = getNewState(),
		wasAlreadyUnmuted = false,
		depth = 0,
		prefixes = {
			ad: 'ad',
			video: 'video'
		},
		isPlayerPaused = false;

	/**
	 * returns default state for video/ad
	 * @return {{wasFirstQuartileTriggered: boolean, wasMidPointTriggered: boolean, wasThirdQuartileTriggered: boolean, progress: {durationWatched: number, percentWatched: number}}}
	 */
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

	/**
	 * retruns new state for ad and video
	 * @return {{ad: {wasFirstQuartileTriggered: boolean, wasMidPointTriggered: boolean, wasThirdQuartileTriggered: boolean, progress: {durationWatched: number, percentWatched: number}}, video: {wasFirstQuartileTriggered: boolean, wasMidPointTriggered: boolean, wasThirdQuartileTriggered: boolean, progress: {durationWatched: number, percentWatched: number}}}}
	 */
	function getNewState() {
		return {
			ad: getDefaultState(),
			video: getDefaultState()
		}
	}

	/**
	 * triggers video/ad time-based events
	 * @param prefix
	 * @param data
	 */
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

	logger.info('before ready');
	playerInstance.once('ready', function () {
		logger.info('player ready');
		var relatedPlugin = playerInstance.getPlugin('related');

		relatedPlugin.on('open', function () {
			logger.info('related plugin open');
			playerInstance.trigger('relatedVideoImpression');
			state[prefixes.video] = getDefaultState();
		});

		relatedPlugin.on('play', function (data) {
			logger.info('related plugin play');
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
			logger.info('videoResumed triggered');
		}

		isPlayerPaused = false;
	});

	playerInstance.on('pause', function () {
		isPlayerPaused = true;
	});

	playerInstance.on('firstFrame', function () {
		if (depth === 0) {
			playerInstance.trigger('playerStart', { auto: willAutoplay });
			logger.info('playerStart triggered');
		}

		playerInstance.trigger('videoStart');
		logger.info('videoStart triggered');
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
