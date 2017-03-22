define('wikia.articleVideo.showVideoFeedbackBox', ['wikia.window', 'wikia.tracker'], function (window, tracker) {

	function showVideoFeedbackBox () {
		var feedback = $('#article-video .video-feedback'),
			closeFeedback = feedback.find('.video-feedback-close'),
			thumbUp = feedback.find('.video-thumb-up'),
			thumbDown = feedback.find('.video-thumb-down'),
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			}),
			feedbackVisibleClass = 'visible';

		closeFeedback.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-closed'
			});
			feedback.removeClass(feedbackVisibleClass);
		});

		thumbUp.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-thumb-up'
			});
			feedback.removeClass(feedbackVisibleClass);
		});

		thumbDown.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-thumb-down'
			});
			feedback.removeClass(feedbackVisibleClass);
		});

		feedback.addClass(feedbackVisibleClass);

		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'featured-video-feedback'
		});
	}

	return showVideoFeedbackBox;
});