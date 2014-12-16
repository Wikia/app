require([
	'videosmodule.views.incontent',
	'videosmodule.models.videos',
	'wikia.nodeFinder',
	'wikia.mustache',
	'videosmodule.templates.mustache',
	'bucky',
	'wikia.window',
	'wikia.document',
	'jquery'
], function (InContentModule,VideoData, nodeFinderModule, Mustache, templates, buckyModule, win, doc, $) {
	'use strict';

	// Make sure we're on an article page
	if (!win.wgArticleId) {
		return;
	}

	var infoboxWrapper = doc.getElementById('infoboxWrapper'),
		bucky = buckyModule('videosmodule.controller.in-content');

	function init() {
		var inContent,
			referenceElement,
			previousElement,
			moduleInsertingFunction,
			contentContainer = doc.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			boundaryOffsetTop = 1500;

		bucky.timer.start('execution');

		referenceElement = nodeFinderModule.getFullWidthChildByOffsetTop(
			contentContainer,
			headerSelector,
			boundaryOffsetTop
		);

		if (referenceElement) {
			previousElement = nodeFinderModule.getPreviousVisibleSibling(referenceElement);
			moduleInsertingFunction = $.fn.before;
		} else {
			referenceElement = nodeFinderModule.getLastVisibleChild(contentContainer);
			if (referenceElement) {
				previousElement = referenceElement;
				moduleInsertingFunction = $.fn.after;
			} else {
				referenceElement = contentContainer;
				moduleInsertingFunction = $.fn.prepend;
			}
		}

		inContent = new InContentModule({
			$el: $(Mustache.render(templates.inContent, {
				title: $.msg('videosmodule-title-default')
			})),
			referenceElement: referenceElement,
			previousElement: previousElement,
			moduleInsertingFunction: moduleInsertingFunction,
			model: new VideoData(),
			isFluid: false,
			numVids: 3,
			minNumVids: 3,
			buckyCategory: 'videosmodule.views.in-content',
			trackingCategory: 'videos-module-in-content'
		});

		inContent.$el.on('initialized.videosModule', function () {
			bucky.timer.stop('execution');
		});
	}

	if (infoboxWrapper) {
		$(infoboxWrapper).on('initialized.infobox', init);
	} else {
		$(doc).ready(init);
	}
});
