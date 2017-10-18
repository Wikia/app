define('wikia.articleVideo.videoFeedbackBox', ['wikia.window', 'wikia.tracker'], function (window, tracker) {

	var feedbackVisibleClass = 'visible',
		track = tracker.buildTrackingFunction({
			category: 'article-video',
			trackingMethod: 'analytics'
		});

	function VideoFeedbackBox(selector, jwplayerInstance) {
		this.feedback = $(selector);
		this.jwplayerInstance = jwplayerInstance;

		var closeFeedback = this.feedback.find('.video-feedback-close'),
			thumbUp = this.feedback.find('.video-thumb-up'),
			thumbDown = this.feedback.find('.video-thumb-down'),
			self = this;

		this.isActive = false;

		closeFeedback.click(function () {
			if (self.jwplayerInstance) {
				self.jwplayerInstance.trigger('videoFeedbackClosed');
			} else {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-feedback-closed'
				});
			}
			self.hide();
			self.isActive = false;
		});

		thumbUp.click(function () {
			if (self.jwplayerInstance) {
				self.jwplayerInstance.trigger('videoFeedbackThumbUp');
			} else {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-feedback-thumb-up'
				});
			}
			self.hide();
			self.isActive = false;
		});

		thumbDown.click(function () {
			if (self.jwplayerInstance) {
				self.jwplayerInstance.trigger('videoFeedbackThumbDown');
			} else {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-feedback-thumb-down'
				});
			}
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
		if (this.jwplayerInstance) {
			this.jwplayerInstance.trigger('videoFeedbackImpression');
		} else {
			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'featured-video-feedback'
			});
		}
	};

	return VideoFeedbackBox;
});
