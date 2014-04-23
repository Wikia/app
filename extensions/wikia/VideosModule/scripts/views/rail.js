define('videosmodule.views.rail', [
	'videosmodule.views.titleThumbnail',
	'wikia.tracker',
	'wikia.log'
], function (TitleThumbnailView, Tracker, log) {
	'use strict';

	var track;

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
		this.numVids = 5;

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
			staffPickVideos = this.model.data.staffVideos,
			len = videos.length,
			thumbHtml = [],
			self = this,
			$imagesLoaded = $.Deferred(),
			imgCount = 0,
			VideosIndex,
			StaffPicksIndex;

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

		this.shuffle(videos);
		// If we have any staff pick videos, pick one randomly from that list and display it
		// in a random position in the Videos Module.
		if (staffPickVideos.length) {
			VideosIndex = Math.floor(Math.random() * this.numVids);
			StaffPicksIndex = Math.floor(Math.random() * staffPickVideos.length);
			videos[VideosIndex] = staffPickVideos[StaffPicksIndex];
		}

		for (i = 0; i < this.numVids; i++) {
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
				if (imgCount === self.numVids) {
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

	/**
	 * Randomize array element order in-place.
	 * Using Fisher-Yates shuffle algorithm.
	 * Slightly adapted from http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	 */
	VideoModule.prototype.shuffle = function(array) {
		var i, j, temp;

		for (i = array.length - 1; i > 0; i--) {
			j = Math.floor(Math.random() * (i + 1));
			temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	};

	return VideoModule;
});
