define('videosmodule.views.rail', [
	'videosmodule.views.titleThumbnail',
	'wikia.log',
	'wikia.tracker',
	'bucky',
	'wikia.window'
], function (TitleThumbnailView, log, Tracker, bucky, win) {
	'use strict';

	var VideosModule = function (options) {
		// $el is the {jQuery Object} container for the videos module
		this.$el = options.$el;

		// model is the data model for the Videos Module
		this.model = options.model;

		// $thumbs is the {jQuery Object} container for the video thumbnails
		this.$thumbs = this.$el.find('.thumbnails');

		// isFluid parameter is passed to the titleThumbnail and if set to true,
		// binds applyEllipses on window resize and scroll to the thumbnails title links
		this.isFluid = options.isFluid;

		// numVids is the maximum number of videos we'd like to display if possible, while
		// minNumVids is the minimum, if there's less, then the Videos Module is not displayed
		this.numVids = options.numVids || 5;
		this.minNumVids = options.minNumVids || 5;

		// Tracking options
		this.bucky = bucky(options.buckyCategory);
		this.trackingCategory = options.trackingCategory;
		this.trackImpression = Tracker.buildTrackingFunction({
			category: options.trackingCategory,
			trackingMethod: 'both',
			action: Tracker.ACTIONS.IMPRESSION,
			label: 'module-impression'
		});

		this.init();
	};

	VideosModule.prototype.init = function () {
		var self = this;

		this.$thumbs.addClass('hidden');
		this.$el
			.startThrobbing()
			.removeClass('hidden');

		this.model
			.fetch()
			.complete(function () {
				self.videos = self.model.data.videos;
				self.staffPickVideos = self.model.data.staffVideos;
				self.render();
			});
	};

	VideosModule.prototype.render = function () {
		var self = this,
			$imagesLoaded = $.Deferred(),
			imgCount = 0;

		this.bucky.timer.start('render');

		if (!this.hasEnoughVideos()) {
			this.bucky.timer.stop('render');
			return;
		}

		this.addBackfill();
		this.shuffle(this.videos);
		this.addStaffPick();

		this.$thumbs
			.append(this.getThumbHtml())
			.find('img[data-video-key]').on('load error', function () {
				imgCount += 1;
				if (imgCount === self.numVids) {
					$imagesLoaded.resolve();
				}
			});

		$.when($imagesLoaded)
			.done(function () {
				self.$thumbs.removeClass('hidden');
				self.$el.stopThrobbing()
					.trigger('initialized.videosModule');
				self.bucky.timer.stop('render');
			});

		// Remove tracking for Special Wikis Sampled at 100% -- VID-1800
		if (win.wgIsGASpecialWiki !== true) {
			this.trackImpression();
		}
	};

	/**
	 * Check if we have enough videos to show the module
	 * @returns {boolean}
	 */
	VideosModule.prototype.hasEnoughVideos = function () {
		if (this.videos.length + this.staffPickVideos.length < this.minNumVids) {
			this.$el.addClass('hidden');
			log(
				'Not enough videos were returned for VideosModule.',
				log.levels.error,
				'VideosModule',
				true
			);
			return false;
		}
		return true;
	};

	/**
	 * If there are less related videos than our default amount, this.NumVids, pull additional
	 * videos from the staffPicks videos
	 */
	VideosModule.prototype.addBackfill = function () {
		var vidsNeeded;

		if (this.videos.length < this.numVids) {
			vidsNeeded = this.numVids - this.videos.length;
			this.videos = this.videos.concat(this.staffPickVideos.splice(0, vidsNeeded));
			this.numVids = this.videos.length;
		}
	};

	/**
	 * Randomize array element order in-place.
	 * Using Fisher-Yates shuffle algorithm.
	 * Slightly adapted from http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	 */
	VideosModule.prototype.shuffle = function (array) {
		var i, j, temp;

		for (i = array.length - 1; i > 0; i--) {
			j = Math.floor(Math.random() * (i + 1));
			temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	};

	/**
	 * If we have any staff pick videos, pick one randomly from that list and display it
	 * in a random position in the Videos Module.
	 */
	VideosModule.prototype.addStaffPick = function () {
		var VideosIndex,
			StaffPicksIndex;

		if (this.staffPickVideos.length) {
			VideosIndex = Math.floor(Math.random() * this.numVids);
			StaffPicksIndex = Math.floor(Math.random() * this.staffPickVideos.length);
			this.videos[VideosIndex] = this.staffPickVideos[StaffPicksIndex];
		}
	};

	/**
	 * Render TitleThumbnail views and return generated HTML
	 * @returns {Array}
	 */
	VideosModule.prototype.getThumbHtml = function () {
		var i,
			thumbHtml = [];

		for (i = 0; i < this.numVids; i++) {
			thumbHtml.push(new TitleThumbnailView({
				el: 'li',
				model: this.videos[i],
				isFluid: this.isFluid,
				idx: i,
				trackingCategory: this.trackingCategory
			})
				.render()
				.$el);
		}

		return thumbHtml;
	};

	return VideosModule;
});
