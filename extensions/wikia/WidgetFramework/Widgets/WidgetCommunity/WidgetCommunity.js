function WidgetCommunityDetailsToggle(node) {

    var Dom = YAHOO.util.Dom;
    var ul = node.parentNode.getElementsByTagName('ul')[0];
    
    Dom.setStyle(ul, 'display', ( Dom.getStyle(ul, 'display') == 'none') ? '' : 'none');
}

// tracking
function WidgetCommunity_init(id) {

	// my user page / talk page / widgets
	if (wgUserName) {
		myLinks = YAHOO.util.Dom.get(id + '-my-menu').getElementsByTagName('a');

		YAHOO.util.Event.addListener(myLinks[0], 'click', function(e) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'widget/WidgetCommunity/MyPage');
			YAHOO.util.Event.stopPropagation(e);
		});

		YAHOO.util.Event.addListener(myLinks[1], 'click', function(e) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'widget/WidgetCommunity/MyTalk');
			YAHOO.util.Event.stopPropagation(e);
        	});

		YAHOO.util.Event.addListener(myLinks[2], 'click', function(e) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'widget/WidgetCommunity/Widgets');
			YAHOO.util.Event.stopPropagation(e);
	        });

		// user page link in Welcome back...
		YAHOO.util.Event.addListener(YAHOO.util.Dom.get(id + '-my-name'), 'click', function(e) {
                	YAHOO.Wikia.Tracker.trackByStr(e, 'widget/WidgetCommunity/MyPage');
	                YAHOO.util.Event.stopPropagation(e);
        	});
	}

	// more...
	YAHOO.util.Event.addListener(id + '-more', 'click', function(e) {
		YAHOO.Wikia.Tracker.trackByStr(e, 'widget/WidgetCommunity/more');
		YAHOO.util.Event.stopPropagation(e);
        });

	// recently edited
	edits = YAHOO.util.Dom.get(id + '-recently-edited').getElementsByTagName('li');

	for (e=0; e < edits.length-1; e++) {
		links = edits[e].getElementsByTagName('a');
		YAHOO.util.Event.addListener(links[0], 'click', function(ev, id) {
			YAHOO.Wikia.Tracker.trackByStr(ev, 'widget/WidgetCommunity/RAlink'+id);
			YAHOO.util.Event.stopPropagation(ev);
        	}, e+1);

		YAHOO.util.Event.addListener(links[1], 'click', function(ev, id) { 
			YAHOO.Wikia.Tracker.trackByStr(ev, 'widget/WidgetCommunity/RAuser'+id);
			YAHOO.util.Event.stopPropagation(ev);
        	}, e+1);
	}
}
