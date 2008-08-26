function WidgetBookmarkDo(widgetId,cmd,id) {

	YAHOO.log(cmd + ' "' + id + '"', 'info', 'WidgetBookmark');

	var callback = {
		success : function(o) {
			id = o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			widgetDiv = YAHOO.util.Dom.get(id + '_content');

			// update widget content
			widgetDiv.innerHTML = res.body;
			YAHOO.util.Dom.removeClass(widgetDiv, 'widget_loading');
		},
		failure : function(o) {
			/// ...
		},
		argument: widgetId
	};

	// send AJAX request
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&cmd='+cmd+'&pid='+id, callback);

	// show progress bar
	var widgetDiv = YAHOO.util.Dom.get(widgetId + '_content');
	widgetDiv.innerHTML = '';
	YAHOO.util.Dom.addClass(widgetDiv, 'widget_loading');
}
