function wikiaJWPlayerTracking(playerInstance, willAutoplay, tracker) {
	//This will replace 'trackingevent' in internal tracker url path
	var eventName = 'videoplayerevent',
		gaCategory = tracker.category || 'featured-video';

	function updateVideoCustomDimensions(currentVideo) {
		if (typeof tracker.setCustomDimension !== 'function') {
			return;
		}

		tracker.setCustomDimension(34, currentVideo.mediaid);
		tracker.setCustomDimension(35, currentVideo.title);
		tracker.setCustomDimension(36, currentVideo.tags);
	}

	function addTrackingPixel(id, url) {
		var mountedPixel = document.getElementById(id);

		if (mountedPixel) {
			mountedPixel.parentElement.removeChild(mountedPixel);
		}

		var img = document.createElement('img');
		img.src = url;
		img.id = id;

		document.body.appendChild(img);
	}

	/**
	 * Comscore Video Metrix tracking, sends tracking request with 3 Comscore parameters:
	 * C1 (identifier of content) = 1
	 * C2 (client ID) = 6177433 for Fandom
	 * C5 (video type identifier) = 04 for featured videos
	 * We need to track it at each video playback
	 */
	function trackComscoreVideoMetrix() {
		if (!tracker.comscore) {
			return;
		}

		var pixelID = 'comscoreVideoMetrixTrack',
			url = 'http://b.scorecardresearch.com/p?C1=1&C2=6177433&C5=04';

		addTrackingPixel(pixelID, url);
	}

	/**
	 * adds custom tracking pixel if specified
	 */
	function trackCustomPixel(pixelURL) {
		if (pixelURL) {
			addTrackingPixel('wikiaJWPlayerCustomPixel', pixelURL);
		}
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

	if (typeof tracker.setCustomDimension === 'function') {
		tracker.setCustomDimension(37, willAutoplay ? 'Yes' : 'No');
	}

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

		trackComscoreVideoMetrix();
		trackCustomPixel(data.item.pixel);
	});

	playerInstance.on('videoResumed', function () {
		track({
			label: 'play-resumed'
		})
	});

	playerInstance.on('playerStart', function (data) {
		var gaData = data.auto ?
			{ label: 'autoplay-start', action: 'impression' } :
			{ label: 'user-start' };

		track(gaData);

		trackComscoreVideoMetrix();
		trackCustomPixel(tracker.pixel);
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

	playerInstance.on('onScrollClosed', function () {
		track({
			label: 'collapsed',
			action: 'close'
		});
	});

	playerInstance.on('videoFeedbackImpression', function () {
		track({
			label: 'feedback',
			action: 'impression'
		});
	});

	playerInstance.on('videoFeedbackThumbUp', function () {
		track({
			label: 'feedback-thumb-up',
			action: 'click'
		});
	});

	playerInstance.on('videoFeedbackThumbDown', function () {
		track({
			label: 'feedback-thumb-down',
			action: 'click'
		});
	});

	playerInstance.on('videoFeedbackClosed', function () {
		track({
			label: 'feedback',
			action: 'close'
		});
	});

	playerInstance.on('autoplayToggle', function (data) {
		track({
			label: 'autoplay-' + (data.enabled ? 'enabled' : 'disabled')
		});
	});

	playerInstance.on('captionsSelected', function (data) {
		track({
			label: 'language-selected-' + data.selectedLang.toLowerCase()
		});
	});
}
