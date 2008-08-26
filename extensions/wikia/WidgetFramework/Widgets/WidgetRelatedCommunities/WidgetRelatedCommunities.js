// tracking
function WidgetRelatedCommunities_init(id) {

	links = YAHOO.util.Dom.get(id+'_content').getElementsByTagName('a');

	for (l=0; l < links.length; l++) {
		YAHOO.util.Event.addListener(links[l], 'click', function(ev, url) {
			YAHOO.Wikia.Tracker.trackByStr(ev, 'widget/WidgetRelatedCommunities/' + url);
			YAHOO.util.Event.stopPropagation(ev);
		}, ((l+1) + '/' + links[l].innerHTML) );
	}
}
