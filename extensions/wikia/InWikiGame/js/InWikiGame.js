var InWikiGame = {
	storageEntryPoint: null,
	init: function(jsonObject) {
		//http://www.realmofthemadgod.com/?entrypt=rmg-wiki---en@73--subid1-subid2-subid3
		//subid1 = current location
		//subid2 = entry point
		this.storageEntryPoint = $.storage.get(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY) || 'direct';
		var iframeUrl = 'http://www.realmofthemadgod.com/?entrypt=rmg-wiki---en@73--';
		iframeUrl += this.getTitle();

		var entryPoint = this.getEntryPoint();
		iframeUrl = (entryPoint !== null) ? (iframeUrl + '-' + entryPoint) : iframeUrl;

		$('.InWikiGameWrapper a').click(function(e) {
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
					'label': 'iframe-entry-point-' + InWikiGame.storageEntryPoint,
					'value': null,
					'params': {},
					'trackingMethod': 'internal'
				});
			});
			$(this).html(iframe);
			e.preventDefault();
		});
	},
	getEntryPoint: function() {
		if( this.storageEntryPoint !== null ) {
			WikiaTracker.trackClick({
				'category': 'in-wiki-game',
				'action': WikiaTracker.ACTIONS.IMPRESSION,
				'label': 'placeholder-entry-point-' + this.storageEntryPoint,
				'value': null,
				'params': {},
				'trackingMethod': 'internal'
			});

			$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, null);
		}

		return this.storageEntryPoint;
	},
	getTitle: function() {
		return ( window.wgTitle ) ? window.wgTitle : 'undefined';
	}
}
