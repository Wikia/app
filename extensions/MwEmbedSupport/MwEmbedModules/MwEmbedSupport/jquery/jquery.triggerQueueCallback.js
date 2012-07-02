/**
 * Runs all the triggers on all the named bindings of an object with
 * a single callback
 * 
 * NOTE THIS REQUIRES JQUERY 1.4.2 and above
 * 
 * Normal jQuery tirgger calls will run the callback directly
 * multiple times for every binded function.
 * 
 * With triggerQueueCallback() master callback is not called until all the
 * binded events have run their local callbacks.
 * 
 * This is useful in cases where you have multiple modules that need to do asynchronous loads
 * before issuing the a callback. 
 * 
 * @param {string}
 *            triggerName Name of trigger to be run
 * @param {object=}
 *            arguments Optional arguments object to be passed to
 *            the callback
 * @param {function}
 *            callback Function called once all triggers have been
 *            run
 * 
 */
( function( $ ) {
	$.fn.triggerQueueCallback = function( triggerName, triggerParam, callback ){
		var targetObject = this;
		// Support optional triggerParam data
		if( !callback && typeof triggerParam == 'function' ){
			callback = triggerParam;
			triggerParam = null;
		}
		
		// Support namespaced event segmentation
		var triggerBaseName = triggerName.split(".")[0]; 
		var triggerNamespace = triggerName.split(".")[1];
		// Get the callback set
		var callbackSet = [];

		// Check for both jQuery 1.4.4 events location and other jQuery data location: 
		if( !$( targetObject ).data( 'events' ) && ! $( targetObject).get(0)['__events__'] ){
			// No events run the callback directly
			callback();
			return ;
		}
		
		var triggerEventSet = $( targetObject ).data( 'events' ) ?
					$( targetObject ).data( 'events' )[ triggerBaseName ] :
					$( targetObject).get(0)['__events__'][ 'events' ][ triggerBaseName ];
		if( ! triggerNamespace ){
			callbackSet = triggerEventSet;
		} else{		
			$.each( triggerEventSet, function( inx, bindObject ){
				if( bindObject.namespace ==  triggerNamespace ){
					callbackSet.push( bindObject );
				}
			});
		}

		if( !callbackSet || callbackSet.length === 0 ){
			//mw.log( '"mwEmbed::jQuery.triggerQueueCallback: No events run the callback directly: ' + triggerName );
			// No events run the callback directly
			callback();
			return ;
		}
		
		// Set the callbackCount
		var callbackCount = ( callbackSet.length )? callbackSet.length : 1;
		// mw.log("mwEmbed::jQuery.triggerQueueCallback: " + triggerName
		// + ' number of queued functions:' + callbackCount );
		var callInx = 0;
		var callbackData = [];
		var doCallbackCheck = function() {
			var args = $.makeArray( arguments );
			// If only one argument don't use an array: 
			if( args.length == 1 ){
				args = args[0];
			}
			// Add the callback data for the current trigger:
			callbackData.push( args );
			callInx++;
			
			// If done with loading run master callback with callbackData
			if( callInx == callbackCount ){
				callback( callbackData );
			}
		};
		if( triggerParam ){
			$( this ).trigger( triggerName, [ triggerParam, doCallbackCheck ]);
		} else {
			$( this ).trigger( triggerName, [ doCallbackCheck ] );
		}
	};
} )( jQuery );