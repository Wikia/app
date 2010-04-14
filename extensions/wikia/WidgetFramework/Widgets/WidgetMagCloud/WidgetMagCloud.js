var WidgetMagCloudLoading = false;

function WidgetMagCloud_init(id, widget) {
	$().log('widget init', 'MagCloud');

	// add onclick event to open MagCloud initial popup
	$(widget).find('.WidgetMagCloudClickable').click(function(ev) {
		window.location = 'http://magcloud.wikia.com/';
	});
}
