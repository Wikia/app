YAHOO.util.Event.onDOMReady(function() {
	YAHOO.util.Event.addListener('sidebar_button_helper', 'click', toggleSidebarVisible, 'helper');
	YAHOO.util.Event.addListener('sidebar_button_widgets', 'click', toggleSidebarVisible, 'widgets');
});

function toggleSidebarVisible(e, o) {
	YAHOO.util.Event.preventDefault(e);
	switch(o)
	{
		case 'helper':
			YAHOO.util.Dom.setStyle('sidebar_helper', 'display', 'block');
			YAHOO.util.Dom.setStyle('sidebar_widgets', 'display', 'none');
			YAHOO.util.Dom.addClass('sidebar_button_helper', 'selected');
			YAHOO.util.Dom.removeClass('sidebar_button_widgets', 'selected');
			break;
		case 'widgets':
			YAHOO.util.Dom.setStyle('sidebar_helper', 'display', 'none');
			YAHOO.util.Dom.setStyle('sidebar_widgets', 'display', 'block');
			YAHOO.util.Dom.addClass('sidebar_button_widgets', 'selected');
			YAHOO.util.Dom.removeClass('sidebar_button_helper', 'selected');
			break;
	}
	if (wgUserName !== null)
		setHelperPanelState(o);
}

var scriptUrl = wgServer + wgScriptPath;

function setHelperPanelState(o) {
    ajaxUrl = scriptUrl + "?action=ajax&rs=setHelperPanelState&rsargs=" + o;
    var request = YAHOO.util.Connect.asyncRequest( "GET", ajaxUrl);
}