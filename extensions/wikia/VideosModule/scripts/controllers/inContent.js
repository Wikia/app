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
			nearestElement,
			previousElement,
			placement,
			contentContainer = doc.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

		bucky.timer.start('execution');

		nearestElement = nodeFinderModule.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);

		if (nearestElement){
			previousElement = nearestElement.previousElementSibling;
			placement = $.fn.before;
		} else {
			nearestElement = nodeFinderModule.getLastVisibleChild(contentContainer);
			previousElement = nearestElement;
			placement = $.fn.after;
		}

		inContent = new InContentModule({
			$el: $(Mustache.render(templates.inContent, {
				title: $.msg('videosmodule-title-default')
			})),
			nearestElement: nearestElement,
			previousElement: previousElement,
			parentElement: contentContainer,
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
