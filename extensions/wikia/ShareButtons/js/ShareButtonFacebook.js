(function( window, $) {

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadFacebookAPI ],
		callback: function() {
			var dfd = new $.Deferred();

			FB.Event.subscribe( 'xfbml.render', dfd.resolve );
			FB.XFBML.parse( $( '.fb-like' ).parent( '.shareButton' ).get( 0 ) );

			return dfd.promise();
		}
	});
}

})( window, jQuery );