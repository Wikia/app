// widget init (on add / on load)
function WidgetSlideshow_init(id, widget) {
	$.getScript(wgExtensionsPath + '/wikia/WidgetFramework/Widgets/WidgetSlideshow/jquery-slideshow-0.4.js?' + wgStyleVersion, function() {
		// preload images
		$('#widget_' + id + '-images').find('li').each( function() {
			$(this).css('backgroundImage', 'url(' + $(this).attr('rel') + ')');
			$(this).removeAttr('rel');
		});

		// initialize slideshow
		$('#widget_' + id + '_content').slideshow({
			slidesClass:	'WidgetSlideshowImages',
			buttonsClass:	'WidgetSlideshowControls',
			nextClass:	'WidgetSlideshowControlNext',
			prevClass:	'WidgetSlideshowControlPrev',
			pauseClass:	'WidgetSlideshowControlPause',
			startClass:	'WidgetSlideshowControlPlay',
			slideWidth:	'186px'
		});
	});
}
