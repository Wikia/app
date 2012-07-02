/*
 * Edit warning for Vector
 */
(function( $ ) {
	$(document).ready( function() {
		// Check if EditWarning is enabled and if we need it
		if ( $( '#wpTextbox1' ).size() == 0 ) {
			return true;
		}
		// Get the original values of some form elements
		$( '#wpTextbox1, #wpSummary' ).each( function() {
			$(this).data( 'origtext', $(this).val() );
		});
		// Attach our own handler for onbeforeunload which respects the current one
		var fallbackWindowOnBeforeUnload = window.onbeforeunload;
		var ourWindowOnBeforeUnload = function() {
			var fallbackResult = undefined;
			var retval = undefined;
			var thisFunc = arguments.callee;
			// Check if someone already set on onbeforeunload hook
			if ( fallbackWindowOnBeforeUnload ) {
				// Get the result of their onbeforeunload hook
				fallbackResult = fallbackWindowOnBeforeUnload();
			}
			// Check if their onbeforeunload hook returned something
			if ( fallbackResult !== undefined ) {
				// Exit here, returning their message
				retval = fallbackResult;
			} else {
				// Check if the current values of some form elements are the same as
				// the original values
				if (
					mw.config.get( 'wgAction' ) == 'submit' ||
					$( '#wpTextbox1' ).data( 'origtext' ) != $( '#wpTextbox1' ).val() ||
					$( '#wpSummary' ).data( 'origtext' ) != $( '#wpSummary' ).val()
				) {
					// Return our message
					retval = mediaWiki.msg( 'vector-editwarning-warning' );
				}
			}
			
			// Unset the onbeforeunload handler so we don't break page caching in Firefox
			window.onbeforeunload = null;
			if ( retval !== undefined ) {
				// ...but if the user chooses not to leave the page, we need to rebind it
				setTimeout( function() {
					window.onbeforeunload = thisFunc;
				} );
				return retval;
			}
		};
		var pageShowHandler = function() {
			// Re-add onbeforeunload handler
			window.onbeforeunload = ourWindowOnBeforeUnload;
		};
		pageShowHandler();
		if ( window.addEventListener ) {
			window.addEventListener('pageshow', pageShowHandler, false);
		} else if ( window.attachEvent ) {
			window.attachEvent( 'pageshow', pageShowHandler );
		}
		
		// Add form submission handler
		$( 'form' ).submit( function() {
			// Restore whatever previous onbeforeload hook existed
			window.onbeforeunload = fallbackWindowOnBeforeUnload;
		});
	});
	//Global storage of fallback for onbeforeunload hook
	var fallbackWindowOnBeforeUnload = null;
})( jQuery );
