(function( window, $) {

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadFacebookAPI ],
		callback: function() {
			window.onFBloaded();
		}
	});
}

})( window, jQuery );