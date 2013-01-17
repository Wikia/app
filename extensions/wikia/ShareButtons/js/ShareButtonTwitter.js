(function( window, $) {

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadTwitterAPI ],
		callback: function() {
			var dfd = new $.Deferred();

			// Resolve when contents have finished loading
			$( '.twitter-share-button' ).load( dfd.resolve );

			twttr.ready(function(twttr) {
				twttr.events.bind('click', function(event) {
					ShareButtons.track({
						label: 'twitter-' + event.region
					});
				});
			});

			return dfd.promise();
		}
	});
}

})( window, jQuery );