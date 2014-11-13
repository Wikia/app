require([
	'videosmodule.views.inContent',
	'videosmodule.models.videos',
	'videosmodule.modules.nodeFinder',
	'bucky',
	'wikia.document'
], function (InContentModule, VideoData, nodeFinderModule, bucky, d) {
	'use strict';

//	bucky = bucky('videosmodule.controller.index');

	function init() {
		var inContent,
			element,
			contentContainer = d.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

//		bucky.timer.start('execution');

		element = nodeFinderModule.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);

		if (element){
			element = element.previousElementSibling;
		} else {
			element = nodeFinderModule.getLastVisibleChild(contentContainer);
		}

		inContent = new InContentModule({
			el: element,
			model: new VideoData()
		});

//		module.$el.on('initialized.videosModule', function() {
//			bucky.timer.stop('execution');
//		});
	}

	d.addEventListener('load', init());
});
