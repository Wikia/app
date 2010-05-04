var WidgetMagCloudLoading = false;

function WidgetMagCloudM_init(id, widget) {
	$().log('widget init', 'MagCloudM');

	// add onclick event to open MagCloud initial popup
	$(widget).find('.WidgetMagCloudClickable').click(function(ev) {
		window.location = 'http://magcloud.wikia.com/';
	});
}
