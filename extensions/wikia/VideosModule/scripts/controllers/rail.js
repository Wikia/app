/**
 * Controller/entry point for Videos Module
 * Note: There's some commented code that would instantiate the videos module at the bottom of that page. We're going
 * to leave this in there for now as we may at some point switch back to the bottom position.
 */
define('videosmodule.controllers.rail',[
	'videosmodule.views.index',
	'videosmodule.models.videos',
	'videosmodule.templates.mustache',
	'wikia.mustache',
	'bucky'
], function (RailModule, VideoData, templates, Mustache, bucky) {
	'use strict';

	var $rail = $('#WikiaRail');

	bucky = bucky('videosmodule.controller.index');

	function init(containerElement) {
		var rail;

		bucky.timer.start('execution');

		// instantiate rail view
		rail = new RailModule({
			$el: $(Mustache.render(templates.VideosModule_index, {
				title: $.msg('videosmodule-title-default')
			})),
			model: new VideoData(),
			isFluid: false,
			buckyCategory: 'videosmodule.views.rail',
			trackingCategory: 'videos-module-rail',
			hookElement: containerElement,
			moduleInsertingFunction: $.fn.append
		});

		rail.$el.on('initialized.videosModule', function () {
			bucky.timer.stop('execution');
		});
	}

	return function(element) {
		// check if right rail is loaded before initing. If it's not loaded, bind to load event.
		if ($rail.hasClass('loaded')) {
			init(element);
		} else {
			$rail.on('afterLoad.rail', function() { init(element) });
		}
	}
});
