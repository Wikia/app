define('videosmodule.views.titleThumbnail', [
	'thumbnails.views.titleThumbnail',
	'wikia.tracker'
], function (TitleThumbnail, Tracker) {
	'use strict';

	var track = Tracker.buildTrackingFunction({
		category: 'videos-module-' + window.wgVideosModuleABTest,
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
		this.bindEvents();
		return this;
	};

	return VideosModuleThumbnail;
});
