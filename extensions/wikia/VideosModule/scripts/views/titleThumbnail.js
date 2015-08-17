define('videosmodule.views.titleThumbnail', [
	'thumbnails.views.titleThumbnail',
	'wikia.tracker'
], function (TitleThumbnail, Tracker) {
	'use strict';

	function VideosModuleThumbnail(config) {
		this.idx = config.idx;
		this.trackClick = Tracker.buildTrackingFunction({
			category: config.trackingCategory,
			trackingMethod: 'analytics',
			action: Tracker.ACTIONS.CLICK,
			label: 'thumbnail-click'
		});
		TitleThumbnail.call(this, config);
	}

	VideosModuleThumbnail.prototype = Object.create(TitleThumbnail.prototype);

	VideosModuleThumbnail.prototype.bindEvents = function () {
		var self = this;
		this.$el.on('mousedown', 'a', function () {
			self.trackClick({
				value: self.idx
			});
			return true;
		});
	};

	VideosModuleThumbnail.prototype.render = function () {
		this.constructor.prototype.render.call(this);
		this.addSourceInfo();
		this.bindEvents();
		return this;
	};

	/**
	 * Add information about how the video was selected to the DOM for debugging purposes
	 * Ex: (subject to change) local, article-related, wiki-topics, etc.
	 */
	VideosModuleThumbnail.prototype.addSourceInfo = function () {
		this.$el.attr('data-source', this.model.source);
	};

	return VideosModuleThumbnail;
});
