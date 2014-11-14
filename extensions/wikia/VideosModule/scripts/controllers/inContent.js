require([
	'videosmodule.views.inContent',
	'videosmodule.models.videos',
	'videosmodule.modules.nodeFinder',
	'wikia.mustache',
	'videosmodule.templates.mustache',
	'bucky',
	'wikia.document'
], function (InContentModule, VideoData, nodeFinderModule, Mustache, templates, bucky, doc) {
	'use strict';

	bucky = bucky('videosmodule.controller.in-content');

	function init() {
		var inContent,
			hookElement,
			previousElement,
			placement,
			contentContainer = doc.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

		bucky.timer.start('execution');

		hookElement = nodeFinderModule.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);
		if (hookElement){
			previousElement = hookElement.previousElementSibling;
			placement = $.fn.before;
		} else {
			hookElement = nodeFinderModule.getLastVisibleChild(contentContainer);
			if (hookElement) {
				previousElement = hookElement;
				placement = $.fn.after;
			} else {
				hookElement = contentContainer;
				placement = $.fn.prepend;
			}
		}

		inContent = new InContentModule({
			$el: $(Mustache.render(templates.inContent, {
				title: $.msg('videosmodule-title-default')
			})),
			hookElement: hookElement,
			previousElement: previousElement,
			placement: placement,
			model: new VideoData(),
			numVids: 3,
			minNumVids: 3
		});

		inContent.$el.on('initialized.videosModule', function() {
			bucky.timer.stop('execution');
		});
	}

	doc.addEventListener('load', init());
});
