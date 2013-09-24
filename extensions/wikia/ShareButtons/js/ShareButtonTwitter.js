(function( window, $) {

var Wikia = window.Wikia || {},
	ShareButtons = Wikia.ShareButtons;

if ( ShareButtons ) {
	ShareButtons.add({
		dependencies: [ $.loadTwitterAPI ],
		callback: function() {
			var dfd = new $.Deferred();

			// Resolve when contents have finished loading
			var button = $( '.twitter-share-button' );
			button.load( dfd.resolve );

			twttr.ready(function(twttr) {
				if (button.not('iframe').exists()) {
					// init share button one more time if Twitter api library was already loaded
					twttr.widgets.load(button.parent().get(0));
					dfd.resolve();
				}
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