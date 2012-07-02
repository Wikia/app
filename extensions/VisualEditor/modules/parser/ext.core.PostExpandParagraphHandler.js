/*
 * Insert paragraphs for comment-only lines after template expansion
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */

// Include general utilities
var Util = require('./ext.Util.js').Util,
	u = new Util();


function PostExpandParagraphHandler ( dispatcher ) {
	this.tokens = [];
	this.newLines = 0;
	this.register( dispatcher );
}

// constants
PostExpandParagraphHandler.prototype.newlineRank = 2.2;
PostExpandParagraphHandler.prototype.anyRank = 2.201; // Just after regular quote and newline


// Register this transformer with the TokenTransformer
PostExpandParagraphHandler.prototype.register = function ( dispatcher ) {
	this.dispatcher = dispatcher;
	// Register for NEWLINE tokens
	dispatcher.addTransform( this.onNewLine.bind(this), 
			this.newlineRank, 'newline' );
	// Reset internal state when we are done
	dispatcher.addTransform( this.reset.bind(this), 
			this.newlineRank, 'end' );
};

PostExpandParagraphHandler.prototype.reset = function ( token, frame, cb ) {
	//console.log( 'PostExpandParagraphHandler.reset ' + JSON.stringify( this.tokens ) );
	if ( this.newLines ) {
		return { tokens: this._finish() };
	} else {
		return { token: token };
	}
};

PostExpandParagraphHandler.prototype._finish = function ( ) {
	var tokens = this.tokens;
	this.tokens = [];
	for ( var i = 0, l = tokens.length; i < l; i++ ) {
		tokens[ i ].rank = this.anyRank;
	}
	// remove 'any' registration
	this.dispatcher.removeTransform( this.anyRank, 'any' );
	this.newLines = 0;
	return tokens;
};


// Handle NEWLINE tokens, which trigger the actual quote analysis on the
// collected quote tokens so far.
PostExpandParagraphHandler.prototype.onNewLine = function (  token, frame, cb ) {
	//console.log( 'PostExpandParagraphHandler.onNewLine: ' + JSON.stringify( token, null , 2 ) );
	var res;
	this.tokens.push( token );

	if( ! this.newLines ) {
		this.dispatcher.addTransform( this.onAny.bind(this), 
				this.anyRank, 'any' );
	}

	this.newLines++;
	return {};
};


PostExpandParagraphHandler.prototype.onAny = function ( token, frame, cb ) {
	//console.log( 'PostExpandParagraphHandler.onAny' );
	this.tokens.push( token );
	if ( token.type === 'COMMENT' || 
			( token.constructor === String && token.match( /^[\t ]+$/ ) ) 
	)
	{
		// Continue with collection..
		return {};
	} else {
		// XXX: Only open paragraph if inline token follows!

		// None of the tokens we are interested in, so abort processing..
		//console.log( 'PostExpandParagraphHandler.onAny: ' + JSON.stringify( this.tokens, null , 2 ) );
		if ( this.newLines >= 2 && ! u.isBlockToken( token ) ) {
			return { tokens: [ new TagTk( 'p' ) ].concat( this._finish() ) };
		} else {
			return { tokens: this._finish() };
		}
	}

};

if (typeof module == "object") {
	module.exports.PostExpandParagraphHandler = PostExpandParagraphHandler;
}
