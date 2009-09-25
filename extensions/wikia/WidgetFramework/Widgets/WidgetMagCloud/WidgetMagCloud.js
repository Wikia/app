function WidgetMagCloud_init(id, widget) {
	$().log('widget init', 'MagCloud');

	// add onclick event to open MagCloud initial popup
	$(widget).find('.WidgetMagCloudClickable').click(function(ev) {
		// don't send any tracking codes from widget framework
		if (typeof ev.stopPropagation == 'function') {
			ev.stopPropagation();
		}

		$.getScript(wgExtensionsPath + '/wikia/MagCloud/js/MagCloud.js?' + wgStyleVersion, function() {
			MagCloud.openIntroPopup();
		});
	});
}
