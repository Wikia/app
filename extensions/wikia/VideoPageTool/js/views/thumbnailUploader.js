define('views.videopageadmin.thumbnailUpload', [
		'jquery'
], function($) {
	'use strict';
	function ThumbnailUploader(opts) {
		this.$el = $(opts.el);
		this.init();
	}

	ThumbnailUploader.prototype = {
		init: function() {
			window.WMU_skipDetails = true;
			this.$el.on('click', $.proxy(this.showUploader, this));
		},
		showUploader: function() {
			window.WMU_show();
			window.WMU_openedInEditor = false;
		}
		
	};
	return ThumbnailUploader;
});
