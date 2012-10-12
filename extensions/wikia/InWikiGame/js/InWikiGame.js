var InWikiGame = {
	init: function(jsonObject) {
		//http://www.realmofthemadgod.com/?entrypt=rmg-wiki---en@73--subid1-subid2-subid3
		//subid1 = current location
		//subid2 = entry point
		var iframeUrl = 'http://www.realmofthemadgod.com/?entrypt=rmg-wiki---en@73--';
		iframeUrl += this.getTitle();

		var entryPoint = this.getEntryPoint();
		iframeUrl = (entryPoint !== null) ? (iframeUrl + '-' + entryPoint) : iframeUrl;

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
	},
	getEntryPoint: function() {
		var entryPoint = $.storage.get(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY);

		if( entryPoint !== null ) {
			WikiaTracker.trackClick({
				'category': 'in-wiki-game',
				'action': WikiaTracker.ACTIONS.CLICK,
				'label': this.getGALabel(entryPoint),
				'value': null,
				'params': {},
				'trackingMethod': 'internal'
			});

			$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, null);
		}

		return entryPoint;
	},
	getTitle: function() {
		return ( window.wgTitle ) ? window.wgTitle : 'undefined';
	},
	getGALabel: function(entryPoint) {
		return 'game-entry-point-' + entryPoint;
	}
}
