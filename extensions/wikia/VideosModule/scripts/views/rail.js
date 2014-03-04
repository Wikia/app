define('videosmodule.views.rail', [
	'videosmodule.views.titleThumbnail',
	'videosmodule.models.abTestRail',
	'wikia.tracker',
	'wikia.log'
], function (TitleThumbnailView, abTest, Tracker, log) {
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
		this.$thumbs = this.$el.find('.thumbnails');
		this.model = options.model;
		this.articleId = window.wgArticleId;

		// Make sure we're on an article page
		if (this.articleId) {
			this.init();
		}
	}

	VideoModule.prototype.init = function () {
		var self = this;

		// Check for thumb count b/c this may be the control group in which case don't render
		if (!groupParams.thumbs) {
			return;
		}

		self.$thumbs.hide();
		self.$el
			.startThrobbing()
			.show();

		this.model
			.fetch(groupParams.verticalOnly)
			.complete(function () {
				self.render();
			});
	};

	VideoModule.prototype.render = function () {
		var i,
			videos = this.model.data.videos,
			len = videos.length,
			thumbHtml = [],
			self = this,
			$imagesLoaded = $.Deferred();

		// If no videos are returned from the server, don't render anything
		if (!len) {
			this.$el.hide();
			log(
				'No videos were returned for VideosModule rail, ' + testCase.testGroup,
				log.levels.error,
				'VideosModule'
			);
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

		this.$thumbs
			.append(thumbHtml);

		self.$thumbs.find('img').on('load', function () {
			$imagesLoaded.resolve();
		});

		$.when($imagesLoaded)
			.done(function () {
				self.$thumbs.fadeIn();
				self.$el.stopThrobbing();
			});

		track();
	};

	return VideoModule;
});
