jQuery(function( $ ) {
	var $toolbar,
		$header = $( '#WikiHeader' ),
		$button = $header.find( '.share-button' );

	function initialize( event ) {
		$button.addClass('share-enabled');

		var widthType = window.wgOasisGrid ? 3 : 0;
		if (window.wgOasisResponsive) {
			widthType = 2;
		}

		require(['wikia.loader', 'mw'], function(loader, mw) {
			loader({
				type: loader.MULTI,
				resources: {
					scripts: 'sharingtoolbar_js',
					templates: [{
						controller: 'SharingToolbar',
						method: 'Index',
						params: {
							pagename: mw.config.get('wgPageName')
						}
					}]
				}
			},{
				type: loader.SCSS,
				resources: '/skins/oasis/css/core/SharingToolbar.scss',
				params: {
					widthType: widthType
				}
			}).done(
				function( response ) {
					loader.processScript( response.scripts );

					// Attach toolbar to DOM
					$toolbar = $( response.templates.SharingToolbar_Index );
					$header.append( $toolbar.addClass('loading') );

					// Initialize the Sharing Toolbar
					Wikia.SharingToolbar.init({
						button: $button,
						event: event,
						toolbar: $toolbar
					});

					// Display the toolbar when the share buttons are done processing
					Wikia.ShareButtons.process().done(function() {
						Wikia.SharingToolbar.toggleToolbar( event );
					});
				}
			);
		})

	}

	// Load immediately if user is in "ON" group of "SHARE_BUTTON" experiment.
	if ( Wikia.AbTest && Wikia.AbTest.getGroup( 'SHARE_BUTTON' ) == 'ON' ) {
		initialize( $.Event() );

	// Load all required assets for the SharingToolbar, then initialize it
	} else {
		$button.one( 'click', initialize );
	}
});
