/** 
 * Logging library 
 *
 *   Synopsis:
 * 
 *    mw.log( "falls in the forest" );  // not logged, we start off at 'silent' log level 
 *
 *    // set the minimum level for a log message to be shown. Can be 'silent', 'fatal', 'warn', 'info', 'debug'
 *    mw.log.level = 'debug'; // show just about everything
 *    mw.log( 'some random crap' ); // will be shown
 *
 *    mw.log.level = 'warn'; // show less stuff 
 *
 *    mw.log( 'foo bar' ); // won't be shown, the default level for a log is 'info'
 *
 *    mw.log( 'this is a warning', 'warn' ); // will be shown
 *    
 *    var warnCute = mw.log.getLogger( 'cuteness', 'warn' );
 *    warnCute( 'overload!' ); // will log 'cuteness> overload!'
 *
 *    var logDebug = mw.log.getLogger( undefined, 'debug' );
 *    mw.log.level = 'debug';
 *    logDebug( "random spammy log for developers..." );   // will log "random spammy log for developers...";
 */

( function( mw, $j ) {

	/* how all the logging levels sort */
	var priority = {
		silent: 0,
		fatal: 10,
		warn: 20,
		info: 30,
		debug: 100
	};

	/**
	 * Log output to the console.
	 *
	 * In the case that the browser does not have a console available, one is created by appending a
	 * <div> element to the bottom of the body and then appending a <div> element to that for each
	 * message.
	 *
	 * @author Michael Dale <mdale@wikimedia.org>
	 * @author Trevor Parscal <tparscal@wikimedia.org>
	 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
	 * @param {string} string Message to output to console
	 * @param {string} optional, logging priority (see priority)
	 */
	mw.log = function( s, level ) {
	
		if ( typeof level === 'undefined' || ! priority.hasOwnProperty( level ) ) {
			level = 'info';
		}

		// don't show log message if lower priority than mw.log.level
		if ( priority[ mw.log.level ] < priority[ level ] ) {
			return;
		}

		if ( typeof window.console !== 'undefined' && typeof window.console.log === 'function' ) {
			window.console.log( s );
		} else {
			if ( typeof mw.log.makeConsole !== 'undefined' && mw.log.makeConsole ) {
				// Set timestamp
				var d = new Date();
				var time = ( pad( d.getHours(), 2 ) + ':' + pad( d.getMinutes(), 2 ) + pad( d.getSeconds(), 2 ) + pad( d.getMilliseconds(), 3 ) );
				// Show a log box for console-less browsers
				var $log = $( '#mw-log-console' );
				if ( !$log.length ) {
					$log = $( '<div id="mw-log-console"></div>' )
						.css( {
							'position': 'fixed',
							'overflow': 'auto',
							'z-index': 500,
							'bottom': '0px',
							'left': '0px',
							'right': '0px',
							'height': '150px',
							'background-color': 'white',
							'border-top': 'solid 2px #ADADAD'
						} )
						.appendTo( 'body' );
				}
				$log.append(
					$( '<div></div>' )
						.css( {
							'border-bottom': 'solid 1px #DDDDDD',
							'font-size': 'small',
							'font-family': 'monospace',
							'padding': '0.125em 0.25em'
						} )
						.text( s )
						.append( '<span style="float:right">[' + time + ']</span>' )
				);
			}
		}
	};
	
	// Logging is silent by default -- if you're debugging an app, figure out a way to turn it on
	mw.log.level = 0;

	/**
	 * Convenience function for logging cases where you want to repeatedly log with a prefix for each message,
	 * and/or at a particular logging level
	 *
	 * @param {string} prefix 
	 * @param {string} level name
	 * @return {function} logging function which prepends that prefix, and logs at that level
	 */
	mw.log.getLogger = function( prefixArg, level ) {
		var prefix = typeof prefixArg === 'undefined' ? '' : prefixArg + '> ';
		return function( s ) {
			mw.log( prefix + s, level );
		};  
	};

	/**
	 * Helper function for logging date/time -- given number, return string zero-padded to requested length
	 * @param d {number} the number
	 * @param n {number} length
	 * @return {string}
	 */
	function pad( d, n ) {
		var s = d.toString(); 
		while ( s.length < n ) {
			s = '0' + s; 
		}
		return s;
	}

} )( window.mediaWiki, jQuery );

