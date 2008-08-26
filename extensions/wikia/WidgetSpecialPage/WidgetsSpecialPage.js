YAHOO.util.Event.onDOMReady(function() {

    var Dom = YAHOO.util.Dom;

    // onclick handler
    function add(widget) {
	position = [1, 1];

	tempId = Dom.generateId();
	loadEl = document.createElement((skin == 'quartz') ? 'li' : 'dl');
	loadEl.id = tempId;
	loadEl.className = 'widget widget_loading';

	if (skin=='monaco') {
	    Dom.get('sidebar_1').insertBefore(loadEl, Dom.get('sidebar_1').firstChild);
	}
	else {
	    Dom.get('widgets_1').insertBefore(loadEl, Dom.get('widgets_1').firstChild);
	}

	var type = this.id.split('-')[1];

	var add_callback = {
		success: function(o) {
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				if(res.reload) {
					window.location.reload(true);
				} else {
					tempId = o.argument.tempId;
					tempEl = document.createElement('div');
					tempEl.innerHTML = res.widget;

					new YAHOO.wikia.ddObject(tempEl.firstChild.id);

					id = tempEl.firstChild.id;
					id = id.substring(0, id.length - 3);

					Dom.setStyle(tempId, 'display', 'none');
					Dom.get(tempId).parentNode.insertBefore(tempEl.firstChild, Dom.get(tempId))

					el = Dom.get(tempId);
					el.parentNode.removeChild(el);

					fname = o.argument.type + '_init';
					if(YAHOO.lang.isFunction(window[fname])) {
						window[fname](id);
					}
				}
			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: {type:type, tempId:tempId}
	}

	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=add&type='+type+'&sidebar='+position[0]+'&index='+position[1]+'&skin='+skin, add_callback);
    }


    // get list of "add" icon nodes
    var widgets = Dom.getElementsByClassName('add', 'div', 'widgetsSpecialPageList');

    for(w=0; w<widgets.length; w++) {
        var widgetName = widgets[w].id.split('-')[1];
	    
        // register onclick event for "add" icons
        YAHOO.util.Event.addListener(widgets[w], 'click', add);
    }
});
