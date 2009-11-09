function WidgetCommunity_init(id, widget) {
	$('#community-widget-action-button').click( function(e) {
		WET.byStr('widget/WidgetCommunity/more');
	});

	// Latest Activity links
	$('#widget_' + id + '-recently-edited').find('a').each(function(n) {
		$(this).click( function(e) {
			url = (n%2 == 0 ? 'RAlink/' : 'RAuser/') + parseInt(Math.floor(n/2) + 1);
			WET.byStr('widget/WidgetCommunity/' + url);
		});
	});

	var loadFreshData = function(id, timestamp) {
		var params = {};
		var uselang = $.getUrlVar('uselang');
		params['uselang'] = uselang ? uselang : wgUserLanguage;
		$.getJSON(wgScript + '?action=ajax&rs=CommunityWidgetAjax', params, function(json){
			if (json.timestamp > timestamp) {
				$('#widget_' + id + '-recently-edited').after(json.data).remove();
			}
		});
	}

	if (wgUserName == null) {
		loadFreshData(id, window['timestamp_widget_'+id]);
	}
}