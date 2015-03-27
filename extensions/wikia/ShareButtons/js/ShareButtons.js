(function( window, $ ) {

var callbacks = [],
	dependencies = [],
	Wikia = window.Wikia || {};

// Share button dependency resolver
var ShareButtons = {
	add: function( button ) {
		var dependency, i, length;

		if ( $.isFunction( button.callback ) ) {
			callbacks.push( button.callback );
		}

		if ( $.isArray( button.dependencies ) ) {
			for ( i = 0, length = button.dependencies.length; i < length; i++ ) {
				dependency = button.dependencies[ i ];

				if ( $.inArray( dependency, dependencies ) < 0 ) {
					dependencies.push( dependency );
				}
			}
		}
	},
	process: function() {
		var i, length,
			dfd = new $.Deferred(),
			head = new $.Deferred(),
			tail = head.promise();

		if ( dependencies.length ) {
			$.getResources( dependencies ).done(function() {
				dependencies = [];

				for ( i = 0, length = callbacks.length; i < length; i++ ) {
					tail = tail.pipe( callbacks[ i ] );
				}

				tail.done( dfd.resolve );
			});

		} else {
			tail.resolve();
		}

		head.resolve();

		return dfd.promise();
	},
	track: Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'share',
		trackingMethod: 'analytics'
	})
};

// Exports
Wikia.ShareButtons = ShareButtons;
window.Wikia = Wikia;

})( window, jQuery );
