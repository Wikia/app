// Old code to instantiate the bottom module. We're keeping it around just in case we decide to switch
// to the bottom position later on.

define('videosmodule.views.bottomModule', [
	'sloth',
	'videosmodule.views.titleThumbnail',
	'wikia.mustache',
	'videosmodule.templates.mustache'
], function (sloth, TitleThumbnailView, Mustache, templates) {
	'use strict';

	var groupParams;

	// mock test data for now
	groupParams = {
		rows: 2,
		position: 1
	};

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
		this.data = this.model.fetch();
		// Sloth is a lazy loading service that waits till an element is visible to load more content
		sloth({
			on: this.el,
			threshold: 200,
			callback: function () {
				self.data.complete(function () {
					self.handleRelatedPages();
				});
			}
		});
	};

	/**
	 * Handle logic to display videos module or not based on related pages module
	 */
	VideoModule.prototype.handleRelatedPages = function () {
		var self = this;

		// check if related pages is loaded and visible
		if (this.elContentPresent()) {
			this.onRelatedPagesLoad();
		} else {
			// wait till after related pages has loaded to check if visible
			this.$el.on('afterLoad.relatedPages', function () {
				if (self.elContentPresent()) {
					self.onRelatedPagesLoad();
				}
			});
		}
	};

	/**
	 * Called when related pages loads and is visible
	 */
	VideoModule.prototype.onRelatedPagesLoad = function () {
		this.render();
	};


	/**
	 * Check if the element has content that is not hidden by css
	 * @returns {boolean}
	 */
	VideoModule.prototype.elContentPresent = function () {
		var $content = this.$el.children();
		return !!(
			$content.length && !$content.is(':hidden') &&
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

	};

	return VideoModule;
});
