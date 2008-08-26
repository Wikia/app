function WidgetShoutBoxSend(widgetId) {

    var messageBox = YAHOO.util.Dom.get(widgetId + '_message');
    
    if (!messageBox || messageBox.value == '') {
	return false;
    }
    
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
				
				// focus on message input
				YAHOO.util.Dom.get(id + '_message').focus();
			} 
			else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: widgetId
    }
    
    message = encodeURIComponent( messageBox.value );

    YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&message='+message, callback);
    YAHOO.util.Dom.get(widgetId+'_content').innerHTML = '';
    YAHOO.util.Dom.addClass(widgetId+'_content', 'widget_loading');
    
    return true;
}


function WidgetShoutboxTabToogle(widgetId, tab) {

	    var currentTab = (tab == 0) ? 'online' : 'chat';
	    var onlineTab = YAHOO.util.Dom.get(widgetId+"_online");
	    var chatTab   = YAHOO.util.Dom.get(widgetId+"_chat");

	    // switch tabs and save current state to cookie
	    switch(currentTab)
	    {
		case "online":
		    onlineTab.style.display = "none";
		    chatTab.style.display   = "";
		    YAHOO.Tools.setCookie(widgetId + "_showChat", 1, new Date(2030, 0, 1));
		    break;

		case "chat":
		    onlineTab.style.display = "";
		    chatTab.style.display   = "none";
		    YAHOO.Tools.setCookie(widgetId + "_showChat", 0, new Date(2030, 0, 1));
		    break;
	    }
}
