require([
	'videosmodule.views.inContent',
	'videosmodule.controllers.nodeFinder',
	'videosmodule.models.videos',
	'bucky',
	'wikia.document'
], function (Module, nodeFinder, VideoData, bucky, d) {
	'use strict';

//	bucky = bucky('videosmodule.controller.index');

	function init() {
		var module,
			contentContainer = d.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

//		bucky.timer.start('execution');

		module = new Module({
			el: nodeFinder.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop),
			model: new VideoData()
		});

//		module.$el.on('initialized.videosModule', function() {
//			bucky.timer.stop('execution');
//		});
	}

	init();
});
