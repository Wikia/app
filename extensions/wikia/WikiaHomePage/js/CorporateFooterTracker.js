var CorporateFooter = {
	init: function () {
		$('.wikiahomepage-footer').click(
			$.proxy(this.trackClick, this)
		);
	},
	track: function(action, label, params) {
		var trackObj = {
			ga_category: 'corporateFooter',
			ga_action: action,
			ga_label: label
		};
		if(params) {
			$.extend(trackObj, params);
		}
		WikiaTracker.trackEvent(
			'trackingevent',
			trackObj,
			'internal'
		);
	},
	trackClick: function(ev) {
		var node = $(ev.target);
		if (node.is('.button')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'create-wiki');
		}
		else if (node.is('.interlang')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-link');
		}
		else if (node.is('a')) {
			this.track(
				WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
				'hubs-link',
				{href: node.attr('href'), anchor: node.text()}
			);
		}
	}
};

$(function () {
	CorporateFooter.init();
});
