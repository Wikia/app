define('videosmodule.views.inContent', [
	'sloth',
	'videosmodule.views.titleThumbnail',
	'wikia.mustache',
	'videosmodule.templates.mustache'
], function (sloth, TitleThumbnailView, Mustache, templates) {
	'use strict';

	var videosLimit = 3;

	function VideoModule(options) {
		// Note that this.el refers to the DOM element that the videos module should be inserted before or after,
		// not the wrapper for the videos module. We can update this after the A/B testing is over.
		this.el = options.el;

		if (!this.el) {
			return;
		}

		this.$el = $(options.el);
		this.model = options.model;
		this.articleId = window.wgArticleId;

		// Make sure we're on an article page
		if (this.articleId) {
			this.init();
		}
	}

	VideoModule.prototype.init = function() {
		var self = this;
		this.data = this.model.fetch();
		// Sloth is a lazy loading service that waits till an element is visible to load more content
		sloth({
			on: this.el,
			threshold: 200,
			callback: function() {
				self.data.complete(function() {
					self.render();
				});
			}
		});
	};

	VideoModule.prototype.render = function() {
		var i,
			$out,
			videos = this.model.data.videos,
			len = videos.length,
			instance,
			$thumbnails;

		// If no videos are returned from the server, don't render anything
		if (!len) {
			return;
		}

		$out = $(Mustache.render(templates.inContent, {
			title: $.msg('videosmodule-title-default')
		}));

		$thumbnails = $out.find('.thumbnails');

		for (i = 0; i < videosLimit; i++) {
			instance = new TitleThumbnailView({
				el: 'li',
				model: videos[i],
				idx: i
			}).render();

			$thumbnails.append(instance.$el);
		}

		this.$el.after($out);
	};

	return VideoModule;
});
