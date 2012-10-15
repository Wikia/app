// widget init (on add / on load)
function WidgetSlideshow_init(id, widget) {
	// preload images
	$('#widget_' + id + '-images').find('li').each( function() {
		var node = $(this);
		node
			.css('backgroundImage', 'url(' + node.attr('title') + ')')
			.removeAttr('title');
	});

	// jQuery.slideshow has been removed from our repository
	// as this is the last place it is used and Widget JavaScript
	// has been disabled. If it ever gets re-enabled, this Widget
	// will need to be refactored using jQuery.carousel (BugId:42477).
	// See: /resources/wikia/jquery/carousel/jquery.wikia.carousel.js
	/*
	$('#widget_' + id + '_content').slideshow({
		slidesClass:	'WidgetSlideshowImages',
		buttonsClass:	'WidgetSlideshowControls',
		nextClass:	'WidgetSlideshowControlNext',
		prevClass:	'WidgetSlideshowControlPrev',
		pauseClass:	'WidgetSlideshowControlPause',
		startClass:	'WidgetSlideshowControlPlay',
		blockedClass:	'blocked',
		slideWidth:	'186px'
	});
	*/

	$().log('#widget_' + id + ' initialized', 'Slideshow');
}

// called after widget settings are changed
function WidgetSlideshow_after_edit(id, widget) {
	WidgetSlideshow_init(id, widget);
}
