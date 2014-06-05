define('videosmodule.views.titleThumbnail', [
	'thumbnails.views.titleThumbnail',
	'wikia.tracker'
], function (TitleThumbnail, Tracker) {
	'use strict';

	var track = Tracker.buildTrackingFunction({
		category: 'videos-module-rail',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.CLICK,
		label: 'thumbnail-click'
	});

	function VideosModuleThumbnail(config) {
		this.idx = config.idx;
		TitleThumbnail.call(this, config);
	}

	VideosModuleThumbnail.prototype = Object.create(TitleThumbnail.prototype);
	VideosModuleThumbnail.prototype.bindEvents = function () {
		var self = this;
		this.$el.on('mousedown', 'a', function () {
			track({
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
