function WidgetTipsChange(widgetId, tipId, op) {

    var callback = {
		success: function(o) {
			id = o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				YAHOO.util.Dom.removeClass(id+'_content', 'widget_loading');
				YAHOO.util.Dom.get(id+'_content').innerHTML = res.body;
				if(res.title) {
					YAHOO.util.Dom.get(id+'_header').innerHTML = res.title;
				}
			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: widgetId
    }

    YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&tipId='+tipId+'&op='+op, callback);
    YAHOO.util.Dom.get(widgetId+'_content').innerHTML = '';
    YAHOO.util.Dom.addClass(widgetId+'_content', 'widget_loading');
}
