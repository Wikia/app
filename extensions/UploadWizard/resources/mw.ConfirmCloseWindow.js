( function( mw, $, undefined ) {
	/**
	 * Prevent the closing of a window with a confirm message (the onbeforeunload event seems to 
	 * work in most browsers.) 
	 *
	 * This supersedes any previous onbeforeunload handler. If there was a handler before, it is 
	 * restored when you execute the returned function.
	 * e.g.
	 *
	 *       var allowCloseWindow = mw.confirmCloseWindow( { message: 'Dont close me!' } );
	 *       // ... do stuff that can't be interrupted ...
	 *       allowCloseWindow();
	 *
	 *
	 * @param options 	options - optional set of the following optional arguments:
	 *				message: function returning string message to show.
	 *				test: function returning boolean. If true, alert is shown. Defaults to always true.
	 * @return closure	execute this when you want to allow the user to close the window
	 */
	mw.confirmCloseWindow = function( options ) {
		if ( options === undefined ) {
			options = {};
		}

		var defaults = { 
			message: function() { return gM( 'mwe-prevent-close' ); },
			test: function() { return true; }
		}; 
		options = $.extend( defaults, options );

		var oldUnloadHandler = window.onbeforeunload;

		window.onbeforeunload = function() {
			if ( options.test() ) { 
				// remove the handler while the alert is showing - otherwise breaks caching in Firefox (3?).		
				// but if they continue working on this page, immediately re-register this handler
				var thisFunction = arguments.callee; 
				window.onbeforeunload = null;
				setTimeout( function() { 
					window.onbeforeunload = thisFunction;
				} );

				// show an alert with this message
				return options.message();
			}
		};

		// return the function they can use to stop this
		return function() {
			window.onbeforeunload = oldUnloadHandler;
		};
				
	};

} )( window.mediaWiki, jQuery );


