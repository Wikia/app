(function( window, $) {
'use strict';

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadFacebookSDK ],
		callback: function() {
			var dfd = new $.Deferred();

			window.FB.Event.subscribe( 'xfbml.render', dfd.resolve );
			window.FB.Event.subscribe( 'edge.create', function() {
				ShareButtons.track({
					label: 'facebook'
				});
			});
			window.FB.XFBML.parse( $( '.fb-like' ).parent( '.shareButton' ).get( 0 ) );
			return dfd.promise();
		}
	});
}

})( window, jQuery );