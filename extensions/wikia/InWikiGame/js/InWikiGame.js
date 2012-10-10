var InWikiGame = {
	init: function(jsonObject) {
		var iframeUrl = 'http://www.realmofthemadgod.com/';
		$('.InWikiGameWrapper').click(function() {
			var iframe = $(
				'<iframe></iframe>',
				{
					'src': iframeUrl,
					'width': '800px',
					'height': '600px'
				}
			);
			$(this).html(iframe);
			InWikiGame.trackClick('in-wiki-game', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'game-iframe-appears', null, {});
		});

		this.trackEntryPoint();
	},
	trackEntryPoint: function() {
		var entryPoint = $.storage.get(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY);

		if( entryPoint !== null ) {
			var GALabel = this.getGALabel(entryPoint);
			this.trackClick('in-wiki-game', WikiaTracker.ACTIONS.CLICK, GALabel, null, {});
			$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, null);
		}
	},
	getGALabel: function(entryPoint) {
		return 'game-entry-point-' + entryPoint;
	},
	//todo: extract class
	trackClick: function (category, action, label, value, params) {
		var trackingObj = {
			ga_category: category,
			ga_action: action,
			ga_label: label
		};

		if (value) {
			trackingObj['ga_value'] = value;
		}

		if (params) {
			$.extend(trackingObj, params);
		}

		WikiaTracker.trackEvent(
			'trackingevent',
			trackingObj,
			'ga'
		);
	}
}
