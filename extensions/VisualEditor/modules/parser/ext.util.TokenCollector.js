/**
 * Small utility class that encapsulates the common 'collect all tokens
 * starting from a token of type x until token of type y or (optionally) the
 * end-of-input'. Only supported for synchronous in-order transformation
 * stages (SyncTokenTransformManager), as async out-of-order expansions
 * would wreak havoc with this kind of collector.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 *
 * Calls the passed-in callback with the collected tokens.
 *
 * @class
 * @constructor
 * @param {Object} SyncTokenTransformManager to register with
 * @param {Function} Transform function, called like this:
 *   transform( tokens, cb, manager ) with 
 *      tokens: chunk of tokens
 *      cb: function, returnTokens ( tokens, notYetDone ) with notYetDone
 *      indicating the last chunk of an async return.
 *      manager: TokenTransformManager, provides the args etc.
 * @param {Boolean} Match the 'end' tokens as closing tag as well (accept
 * unclosed sections).
 * @param {Nummber} Numerical rank of the tranform
 * @param {String} Token type to register for ('tag', 'text' etc)
 * @param {String} (optional, only for token type 'tag'): tag name.
 */

function TokenCollector ( manager, transformation, toEnd, rank, type, name ) {
	this.transformation = transformation;
	this.manager = manager;
	this.rank = rank;
	this.type = type;
	this.name = name;
	this.toEnd = toEnd;
	this.tokens = [];
	this.isActive = false;
	manager.addTransform( this._onDelimiterToken.bind( this ), rank, type, name );
	manager.addTransform( this._onDelimiterToken.bind( this ), rank, 'end' );
}
		
/**
 * Register any collector with slightly lower priority than the start/end token type
 * XXX: This feels a bit hackish, a list-of-registrations per rank might be
 * better.
 */
TokenCollector.prototype._anyDelta = 0.00001;


/**
 * Handle the delimiter token.
 * XXX: Adjust to sync phase callback when that is modified!
 */
TokenCollector.prototype._onDelimiterToken = function ( token, frame, cb ) {
	var res;
	if ( this.isActive ) {
		// finish processing
		this.tokens.push ( token );
		this.isActive = false;
		this.manager.removeTransform( this.rank + this._anyDelta, 'any' );
		if ( token.type !== 'END' || this.toEnd ) {
			// end token
			res = this.transformation ( this.tokens, this.cb, this.manager );
			this.tokens = [];
			// Transformation can be either sync or async, but receives all collected
			// tokens instead of a single token.
			return res;
			// XXX sync version: return tokens
		} else {
			// just return collected tokens
			res = this.tokens;
			this.tokens = [];
			return { tokens: res };
		}
	} else if ( token.type !== 'END' ) {
		this.manager.env.dp( 'starting collection on ', token );
		// start collection
		this.tokens.push ( token );
		this.manager.addTransform( this._onAnyToken.bind ( this ), 
				this.rank + this._anyDelta, 'any' );
		// Did not encounter a matching end token before the end, and are not
		// supposed to collect to the end. So just return the tokens verbatim.
		this.isActive = true;
		return { };
	} else {
		// pass through end token
		return { token: token };
	}
};


/**
 * Handle 'any' token in between delimiter tokens. Activated when
 * encountering the delimiter token, and collects all tokens until the end
 * token is reached.
 */
TokenCollector.prototype._onAnyToken = function ( token, frame, cb ) {
	// Simply collect anything ordinary in between
	this.tokens.push( token );
	return { };
};


if (typeof module == "object") {
	module.exports.TokenCollector = TokenCollector;
}
