function WidgetTipsChange(widgetId, tipId, op) {
	$('#widget_' + widgetId + '_content').html('').addClass('widget_loading');

	$.getJSON(wgScript + '?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&tipId='+tipId+'&op='+op, function(res) {
		if(res.success) {
			$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);
			if(res.title) {
				$('#widget_' + res.id +'_header').html(res.title);
			}
		}
	});
}
