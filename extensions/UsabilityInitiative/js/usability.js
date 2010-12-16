/**
 * Common version-independent functions
 */

if ( typeof mw == 'undefined' ) {
	mw = {};
}

mw.usability = {
	messages: {}
}

/**
 * This may eventually load something instead of just calling the callback.
 */
mw.usability.load = function( deps, callback ) {
	callback();
};

/**
 * Add messages to a local message table
 */
mw.usability.addMessages = function( messages ) {
	for ( var key in messages ) {
		this.messages[key] = messages[key];
	}
};

/**
 * Get a message
 */
mw.usability.getMsg = function( key, args ) {
	if ( !( key in this.messages ) ) {
		return '[' + key + ']';
	}
	var msg = this.messages[key];
	if ( typeof args == 'object' || typeof args == 'array' ) {
		for ( var argKey in args ) {
			msg = msg.replace( '\$' + (parseInt( argKey ) + 1), args[argKey] );
		}
	} else if ( typeof args == 'string' || typeof args == 'number' ) {
		msg = msg.replace( '$1', args );
	}
	return msg;
};
