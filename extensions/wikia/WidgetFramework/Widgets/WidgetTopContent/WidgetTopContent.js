function WidgetTopContentSwitchSection(selector) {
	var widgetId = selector.id.split('_')[1],
		selected = selector.options[ selector.selectedIndex ].value;

	$('#widget_' + widgetId + '_content').html('').addClass('widget_loading');

	$.getJSON(wgScript + '?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&at='+selected, function(res) {
		if(res.success) {
			$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);
			if(res.title) {
				$('#widget_' + res.id +'_header').html(res.title);
			}
		}
	});
}
