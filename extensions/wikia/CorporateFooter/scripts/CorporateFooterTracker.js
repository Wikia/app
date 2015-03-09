var CorporateFooter = {
	init: function () {
		$('.wikiahomepage-footer')
			.on( 'click', $.proxy(this.trackClick, this) )
			.on( 'click', '.wikia-menu-button.secondary li', function ( event ) {
				// check if our target is really the event's target we would like to invoke - in order to avoid incidental
				// calling of event handler from child elements
				if ( event.target === this ) {
					event.stopPropagation();
					$( this ).children( 'a' ).get( 0 ).click();
				}
			});
	},
	track: function(action, label, params, event) {
		Wikia.Tracker.track({
			action: action,
			browserEvent: event,
			category: 'corporateFooter',
			label: label,
			trackingMethod: 'internal'
		}, params);
	},
	trackClick: function(ev) {
		var node = $(ev.target);
		if (node.is('.button')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'create-wiki', {}, ev);
		}
		else if (node.is('.interlang')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-link', {}, ev);
		}
		else if (node.is('a')) {
			this.track(
				Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				'hubs-link',
				{href: node.attr('href'), anchor: node.text()},
				ev
			);
		}
	}
};

$(function () {
	CorporateFooter.init();
});
