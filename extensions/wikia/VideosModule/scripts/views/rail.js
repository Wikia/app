define('videosmodule.views.rail', [
	'videosmodule.views.titleThumbnail',
	'videosmodule.models.abTestRail',
	'wikia.tracker'
], function (TitleThumbnailView, abTest, Tracker) {
	'use strict';

	// Keep AB test variables private
	var testCase,
		groupParams,
		track;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-rail',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'module-impression'
	});

	testCase = abTest();
	groupParams = testCase.getGroupParams();

	function VideoModule(options) {
		// this.el is the container for the right rail videos module
		this.el = options.el;
		this.$el = $(options.el);
		this.model = options.model;
		this.articleId = window.wgArticleId;

		// Make sure we're on an article page
		if (this.articleId) {
			this.init();
		}
	}

	VideoModule.prototype.init = function () {
		var self = this;
		this.model
			.fetch(groupParams.verticalOnly)
			.complete(function () {
				self.render();
				self.$el.show();
			});
	};

	VideoModule.prototype.render = function () {
		var i,
			videos = this.model.data.videos,
			len = videos.length,
			thumbHtml = [];

		// If no videos are returned from the server, don't render anything
		// Or if there is not a specified value for thumbs
		if (!len || !groupParams.thumbs) {
			return;
		}

		for (i = 0; i < groupParams.thumbs; i++) {
			thumbHtml.push(new TitleThumbnailView({
					el: 'li',
					model: videos[i],
					idx: i
				})
				.render()
				.$el);
		}

		this.$el.find('.thumbnails')
			.append(thumbHtml);
		// Tracking not implemented this ticket
		track();
	};

	return VideoModule;
});
