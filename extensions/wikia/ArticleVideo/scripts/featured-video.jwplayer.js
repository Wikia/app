require([
	'mw',
	'wikia.window',
	'wikia.articleVideo.featuredVideo.jwplayer.onScroll',
	'wikia.articleVideo.featuredVideo.jwplayer.videoFeedback',
	'wikia.articleVideo.featuredVideo.jwplayer.annotations',
	'jquery',
	require.optional('wikia.articleVideo.featuredVideo.jwplayer.instance')
], function (mw,
             win,
             jwPlayerOnScroll,
             jwPlayerVideoFeedback,
             featuredVideoAnnotations,
             $,
             playerInstance) {
	var $featuredVideo = $('.featured-video'),
		$featuredVideoWrapper = $('.featured-video__wrapper'),
		$playerContainer = $('.featured-video__player-container'),
		lastUpdatedFor = 0;

	function setupCommentedBy(playerInstance, annotations) {
		if (!annotations || !annotations.comments || !annotations.comments.length) {
			return;
		}

		var comments = annotations.comments;

		playerInstance.on('time', function (data) {
			var roundedPosition = Math.floor(data.position);

			if (roundedPosition > lastUpdatedFor + 30 && roundedPosition > lastUpdatedFor) {
				updateCommentedBy(comments, data.position);
				lastUpdatedFor = roundedPosition;
			}
		});

		updateCommentedBy(comments, 0);
	}

	function updateCommentedBy(comments, startTime) {
		var commentedBy = getCommentedByFor30seconds(comments, startTime);

		if (commentedBy.length) {
			$('.featured-video__commented-by')
				.html('')
				.append(
					$('<div>').html('Video comments from:'),
					$('<ul>').html(commentedBy)
				);
		} else {
			$('.featured-video__commented-by').html('<div>No video comments yet</div>');
		}
	}

	function getCommentedByFor30seconds(comments, startTime) {
		return comments.filter(function (comment) {
			return comment.displayAt > startTime && comment.displayAt < startTime + 30;
		}).map(function (comment) {
			return '<li class="commented-by-avatar"><img src="'+ comment.createdBy.avatar + '"></li>';
		});
	}

	function run() {
		var unbindOnScrollEvents = jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
		jwPlayerVideoFeedback(playerInstance);

		// remove player if VisualEditor is loaded
		mw.hook('ve.activationComplete').add(function () {
			if (playerInstance) {
				$featuredVideoWrapper.addClass('is-removed');
				playerInstance.remove();
				playerInstance = null;
				unbindOnScrollEvents();
			}
		});

		featuredVideoAnnotations.getAnnotations(1).then(function(annotations) {
			setupCommentedBy(playerInstance, annotations);
		});
	}

	// `wikia.articleVideo.featuredVideo.jwplayer.instance` module is defined asynchronously
	// so when it's not yet available we listen for custom event to get player instance object
	if (playerInstance) {
		run();
	} else {
		win.addEventListener('wikia.jwplayer.instanceReady', function (event) {
			playerInstance = event.detail;
			win.removeEventListener('wikia.jwplayer.instanceReady', arguments.callee);
			run();
		});
	}
});
