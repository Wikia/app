define('videohomepage.views.featured', [
	// lib deps
	'jquery',
	// wikia core deps
	'wikia.nirvana',
	'wikia.videoBootstrap',
	'wikia.tracker',
	// module specific deps
	'videohomepage.collections.featuredslides',
	'BannerNotification'
], function ($, Nirvana, VideoBootstrap, Tracker, FeaturedSlidesCollection, BannerNotification) {
	'use strict';
	var track, FeaturedVideosView;

	track = Tracker.buildTrackingFunction({
		action: Tracker.ACTIONS.CLICK,
		category: 'video-home-page',
		trackingMethod: 'both'
	});

	FeaturedVideosView = Backbone.View.extend({
		events: {
			'click #featured-video-thumbs .video': 'handleThumbClick',
			'mouseenter #featured-video-thumbs': 'clearHoverTimeout',
			'mouseleave #featured-video-thumbs': 'setHoverTimeout',

			'click #featured-video-bxslider .slide-image': 'handleSlideClick',
			'mouseenter.autohover #featured-video-bxslider': 'bxSliderStopAuto',
			'mouseleave.autohover #featured-video-bxslider': 'bxSliderStartAuto',

			'mouseenter .bx-pager .bx-pager-item': 'showThumbs',
			'mouseleave .bx-pager .bx-pager-item': 'setHoverTimeout'
		},

		initialize: function (opts) {
			_.bindAll(this, 'reloadVideo');

			this.$bxSlider = opts.$bxSlider;
			this.$thumbs = opts.$thumbs;

			this.isVideoSlider = false;

			// Track the video that's playing at any given time
			this.videoInstance = null;
			this.videoPlays = 0;

			// values will be assigned after slider inits
			this.$sliderControls = null;
			this.slider = null;
			this.videoPadding = null;

			// Run through the DOM we've already loaded and build all the collections/data models
			this.queryDom();

			this.collection = new FeaturedSlidesCollection(this.slideModels);

			this.timeout = 0;
			this.initSlider();

			$(window).on('resize', _.bind(this.collection.resetEmbedData, this.collection))
				.on('lightboxOpened', this.reloadVideo);
		},

		render: function () {
			this.$thumbs.find('.title').ellipses({
				maxLines: 2
			});
		},

		queryDom: function () {
			var self = this;

			// arrays containing cached DOM lookups
			this.slides = [];
			this.thumbs = [];
			// array containing raw data for video embeds
			this.slideModels = [];

			_.each(this.$thumbs.find('.video'), function (e) {
				self.thumbs.push({
					$video: $(e)
				});
			});

			_.each(this.$bxSlider.children(), function (e, i) {
				var $elem,
					videoKey;

				$elem = $(e);
				self.slides.push({
					$elem: $elem,
					$video: $elem.find('.slide-video'),
					$videoThumb: self.thumbs[i].$video,
					$image: $elem.find('.slide-image'),
					idx: i
				});

				videoKey = self.thumbs[i]
					.$video.children('img')
					.attr('data-video-key');

				self.slideModels.push({
					videoKey: videoKey,
					embedData: null
				});
			});
		},

		initSlider: function () {
			this.slider = this.$bxSlider.bxSlider({
				onSliderLoad: _.bind(this.onSliderLoad, this),
				onSlideAfter: _.bind(this.onSlideAfter, this),
				nextText: '',
				prevText: '',
				auto: true,
				speed: 400,
				mode: 'fade',
				// not using this b/c it's buggy
				autoHover: false
			});
		},

		onSliderLoad: function () {
			// Show the slider now that it's done loading
			this.$el.removeClass('hidden');

			// Controls are loaded, cache their jQuery DOM object
			this.$sliderControls = this.$el.find('.bx-pager');

			// left/right padding for videos so arrows don't overlap
			this.videoPadding = (this.$el.find('.bx-prev').width() * 2) + 130;
		},

		onSlideAfter: function ($slide, oldIndex, newIndex) {
			if (this.isVideoSlider) {
				this.playVideo(this.slides[newIndex]);
			}
		},

		setHoverTimeout: function () {
			var self = this;
			this.timeout = setTimeout(function () {
				self.$thumbs.slideUp();
			}, 300);
		},

		clearHoverTimeout: function () {
			clearTimeout(this.timeout);
		},

		showThumbs: function () {
			this.clearHoverTimeout();
			this.$thumbs.slideDown();
			this.render();
		},

		handleThumbClick: function (e) {
			var $thumb,
				index;

			e.preventDefault();

			$thumb = $(e.target);
			index = $thumb.closest('li').index();

			if (!$thumb.hasClass('playing')) {
				if (!this.isVideoSlider) {
					this.switchToVideoSlider();
				}

				this.$thumbs.slideUp();

				track({
					label: 'featured-thumbnail'
				});

				if (this.slider.getCurrentSlide() === index) {
					// play the video
					this.playVideo(this.slides[index]);

				} else {
					// Go to the selected slide based on thumbnail that was clicked
					this.slider.goToSlide(index);
				}
			}
		},

		/*
		 * @desc When a slide is clicked, convert to video slider and play the video
		 */
		handleSlideClick: function (e) {
			e.preventDefault();
			var index,
				$slideImage;

			$slideImage = $(e.target).closest('.slide-image');

			if (!this.isVideoSlider) {
				this.switchToVideoSlider();
			}

			// Get the slide's index from the data attr instead of index() b/c slides are cloned in bxSlider
			index = $slideImage.data('index');

			this.playVideo(this.slides[index]);
		},

		bxSliderStopAuto: function () {
			this.$bxSlider.stopAuto();
		},

		bxSliderStartAuto: function () {
			this.$bxSlider.startAuto();
		},

		/*
		 * @desc When an arrow is clicked, if it's already a video slider,
		 * play the next video. Otherwise, do nothing,
		 * just let the slider switch to the next image.
		 */
		playVideo: function (slide) {
			var self = this,
				data = this.getEmbedCode(slide),
				model = this.collection.at(slide.idx);

			// Stop the video that's playing
			if (this.videoInstance) {
				this.videoInstance.destroy();
			}

			this.$thumbs.find('.playing').removeClass('playing');
			slide.$videoThumb.addClass('playing');

			$.when(data).done(function (json) {
				if (json.error) {
					new BannerNotification(json.error, 'error', null, 4000).show();
				} else {
					// cache embed data
					model.set({
						embedData: json
					});

					// Actually do the video embed
					self.videoInstance = new VideoBootstrap(
						slide.$video[0],
						model.get('embedData').embedCode,
						'videoHomePage'
					);

					// Wait till video has loaded and update the slider viewport height.
					setTimeout(function () {
						self.$bxSlider.redrawSlider();
					}, 1000);
				}
			});

			track({
				label: 'featured-video-plays',
				value: (this.videoPlays += 1)
			});
		},

		reloadVideo: function () {
			if (this.videoInstance) {
				this.videoInstance.reload();
			}
		},

		/*
		 * @desc Get video data if we don't have it already or if the window
		 * has resized and we want to get the embed
		 * code at a different size.
		 */
		getEmbedCode: function (slide) {
			var self = this,
				data,
				model;

			model = this.collection.at(slide.idx);

			if (model.get('embedData') === null) {
				// Get video embed data for this slide
				data = Nirvana.sendRequest({
					controller: 'VideoHandler',
					method: 'getEmbedCode',
					type: 'GET',
					data: {
						fileTitle: model.get('videoKey'),
						width: self.getWidthForVideo(slide),
						autoplay: 1
					}
				});
			} else {
				data = model.get('embedData');
			}

			// return a promise or a plain object
			return data;
		},

		/*
		 * @desc Calculate the width at which the video should be loaded.  It can change based on container width
		 */
		getWidthForVideo: function (slide) {
			// get the container width minus videoPadding for left/right arrows
			var width = this.$el.width() - this.videoPadding;

			// center the video in the space by setting the container width. This is just in case the browser window
			// gets bigger;
			slide.$video.width(width);

			return width;
		},

		/*
		 * @desc Update settings because it's not a video slider
		 */
		switchToVideoSlider: function () {
			// It's now a video slider, don't show thumbnails anymore
			this.isVideoSlider = true;

			// don't let the slider start autoHover again
			this.$el.off('.autohover');

			// Stop slider autoscroll because we're watching videos now
			this.$bxSlider.stopAuto();

			// hide all images so they don't show up on slide and show all videos
			// note: looping through slide.$image/$video doesn't work because it doesn't count clones
			this.$bxSlider.find('.slide-image').hide();
		}
	});

	return FeaturedVideosView;
});
