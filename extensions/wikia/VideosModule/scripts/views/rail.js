define('videosmodule.views.rail', [
	'sloth',
	'videosmodule.views.titleThumbnail',
	'videosmodule.models.abTestRail',
	'wikia.tracker'
], function (sloth, TitleThumbnailView, abTest, Tracker) {
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
		if (this.articleId && testCase.testGroup === 'VIDEOS_MODULE_RAIL') {
			this.init();
		}
	}

	VideoModule.prototype.init = function () {
		var self = this;
		this.data = this.model.fetch(true);
		this.$el.show();
		// Sloth is a lazy loading service that waits till an element is visisble to load more content
		sloth({
			on: this.el,
			threshold: 200,
			callback: function () {
				self.bindFetchComplete();
			}
		});
	};

	VideoModule.prototype.bindFetchComplete = function () {
		var self = this;
		this.data.complete(function () {
			self.render();
		});
	};

	VideoModule.prototype.render = function () {
		var i,
			videos = this.model.data.videos,
			len = videos.length,
			thumbHtml = [];

		// If no videos are returned from the server, don't render anything
		if (!len) {
			return;
		}

		// AB test set rows shown
		videos = videos.slice(0, groupParams.thumbs);

		for (i = 0; i < videos.length; i++) {
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
