function WidgetCommunity_init(id, widget) {
	var loadFreshData = function(id, timestamp) {
		var params = {},
			uselang = $.getUrlVar('uselang');
		params.uselang = uselang || wgUserLanguage;
		params.cb = wgStyleVersion;
		$.getJSON(wgScript + '?action=ajax&rs=CommunityWidgetAjax', params, function(json){
			if (json.timestamp > timestamp) {
				$('#widget_' + id + '-recently-edited').after(json.data).remove();
			}
		});
	};

	if (wgUserName == null) {
		loadFreshData(id, window['timestamp_widget_'+id]);
	}

	if (wgUserLanguage == 'en') {
		$('span.timeago').timeago();
	}
}