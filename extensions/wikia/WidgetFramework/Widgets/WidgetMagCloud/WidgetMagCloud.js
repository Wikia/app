/*var WidgetMagCloudLoading = false;

function WidgetMagCloud_init(id, widget) {
	$().log('widget init', 'MagCloud');

	// add onclick event to open MagCloud initial popup
	$(widget).find('.WidgetMagCloudClickable').click(function(ev) {
		// scroll the page up
		window.scrollTo(0,0);

		// don't send any tracking codes from widget framework
		if (typeof ev.stopPropagation == 'function') {
			ev.stopPropagation();
		}

		// RT #24845
		if (window.WidgetMagCloudLoading) {
			return;
		}
		window.WidgetMagCloudLoading = true;

		$.getScript(wgExtensionsPath + '/wikia/MagCloud/js/MagCloud.js?' + wgStyleVersion, function() {
			MagCloud.openIntroPopup();
		});
	});
}*/
