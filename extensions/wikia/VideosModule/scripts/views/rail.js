define('videosmodule.views.rail', [
	'videosmodule.views.titleThumbnail',
	'wikia.tracker',
	'wikia.log'
], function (TitleThumbnailView, Tracker, log) {
	'use strict';

	var track,
		numVids = 5;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-rail',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION,
		label: 'module-impression'
	});

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

		self.$thumbs.addClass('hidden');
		self.$el
			.startThrobbing()
			.removeClass('hidden');

		this.model
			.fetch()
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
			$imagesLoaded = $.Deferred(),
			imgCount = 0;

		// If no videos are returned from the server, don't render anything
		if (!len) {
			this.$el.addClass('hidden');
			log(
				'No videos were returned for VideosModule rail',
				log.levels.error,
				'VideosModule',
				true
			);
			return;
		}

		for (i = 0; i < numVids; i++) {
			thumbHtml.push(new TitleThumbnailView({
					el: 'li',
					model: videos[i],
					idx: i
				})
				.render()
				.$el);
		}

		this.$thumbs
			.append(thumbHtml)
			.find('img[data-video-key]').on('load error', function () {
				imgCount += 1;
				if (imgCount === numVids) {
					$imagesLoaded.resolve();
				}
			});

		$.when($imagesLoaded)
			.done(function () {
				self.$thumbs.removeClass('hidden');
				self.$el.stopThrobbing();
			});

		track();
	};

	return VideoModule;
});
