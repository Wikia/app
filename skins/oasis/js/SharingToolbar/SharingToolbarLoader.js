jQuery(function( $ ) {
	var $toolbar,
		$header = $( '#WikiHeader' ),
		$button = $header.find( '.share-button' );

	// Load all required assets for the SharingToolbar, then initialize it
	$button.one( 'click', function( event ) {
		$button.addClass('share-enabled');

		$.when(
			Wikia.getMultiTypePackage({
				scripts: 'sharingtoolbar_js',
				templates: [{
					controllerName: 'SharingToolbarController',
					methodName: 'Index'
				}]
			}),
			// Can't load this with Wikia.getMultiTypePackage because it needs params :(
			$.getResource(
				$.getSassCommonURL( '/skins/oasis/css/core/SharingToolbar.scss', {
					widthType: window.wgOasisGrid ? 3 : 0
				})
			)
		).done(function( response ) {
			var pkg = response[ 0 ];

			Wikia.processStyle( pkg.styles );
			Wikia.processScript( pkg.scripts );

			// Attach toolbar to DOM
			$toolbar = $( pkg.templates.SharingToolbarController_Index );
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
		});
	});
});