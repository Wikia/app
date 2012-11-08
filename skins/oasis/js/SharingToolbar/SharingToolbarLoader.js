jQuery(function( $ ) {

	// Load all required assets for the SharingToolbar, then initialize it
	var $button = $( '#WikiHeader .share-button' ).one( 'click', function( event ) {
		$.when(
			$.nirvana.sendRequest({
				controller: 'SharingToolbarController',
				method: 'Index',
				format: 'html',
				type: 'GET'
			}),
			$.getResources([
				wgResourceBasePath + '/skins/oasis/js/SharingToolbar/SharingToolbar.js',
				$.getSassCommonURL( '/skins/oasis/css/core/SharingToolbar.scss' )
			])
		).done(function( response ) {
			Wikia.SharingToolbar.init({
				$button: $button,
				event: event,
				template: response[ 0 ]
			});
		});
	});
});