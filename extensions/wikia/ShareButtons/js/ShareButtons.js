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
		var dfd = new $.Deferred();

		if ( dependencies.length ) {
			$.getResources( dependencies ).done(function() {
				dependencies = [];

				while ( callbacks.length ) {
					callbacks.shift()();
				}

				dfd.resolve();
			});

		} else {
			dfd.resolve();
		}

		return dfd.promise();
	}
};

// Exports
Wikia.ShareButtons = ShareButtons;
window.Wikia = Wikia;

})( window, jQuery );