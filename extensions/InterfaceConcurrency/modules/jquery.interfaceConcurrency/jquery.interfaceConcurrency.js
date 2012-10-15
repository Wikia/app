/**
 * Base jQuery plugin for Concurrency 
 *
 * @author Rob Moen
 * 
 * Checkout Example:

	$.concurrency.check( {
		ccaction: 'checkout',
		resourcetype: 'application-specific-string',
		record: 123 
	}, function ( result ) {
		if ( result === 'failure' ) { 
			// Checkout failed because item is already checked out.  do something useful here.
		} else if ( result === 'success' ) {
			// Successfully checked out item.  do something useful here.
		}
	} );
 */

(function ( $ ) {
	$.concurrency = {
		/* 
		 * Checkin our checkout an object via API
		 * @param Object = {
				ccaction: (string) 'checkout' or 'checkin' 
				resourcetype: (string) 'application-specific-string' 
				record: (int) resource id 
				callback: (function) handle results 
			}
		 */
		check: function ( params, callback ) {
			params = $.extend({
				action: 'concurrency',
				token: mw.user.tokens.get( 'editToken' ),
				format: 'json'
			}, params );

			return $.ajax( {
				type: 'POST',
				url: mw.util.wikiScript( 'api' ),
				data: params,
				success: function ( data ) {
					if ( typeof callback === 'function' ){
						if ( data && data.concurrency && data.concurrency.result ) { 
							callback( data.concurrency.result );
						}
					}
				},
				dataType: 'json'
			} );
		}
	};

})( jQuery );

