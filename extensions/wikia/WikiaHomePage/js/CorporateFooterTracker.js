var CorporateFooter = {
	init: function () {
		$('.wikiahomepage-footer').click(
			$.proxy(this.trackClick, this)
		);
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
