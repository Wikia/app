function WidgetRelatedCommunities_init(id, widget) {

	// add tracking
	widget.find('a').each( function(n) {
		$(this).click( function(e) {
			WET.byStr('widget/WidgetRelatedCommunities/' + (n+1) + '/' + $(this).html() );
		});
	});
}
