// widget init (on add / on load)
function WidgetSlideshow_init(id, widget) {
	$.getScript(wgExtensionsPath + '/wikia/WidgetFramework/Widgets/WidgetSlideshow/jquery-slideshow-0.4.js?' + wgStyleVersion, function() {
		// preload images
		$('#widget_' + id + '-images').find('li').each( function() {
			$(this).css('backgroundImage', 'url(' + $(this).attr('title') + ')');
			$(this).removeAttr('title');
		});

		// initialize slideshow
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
	});
}

// called after widget settings are changed
function WidgetSlideshow_after_edit(id, widget) {
	WidgetSlideshow_init(id, widget);
}
