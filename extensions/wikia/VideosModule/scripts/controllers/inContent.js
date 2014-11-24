require([
	'videosmodule.views.index',
	'videosmodule.models.videos',
	'wikia.nodeFinder',
	'wikia.mustache',
	'videosmodule.templates.mustache',
	'bucky',
	'wikia.tracker',
	'wikia.document'
], function (InContentModule, VideoData, nodeFinderModule, Mustache, templates, bucky, Tracker, doc) {
	'use strict';

	bucky = bucky('videosmodule.controller.in-content');

	function init() {
		var inContent,
			hookElement,
			previousElement,
			moduleInsertingFunction,
			contentContainer = doc.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

		bucky.timer.start('execution');

		hookElement = nodeFinderModule.getChildByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);
		if (hookElement){
			previousElement = nodeFinderModule.getPreviousVisibleSibling(hookElement);
			moduleInsertingFunction = $.fn.before;
		} else {
			hookElement = nodeFinderModule.getLastVisibleChild(contentContainer);
			if (hookElement) {
				previousElement = hookElement;
				moduleInsertingFunction = $.fn.after;
			} else {
				hookElement = contentContainer;
				moduleInsertingFunction = $.fn.prepend;
			}
		}

		inContent = new InContentModule({
			$el: $(Mustache.render(templates.inContent, {
				title: $.msg('videosmodule-title-default')
			})),
			hookElement: hookElement,
			previousElement: previousElement,
			moduleInsertingFunction: moduleInsertingFunction,
			model: new VideoData(),
			numVids: 3,
			minNumVids: 3,
			bucky: bucky('videosmodule.views.in-content'),
			trackImpression: Tracker.buildTrackingFunction({
				category: 'videos-module-in-content',
				trackingMethod: 'both',
				action: Tracker.ACTIONS.IMPRESSION,
				label: 'module-impression'
			}),
			trackClick: Tracker.buildTrackingFunction({
				category: 'videos-module-in-content',
				trackingMethod: 'both',
				action: Tracker.ACTIONS.CLICK,
				label: 'thumbnail-click'
			})
		});

		inContent.$el.on('initialized.videosModule', function () {
			bucky.timer.stop('execution');
		});
	}

	doc.addEventListener('load', init());
});
