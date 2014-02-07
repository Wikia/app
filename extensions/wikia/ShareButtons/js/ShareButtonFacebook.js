(function( window, $) {

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadFacebookAPI ],
		callback: function() {
			var dfd = new $.Deferred();
			console.log('callback');

			FB.XFBML.parse( $( '.fb-like' ).parent( '.shareButton' ).get( 0 ) );
			FB.Event.subscribe( 'xfbml.render', function() {
				console.log('FB loaded');
				dfd.resolve();
			} );
			FB.Event.subscribe( 'edge.create', function() {
				ShareButtons.track({
					label: 'facebook'
				});
			});

			return dfd.promise();
		}
	});
}

})( window, jQuery );
