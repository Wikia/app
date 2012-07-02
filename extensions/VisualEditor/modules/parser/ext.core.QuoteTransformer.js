/*
 * MediaWiki-compatible italic/bold handling as a token stream transformation.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */

function QuoteTransformer ( dispatcher ) {
	this.reset();
	this.register( dispatcher );
}

// constants
QuoteTransformer.prototype.quoteAndNewlineRank = 2.1;
QuoteTransformer.prototype.anyRank = 2.101; // Just after regular quote and newline

QuoteTransformer.prototype.reset = function ( ) {
	// A chunk starts with a token context around a quote token and is
	// (optionally) followed by non-quote tokens. The quote token and its
	// context is later replaced with the actual tag token for italic or bold.
	this.currentChunk = [];
	// List of chunks, each starting with a (potentially) bold or italic token
	// and followed by plain tokens.
	this.chunks = [];
	// References to chunks in which the first token context / quote token
	// should be converted to italic or bold tokens.
	this.italics = [];
	this.bolds = [];

	this.isActive = false;
};


// Register this transformer with the TokenTransformer
QuoteTransformer.prototype.register = function ( dispatcher ) {
	this.dispatcher = dispatcher;
	// Register for NEWLINE and QUOTE tag tokens
	dispatcher.addTransform( this.onNewLine.bind(this), 
			this.quoteAndNewlineRank, 'newline' );
	dispatcher.addTransform( this.onQuote.bind(this), 
			this.quoteAndNewlineRank, 'tag', 'mw-quote' );
	// Treat end-of-input just the same as a newline
	dispatcher.addTransform( this.onNewLine.bind(this), 
			this.quoteAndNewlineRank, 'end' );
};

// Make a copy of the token context
QuoteTransformer.prototype._startNewChunk = function ( ) {
	this.chunks.push( this.currentChunk );
	this.currentChunk = [];
	this.currentChunk.pos = this.chunks.length - 1;
};

// Handle QUOTE tags. These are collected in italic/bold lists depending on
// the length of quote string. Actual analysis and conversion to the
// appropriate tag tokens is deferred until the next NEWLINE token triggers
// onNewLine.
QuoteTransformer.prototype.onQuote = function ( token, frame, prevToken ) {
	var qlen = token.value.length,
		tokens = [], // output tokens
		ctx = { 
			token: token, 
			frame: frame, 
			prevToken: prevToken
		},
		ctx2 = { 
			frame: frame, 
			prevToken: prevToken
		};
	

	if ( ! this.isActive ) {
		// register for any token if not yet active
		this.dispatcher.addTransform( this.onAny.bind(this), this.anyRank, 'any' );
		this.isActive = true;
	}

	this._startNewChunk();

	switch (qlen) {
		case 2: 
			this.currentChunk.push(ctx);
			this.italics.push(this.currentChunk);
			break;
		case 3: 
			this.currentChunk.push(ctx);
			this.bolds.push(this.currentChunk);
			break;
		case 4: 
			this.currentChunk.push( "'" );
			this._startNewChunk();
			this.currentChunk.push(ctx);
			this.bolds.push(this.currentChunk);
			break;
		case 5:
			// The order of italic vs. bold does not matter. Those are
			// processed in a fixed order, and any nesting issues are fixed up
			// by the HTML 5 tree builder. This does not always result in the
			// prettiest result, but at least it is always correct and very
			// convenient.
			this.currentChunk.push(ctx);
			this.italics.push(this.currentChunk); 
			this._startNewChunk();
			ctx2.token = { attribs: token.attribs };
			this.currentChunk.push(ctx2);
			this.bolds.push(this.currentChunk); 
			break;
		default: // longer than 5, only use the last 5 ticks
			var newvalue = token.value.substr(0, qlen - 5 );
			this.currentChunk.push ( newvalue );
			this._startNewChunk();
			this.currentChunk.push(ctx);
			this.italics.push(this.currentChunk); 
			this._startNewChunk();
			ctx2.token = { attribs: ctx.token.attribs };
			this.currentChunk.push(ctx2);
			this.bolds.push(this.currentChunk); 
			break;
	}
	
	return {};
};

QuoteTransformer.prototype.onAny = function ( token, frame, prevToken ) {
	//console.log('qt onAny: ' + JSON.stringify(token, null, 2));
	this.currentChunk.push( token );
	return {};
};

// Handle NEWLINE tokens, which trigger the actual quote analysis on the
// collected quote tokens so far.
QuoteTransformer.prototype.onNewLine = function (  token, frame, prevToken ) {
	var res;

	if( ! this.isActive ) {
		// Nothing to do, quick abort.
		return { token: token };
	}


	token.rank = this.quoteAndNewlineRank;

	//console.log('chunks: ' + JSON.stringify( this.chunks, null, 2 ) );

	//console.log("onNewLine: " + this.italics.length + 'i/b' + this.bolds.length);
	// balance out tokens, convert placeholders into tags
	if (this.italics.length % 2 && this.bolds.length % 2) {
		var firstsingleletterword = -1,
			firstmultiletterword = -1,
			firstspace = -1;
		for (var j = 0; j < this.bolds.length; j++) {
			var ctx = this.bolds[j][0];
			//console.log("balancing!" + JSON.stringify(ctx.prevToken, null, 2));
			if (ctx.prevToken) {
				if (ctx.prevToken.constructor === String) {
					var lastchar = prevToken[ctx.prevToken.length - 1],
						secondtolastchar = ctx.prevToken[ctx.prevToken.length - 2];
					if (lastchar === ' ' && firstspace === -1) {
						firstspace = j;
					} else if (lastchar !== ' ') {
						if ( secondtolastchar === ' ' && 
								firstsingleletterword === -1) 
						{
							firstsingleletterword = j;
						} else if ( firstmultiletterword == -1) {
							firstmultiletterword = j;
						}
					}
				} else if ( ( ctx.prevToken.constructor === NlTk ||
								ctx.prevToken.constructor === TagTk ) &&
								firstmultiletterword == -1 ) {
					// This is an approximation, as the original doQuotes
					// operates on the source and just looks at space vs.
					// non-space. At least some tags are thus recognized as
					// words in the original implementation.
					firstmultiletterword = j;
				}
			}
		}


		// now see if we can convert a bold to an italic and
		// an apostrophe
		if (firstsingleletterword > -1) {
			this.convertBold(firstsingleletterword);
		} else if (firstmultiletterword > -1) {
			this.convertBold(firstmultiletterword);
		} else if (firstspace > -1) {
			this.convertBold(firstspace);
		}
	}

	this.quotesToTags( this.italics, 'i' );
	this.quotesToTags( this.bolds, 'b' );

	this.currentChunk.push( token );
	this._startNewChunk();

	//console.log('chunks: ' + JSON.stringify( this.chunks, null, 2 ) );

	// return all collected tokens including the newline
	res = { tokens: [].concat.apply([], this.chunks) };

	// prepare for next line
	this.reset();

	// remove 'any' registration
	this.dispatcher.removeTransform( this.anyRank, 'any' );

	return res;
};

// Convert a bold token to italic to balance an uneven number of both bold and
// italic tags. In the process, one quote needs to be converted back to text.
QuoteTransformer.prototype.convertBold = function ( i ) {
	var chunk = this.bolds[i],
		textToken = "'";
	//console.log('convertbold!');
	if ( chunk.pos ) {
		this.chunks[chunk.pos - 1].push( textToken );
	} else {
		// prepend another chunk
		this.chunks.unshift( [ textToken ] );
	}

	// delete from bolds
	this.bolds.splice(i, 1);

	this.italics.push(chunk);
	this.italics.sort(function(a,b) { return a.pos - b.pos; } );
};

// Convert italics/bolds into tags
QuoteTransformer.prototype.quotesToTags = function ( chunks, name ) {
	var toggle = true,
		t,
		j,
		out = [];

	for (j = 0; j < chunks.length; j++) {
		//console.log( 'quotesToTags ' + name + ': ' + JSON.stringify( chunks, null, 2 ) );
		t = chunks[j][0].token;
		//console.log( 'quotesToTags t: ' + JSON.stringify( t, null, 2));

		if(toggle) {
			chunks[j][0] = new TagTk( name, t.attribs );
		} else {
			chunks[j][0] = new EndTagTk( name, t.attribs );
		}
		toggle = !toggle;
	}
	if (!toggle) {
		// Add end tag
		this.currentChunk.push( new EndTagTk( name ) );
	}
};

if (typeof module == "object") {
	module.exports.QuoteTransformer = QuoteTransformer;
}
