var InWikiGame = {
	init: function(jsonObject) {
		var iframeUrl = 'http://www.realmofthemadgod.com/';
		$('.InWikiGameWrapper').click(function() {
			var iframe = $(
				'<iframe></iframe>',
				{
					'src': iframeUrl,
					'width': '800px',
					'height': '792px'
				}
			);
			iframe.load(function() {
				WikiaTracker.trackClick({
					'category': 'in-wiki-game',
					'action': WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
					'label': 'game-iframe-placeholder-click',
					'value': null,
					'params': {},
					'trackingMethod': 'internal'
				});
			});
			$(this).html(iframe);
		});

		this.trackEntryPoint();
	},
	trackEntryPoint: function() {
		var entryPoint = $.storage.get(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY);

		if( entryPoint !== null ) {
			this.trackClick({
				'category': 'in-wiki-game',
				'action': WikiaTracker.ACTIONS.CLICK,
				'label': this.getGALabel(entryPoint),
				'value': null,
				'params': {},
				'trackingMethod': 'internal'
			});
			$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, null);
		}
	},
	getGALabel: function(entryPoint) {
		return 'game-entry-point-' + entryPoint;
	}
}
