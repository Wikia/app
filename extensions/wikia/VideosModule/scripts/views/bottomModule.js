define('videosmodule.views.bottomModule', [
	'sloth',
	'videosmodule.views.titleThumbnail',
	'wikia.mustache',
	'videosmodule.templates.mustache',
	'videosmodule.models.abTestBottom',
	'wikia.tracker'
], function (sloth, TitleThumbnailView, Mustache, templates, abTest, Tracker) {
	'use strict';

	// Keep AB test variables private
	var testCase,
		groupParams,
		track;

	track = Tracker.buildTrackingFunction({
		category: 'videos-module-bottom',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.IMPRESSION
	});

	testCase = abTest();
	groupParams = testCase.getGroupParams();

	function VideoModule(options) {
		// Note that this.el refers to the DOM element that the videos module should be inserted before or after,
		// not the wrapper for the videos module. We can update this after the A/B testing is over.
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
		if (!groupParams) {
			// Handle control group, no videos module display
			this.handleRelatedPages(false);
			return;
		}

		this.data = this.model.fetch(groupParams.verticalOnly);
		// Sloth is a lazy loading service that waits till an element is visisble to load more content
		sloth({
			on: this.el,
			threshold: 200,
			callback: function () {
				self.data.complete(function () {
					self.handleRelatedPages(true);
				});
			}
		});
	};

	/**
	 * Handle logic to display videos module or not based on related pages module
	 * Also used for tracking related pages impressions
	 * @param {boolean} render
	 */
	VideoModule.prototype.handleRelatedPages = function (render) {
		var self = this;

		// called if related pages module is present
		function afterPresent() {
			track({
				label: 'related-pages-impression'
			});
			if (render) {
				self.render();
			}
		}

		// check if related pages is loaded and visible
		if (this.elContentPresent()) {
			afterPresent();
		} else {
			// wait till after related pages has loaded to check if visible
			this.$el.on('afterLoad.relatedPages', function () {
				if (self.elContentPresent()) {
					afterPresent();
				}
			});
		}
	};

	/**
	 * Check if the element has content that is not hidden by css
	 * @returns {boolean}
	 */
	VideoModule.prototype.elContentPresent = function () {
		var $content = this.$el.children();
		return !!(
			$content.length &&
			!$content.is(':hidden') &&
			$content.css('visibility') !== 'hidden' &&
			$content.css('opacity') !== '0' &&
			$content.height() !== 0
		);
	};

	VideoModule.prototype.render = function () {
		var i,
			$out,
			videos = this.model.data.videos,
			len = videos.length,
			instance,
			thumbnailViews = [];

		// If no videos are returned from the server, don't render anything
		if (!len) {
			return;
		}

		// AB test set rows shown
		videos = videos.slice(0, groupParams.rows > 1 ? 8 : 4);

		$out = $(Mustache.render(templates.bottomModule, {
			title: $.msg('videosmodule-title-default')
		}));

		for (i = 0; i < (groupParams.rows * 4); i++) {
			instance = new TitleThumbnailView({
				el: 'li',
				model: videos[i],
				idx: i
			}).render();

			$out.find('.thumbnails').append(instance.$el);
			thumbnailViews.push(instance);
		}

		$out.addClass(groupParams.rows > 1 ? 'rows-2' : 'rows-1');

		if (groupParams.position === 1) {
			this.$el.before($out);
		} else {
			this.$el.after($out);
		}

		$.each(thumbnailViews, function () {
			this.applyEllipses({
				wordsHidden: 2
			});
		});

		track({label: 'module-impression'});
	};

	return VideoModule;
});
