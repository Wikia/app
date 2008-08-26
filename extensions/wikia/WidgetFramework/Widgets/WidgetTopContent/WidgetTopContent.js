function WidgetTopContentSwitchSection(selector) {

    widgetId = selector.id.split('-')[0];
    selected = selector.options[ selector.selectedIndex ].value;

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

				 WidgetTopContent_init(id);

			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: widgetId
    }

	YAHOO.Wikia.Tracker.trackByStr(null, 'sidebar/TopContent/' + selector.selectedIndex + '_' + selected);

    YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&at='+selected, callback);
    YAHOO.util.Dom.get(widgetId+'_content').innerHTML = '';
    YAHOO.util.Dom.addClass(widgetId+'_content', 'widget_loading');
}

// setup tracking
function WidgetTopContent_init(id) {
	content = YAHOO.util.Dom.get(id + '_content');
	links = content.childNodes[0].getElementsByTagName('a');

	YAHOO.util.Event.addListener(links, 'click', function(e,id) {
		selector = YAHOO.util.Dom.get(id + '-select');
		sectionId = selector.selectedIndex;
		sectionName = selector.options[sectionId].value;

		el = YAHOO.util.Event.getTarget(e);

		if (YAHOO.Wikia && YAHOO.Wikia.Tracker) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'TopContent/' + (sectionId+1) + '_' + sectionName + '/' + el.innerHTML);
		}

		YAHOO.util.Event.stopPropagation(e);
        }, id);
}
