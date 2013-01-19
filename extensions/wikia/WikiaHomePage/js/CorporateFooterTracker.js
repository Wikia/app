var CorporateFooter = {
	init: function () {
		$('.wikiahomepage-footer').click(
			$.proxy(this.trackClick, this)
		);
	},
	track: function(action, label, params, event) {
		WikiaTracker.track('internal', $.extend({
			action: action,
			browserEvent: event,
			category: 'corporateFooter',
			label: label
		}, params));
	},
	trackClick: function(ev) {
		var node = $(ev.target);
		if (node.is('.button')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'create-wiki', {}, ev);
		}
		else if (node.is('.interlang')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-link', {}, ev);
		}
		else if (node.is('a')) {
			this.track(
				WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
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
