define('wikia.articleVideo.videoFeedbackBox', ['wikia.window', 'wikia.tracker'], function (window, tracker) {

	var feedbackVisibleClass = 'visible',
		track = tracker.buildTrackingFunction({
			category: 'article-video',
			trackingMethod: 'analytics'
		});

	function VideoFeedbackBox(selector) {
		this.feedback = $(selector);

		var closeFeedback = this.feedback.find('.video-feedback-close'),
			thumbUp = this.feedback.find('.video-thumb-up'),
			thumbDown = this.feedback.find('.video-thumb-down'),
			self = this;

		this.isActive = false;

		closeFeedback.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-closed'
			});
			self.hide();
			self.isActive = false;
		});

		thumbUp.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-thumb-up'
			});
			self.hide();
			self.isActive = false;
		});

		thumbDown.click(function () {
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'featured-video-feedback-thumb-down'
			});
			self.hide();
			self.isActive = false;
		});
	}

	VideoFeedbackBox.prototype.hide = function () {
		if (this.isActive) {
			this.feedback.removeClass(feedbackVisibleClass);
		}
	};

	VideoFeedbackBox.prototype.show = function () {
		if (this.isActive) {
			this.feedback.addClass(feedbackVisibleClass);
		}
	};

	VideoFeedbackBox.prototype.init = function () {
		this.isActive = true;
		this.show();
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'featured-video-feedback'
		});
	};

	return VideoFeedbackBox;
});
