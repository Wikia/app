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
			element,
			contentContainer = d.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

//		bucky.timer.start('execution');

		element = nodeFinder.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);

		if (element){
			element = element.previousElementSibling;
		} else {
			element = nodeFinder.getLastVisibleChild(contentContainer);
		}

		module = new Module({
			el: element,
			model: new VideoData()
		});

//		module.$el.on('initialized.videosModule', function() {
//			bucky.timer.stop('execution');
//		});
	}

	d.addEventListener('load', init());
});
