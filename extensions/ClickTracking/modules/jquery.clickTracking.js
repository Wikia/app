/*
 * JavaScript for ClickTracking jQuery plugin
 */

( function( $ ) {
	if ( !$.cookie( 'clicktracking-session' ) ) {
		/*
		 * Very simple hashing of date, why simple?
		 * 1. This is based on the date, not the user, so security is not an issue.
		 * 2. This is for statistics gathering a large scales, in the very unlikley event that two users end up with the
		 *    same token, it will only introduce a tiny and acceptable amount of noise.
		 * 3. Because it's much more problematic to sent tons of JavaScript to the client than to cope with 1 and 2.
		 */
		var token = '',
			dict = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
			date = new Date().getTime();
		while ( token.length <= 32 ) {
		    token += dict.charAt( ( ( Math.random() * date ) + token.length + date ) % dict.length );
		}
		$.cookie( 'clicktracking-session', token, { 'path': '/' } );
	}
	/**
	 * Performs click tracking API call
	 * 
	 * @param {string} id event identifier
	 */
	$.trackAction = function( id ) {
		$.post(
			mw.config.get( 'wgScriptPath' ) + '/api.php', {
				'action': 'clicktracking',
				'format' : 'json',
				'namespacenumber': mw.config.get( 'wgNamespaceNumber' ),
				'eventid': id,
				'token': $.cookie( 'clicktracking-session' )
			}
		);
	};
	/**
	 * Performs click tracking API call
	 * 
	 * @param {string} id event identifier
	 * @param {string} info additional information to be stored with the click
	 */
	$.trackActionWithInfo = function( id, info ) {
		$.post(
			mw.config.get( 'wgScriptPath' ) + '/api.php', {
				'action': 'clicktracking',
				'format' : 'json',
				'eventid': id,
				'namespacenumber': mw.config.get( 'wgNamespaceNumber' ),
				'token': $.cookie( 'clicktracking-session' ),
				'additional': info
			}
		);
	};
	
	/**
	 * Rewrites a URL to one that runs through the ClickTracking API module
	 * which registers the event and redirects to the real URL
	 * @param {string} url URL to redirect to
	 * @param {string} id Event identifier
	 */
	$.trackActionURL = function( url, id ) {
		return mw.config.get( 'wgScriptPath' ) + '/api.php?' + $.param( {
			'action': 'clicktracking',
			'format' : 'json',
			'eventid': id,
			'namespacenumber': mw.config.get( 'wgNamespaceNumber' ),
			'token': $.cookie( 'clicktracking-session' ),
			'redirectto': url
		} );
	}

} )( jQuery );
