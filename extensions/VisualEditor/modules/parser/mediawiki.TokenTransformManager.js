/**
 * Token transformation managers with a (mostly) abstract
 * TokenTransformManager base class and AsyncTokenTransformManager and
 * SyncTokenTransformManager implementation subclasses. Individual
 * transformations register for the token types they are interested in and are
 * called on each matching token.
 *
 * Async token transformations are supported by the TokenAccumulator class,
 * that manages as-early-as-possible and in-order return of tokens including
 * buffering.
 *
 * See
 * https://www.mediawiki.org/wiki/Future/Parser_development/Token_stream_transformations
 * for more documentation.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */

var events = require('events');

/**
 * Base class for token transform managers
 *
 * @class
 * @constructor
 * @param {Function} callback, a callback function accepting a token list as
 * its only argument.
 */
function TokenTransformManager( ) {
	// Separate the constructor, so that we can call it from subclasses.
	this._construct();
}

// Inherit from EventEmitter
TokenTransformManager.prototype = new events.EventEmitter();
TokenTransformManager.prototype.constructor = TokenTransformManager;

TokenTransformManager.prototype._construct = function () {
	this.transformers = {
		tag: {}, // for TAG, ENDTAG, SELFCLOSINGTAG, keyed on name
		text: [],
		newline: [],
		comment: [],
		end: [], // eof
		martian: [], // none of the above (unknown token type)
		any: []	// all tokens, before more specific handlers are run
	};
};

/**
 * Register to a token source, normally the tokenizer.
 * The event emitter emits a 'chunk' event with a chunk of tokens,
 * and signals the end of tokens by triggering the 'end' event.
 * XXX: Perform registration directly in the constructor?
 *
 * @method
 * @param {Object} EventEmitter token even emitter.
 */
TokenTransformManager.prototype.listenForTokensFrom = function ( tokenEmitter ) {
	tokenEmitter.addListener('chunk', this.onChunk.bind( this ) );
	tokenEmitter.addListener('end', this.onEndEvent.bind( this ) );
};



/**
 * Map a rank to a phase.
 *
 * XXX: Might not be needed anymore, as phases are now subclassed and
 * registrations are separated.
 */
TokenTransformManager.prototype._rankToPhase  = function ( rank ) {
	if ( rank < 0 || rank > 3 ) {
		throw "TransformManager error: Invalid transformation rank " + rank;
	}
	if ( rank <= 2 ) {
		return 2;
	} else {
		return 3;
	}
};

/**
 * Add a transform registration.
 *
 * @method
 * @param {Function} transform.
 * @param {Number} rank, [0,3) with [0,1) in-order on input token stream,
 * [1,2) out-of-order and [2,3) in-order on output token stream
 * @param {String} type, one of 'tag', 'text', 'newline', 'comment', 'end',
 * 'martian' (unknown token), 'any' (any token, matched before other matches).
 * @param {String} tag name for tags, omitted for non-tags
 */
TokenTransformManager.prototype.addTransform = function ( transformation, rank, type, name ) {
	var transArr,
		transformer = { 
			transform: transformation,
			rank: rank
		};
	if ( type === 'tag' ) {
		name = name.toLowerCase();
		transArr = this.transformers.tag[name];
		if ( ! transArr ) {
			transArr = this.transformers.tag[name] = [];
		}
	} else {
		transArr = this.transformers[type];
	}
	transArr.push(transformer);
	// sort ascending by rank
	transArr.sort( this._cmpTransformations );
};

/**
 * Remove a transform registration
 *
 * @method
 * @param {Function} transform.
 * @param {Number} rank, [0,3) with [0,1) in-order on input token stream,
 * [1,2) out-of-order and [2,3) in-order on output token stream
 * @param {String} type, one of 'tag', 'text', 'newline', 'comment', 'end',
 * 'martian' (unknown token), 'any' (any token, matched before other matches).
 * @param {String} tag name for tags, omitted for non-tags
 */
TokenTransformManager.prototype.removeTransform = function ( rank, type, name ) {
	var i = -1,
		ts;

	function rankUnEqual ( i ) {
		return i.rank !== rank;
	}

	if ( type === 'tag' ) {
		name = name.toLowerCase();
		var maybeTransArr = this.transformers.tag.name;
		if ( maybeTransArr ) {
			this.transformers.tag.name = maybeTransArr.filter( rankUnEqual );
		}
	} else {
		this.transformers[type] = this.transformers[type].filter( rankUnEqual ) ;
	}
};

/**
 * Enforce separation between phases when token types or tag names have
 * changed, or when multiple tokens were returned. Processing will restart
 * with the new rank.
 *
 * XXX: This should also be moved to the subclass (actually partially implicit if
 * _transformTagToken and _transformToken are subclassed and set the rank when
 * fully processed). The token type change case still needs to be covered
 * though.
 */
TokenTransformManager.prototype._setTokenRank = function ( token ) {
};
TokenTransformManager.prototype._resetTokenRank = function ( res, transformer ) {
	if ( res.token ) {
		// reset rank after type or name change

		// Convert String literal to String object
		if ( res.token.constructor === String && res.token.rank === undefined ) {
			res.token = new String( res.token );
		}
		if ( transformer.rank < 1 ) {
			res.token.rank = 0;
		} else {
			res.token.rank = 1;
		}
	} else if ( res.tokens && transformer.rank > 2 ) {
		for ( var i = 0; i < res.tokens.length; i++ ) {
			var token = res.tokens[i];
			// convert string literal to string object
			if ( token.constructor === String && token.rank === undefined ) {
				res.tokens[i] = new String( token );
			}
			if ( res.tokens[i].rank === undefined ) {
				// Do not run phase 0 on newly created tokens from
				// phase 1.
				res.tokens[i].rank = 2;
			}
		}
	}
};

/**
 * Comparison for sorting transformations by ascending rank.
 */
TokenTransformManager.prototype._cmpTransformations = function ( a, b ) {
	return a.rank - b.rank;
};

/* Call all transformers on a tag.
 * XXX: Move to subclasses and use a different signature?
 *
 * @method
 * @param {Object} The current token.
 * @param {Function} Completion callback for async processing.
 * @param {Number} Rank of phase end, both key for transforms and rank for
 * processed tokens.
 * @returns {Object} Token(s) and async indication.
 */
TokenTransformManager.prototype._transformTagToken = function ( token, phaseEndRank, cbOrPrevToken ) {
	// prepend 'any' transformers
	var ts = this.transformers.any,
		res = { token: token },
		transform,
		l, i,
		aborted = false,
		tName = token.name.toLowerCase(),
		tagts = this.transformers.tag[tName];

	if ( tagts && tagts.length ) {
		// could cache this per tag type to avoid re-sorting each time
		ts = ts.concat(tagts);
		ts.sort( this._cmpTransformations );
	}
	//console.log(JSON.stringify(ts, null, 2));
	if ( ts ) {
		for ( i = 0, l = ts.length; i < l; i++ ) {
			transformer = ts[i];
			if ( res.token.rank && transformer.rank < res.token.rank ) {
				//console.log( 'SKIPPING' + JSON.stringify( token, null, 2 ) + 
				//		'\ntransform:\n' + JSON.stringify( transformer, null, 2 ) );
				// skip transformation, was already applied.
				continue;
			}
			// Transform token with side effects
			res = transformer.transform( res.token, this, cbOrPrevToken );
			// XXX: Sync transform:
			// res = transformer.transform( res.token, this, this.prevToken );
			// XXX: Async transform:
			// res = transformer.transform( res.token, this, cb );

			// if multiple tokens or null token: process returned tokens (in parent)
			if ( !res.token ||  // async implies tokens instead of token, so no
								// need to check explicitly
					res.token.type !== token.type || 
					res.token.name !== token.name ) {
				this._resetTokenRank ( res, transformer );
				aborted = true;
				break;
			}
			// track progress on token
			if ( res.token.rank === undefined && res.token.constructor === String ) {
				res.token = new String ( res.token );
			}
			res.token.rank = transformer.rank;
		}
		if ( ! aborted ) {
			// Mark token as fully processed.
			if ( res.token.rank === undefined && res.token.constructor === String ) {
				res.token = new String ( res.token );
			}
			res.token.rank = phaseEndRank;
		}
	}
	return res;
};


/* Call all transformers on non-tag token types.
 * XXX: different signature for sync vs. async, move to subclass?
 *
 * @method
 * @param {Object} The current token.
 * @param {Function} Completion callback for async processing.
 * @param {Number} Rank of phase end, both key for transforms and rank for
 * processed tokens.
 * @param {Array} ts List of token transformers for this token type.
 * @returns {Object} Token(s) and async indication.
 */
TokenTransformManager.prototype._transformToken = function ( token, phaseEndRank, ts, cbOrPrevToken ) {
	// prepend 'any' transformers
	var anyTrans = this.transformers.any;
	if ( anyTrans.length ) {
		ts = this.transformers.any.concat(ts);
		ts.sort( this._cmpTransformations );
	}
	var transformer,
		res = { token: token },
		aborted = false;
	if ( ts ) {
		for (var i = 0, l = ts.length; i < l; i++ ) {
			transformer = ts[i];
			if ( res.token.rank && transformer.rank <= res.token.rank ) {
				// skip transformation, was already applied.
				continue;
			}
			// Transform the token.
			// XXX: consider moving the rank out of the token itself to avoid
			// transformations messing with it in broken ways. Not sure if
			// some transformations need to manipulate it though. gwicke
			res = transformer.transform( res.token, this, cbOrPrevToken );
			if ( !res.token ||
					res.token.type !== token.type ) {
				this._resetTokenRank ( res, transformer );
				aborted = true;
				break;
			}
			if ( res.token.rank === undefined && res.token.constructor === String ) {
				res.token = new String ( res.token );
			}
			res.token.rank = transformer.rank;
		}
		if ( ! aborted ) {
			// mark token as completely processed
			if ( res.token.rank === undefined && res.token.constructor === String ) {
				res.token = new String ( res.token );
			}
			res.token.rank = phaseEndRank; // need phase passed in!
		}

	}
	return res;
};



/******************** Async token transforms: Phase 2 **********************/

/**
 * Asynchronous and potentially out-of-order token transformations, used in phase 2.
 *
 * return protocol for individual transforms:
 *		{ tokens: [tokens], async: true }: async expansion -> outstanding++ in parent
 *		{ tokens: [tokens] }: fully expanded, tokens will be reprocessed
 *		{ token: token }: single-token return
 * 
 * @class
 * @constructor
 * @param {Function} childFactory: A function that can be used to create a
 * new, nested transform manager:
 * nestedAsyncTokenTransformManager = manager.newChildPipeline( inputType, args );
 * @param {Object} args, the argument map for templates
 * @param {Object} env, the environment.
 */
function AsyncTokenTransformManager ( childFactories, args, env ) {
	// Factory function for new AsyncTokenTransformManager creation with
	// default transforms enabled
	// Also sets up a tokenizer and phase-1-transform depending on the input format
	// nestedAsyncTokenTransformManager = manager.newChildPipeline( inputType, args );
	this.childFactories = childFactories;
	this._construct();
	this._reset( args, env );
	// FIXME: pass actual title?
	this.loopAndDepthCheck = new LoopAndDepthCheck( null );
}

// Inherit from TokenTransformManager, and thus also from EventEmitter.
AsyncTokenTransformManager.prototype = new TokenTransformManager();
AsyncTokenTransformManager.prototype.constructor = AsyncTokenTransformManager;

/**
 * Create a new child pipeline.
 *
 * @method
 * @param {String} Input type, currently only support 'text/wiki'.
 * @param {Object} Template arguments
 * @returns {Object} Pipeline, which is an object with 'first' pointing to the
 * first stage of the pipeline, and 'last' pointing to the last stage.
 */
AsyncTokenTransformManager.prototype.newChildPipeline = function ( inputType, args, title ) {
	//console.log( 'newChildPipeline: ' + JSON.stringify( args ) );
	var pipe = this.childFactories.input( inputType, args );

	// now set up a few things on the child AsyncTokenTransformManager.
	var child = pipe.last;
	// We assume that the title was already checked against this.loopAndDepthCheck
	// before!
	child.loopAndDepthCheck = new LoopAndDepthCheck ( 
				this.loopAndDepthCheck,
				this.env.normalizeTitle( this.env.tokensToString ( title ) )
			);
	child.title = title;
	return pipe;
};

/**
 * Create a pipeline for attribute transformations.
 *
 * @method
 * @param {String} Input type, currently only support 'text/wiki'.
 * @param {Object} Template arguments
 * @returns {Object} Pipeline, which is an object with 'first' pointing to the
 * first stage of the pipeline, and 'last' pointing to the last stage.
 */
AsyncTokenTransformManager.prototype.getAttributePipeline = function ( inputType, args ) {
	var pipe = this.childFactories.attributes( inputType, args );
	var child = pipe.last;
	child.title = this.title;
	child.loopAndDepthCheck = new LoopAndDepthCheck ( this.loopAndDepthCheck, '' );
	return pipe;
};

/**
 * Reset the internal token and outstanding-callback state of the
 * TokenTransformManager, but keep registrations untouched.
 *
 * @method
 * @param {Object} args, template arguments
 * @param {Object} The environment.
 */
AsyncTokenTransformManager.prototype._reset = function ( args, env ) {
	// Note: Much of this is frame-like.
	this.tailAccumulator = undefined;
	// eventize: bend to event emitter callback
	this.tokenCB = this._returnTokens.bind( this );
	this.prevToken = undefined;
	//console.log( 'AsyncTokenTransformManager args ' + JSON.stringify( args ) );
	if ( ! args ) {
		this.args = {}; // no arguments at the top level
	} else {
		this.args = args;
	}
	if ( ! env ) {
		if ( !this.env ) {
			throw "AsyncTokenTransformManager: environment needed!" + env;
		}
	} else {
		this.env = env;
	}
};

/**
 * Simplified wrapper that processes all tokens passed in
 */
AsyncTokenTransformManager.prototype.process = function ( tokens ) {
	if ( ! $.isArray ( tokens ) ) {
		tokens = [tokens];
	}
	this.onChunk( tokens );
	this.onEndEvent();
};

/**
 * Transform and expand tokens. Transformed token chunks will be emitted in
 * the 'chunk' event.
 * 
 * @method
 * @param {Array} chunk of tokens
 */
AsyncTokenTransformManager.prototype.onChunk = function ( tokens ) {
	// Set top-level callback to next transform phase
	var res = this.transformTokens ( tokens, this.tokenCB );
	this.env.dp('AsyncTokenTransformManager onChunk res.async=' + res.async +
			' tokens=' + JSON.stringify( tokens ) );

	if ( ! this.tailAccumulator ) {
		this.emit( 'chunk', res.tokens );
	} else {
		this.tailAccumulator.append( res.tokens );
	}
	
	if ( res.async ) {
		this.tailAccumulator = res.async;
		this.tokenCB = res.async.getParentCB ( 'sibling' );
	}
	//this.phase2TailCB( tokens, true );

	// The next processed chunk should call back as a sibling to last
	// accumulator, if any.
	if ( res.async ) {
	}
};

/**
 * Run transformations from phases 0 and 1. This includes starting and
 * managing asynchronous transformations.
 *
 */
AsyncTokenTransformManager.prototype.transformTokens = function ( tokens, parentCB ) {

	//console.log('AsyncTokenTransformManager.transformTokens: ' + JSON.stringify(tokens) );
	
	var res,
		phaseEndRank = 2, // XXX: parametrize!
		// Prepare a new accumulator, to be used by async children (if any)
		localAccum = [],
		accum = new TokenAccumulator( this, parentCB ),
		cb = accum.getParentCB( 'child' ),
		activeAccum = null,
		tokensLength = tokens.length,
		token,
		ts = this.transformers;


	for ( var i = 0; i < tokensLength; i++ ) {
		token = tokens[i];
		
		if ( token.attribs ) {
			// TODO: Transform token attributes (that need it) before general token processing.
			//   Sync return -> continue as-is.
			//   Async return -> return with async
			//   per-item callback: function ( res ) { 
			var atm = new AttributeTransformManager ( 
							this, 
							this._returnAttributes.bind( this, token, cb ) 
						);

			if ( atm.process( token.attribs ) ) {
				// async attribute expansion ongoing
				activeAccum = accum;
				accum = new TokenAccumulator( this, activeAccum.getParentCB( 'sibling' ) );
				cb = accum.getParentCB( 'child' );
				// Only transform token once attributes are fully processed
				// _returnAttributes will call transformTokens if sync flag is not set
				continue;
			}
		}

		switch ( token.constructor ) {
			case String:
				res = this._transformToken( token, phaseEndRank, ts.text, cb );
				break;
			case NlTk:
				res = this._transformToken( token, phaseEndRank, ts.newline, cb );
				break;
			case TagTk:
			case EndTagTk:
			case SelfclosingTagTk:
				res = this._transformTagToken( token, phaseEndRank, cb );
				break;
			default:
				switch( token.type ) {
					case 'COMMENT':
						res = this._transformToken( token, phaseEndRank, ts.comment, cb );
						break;
					case 'END':
						res = this._transformToken( token, phaseEndRank, ts.end, cb );
						break;
					default:
						res = this._transformToken( token, phaseEndRank, ts.martian, cb );
						break;
				}
				break;
		}

		if( res.tokens ) {
			// Splice in the returned tokens (while replacing the original
			// token), and process them next.
			[].splice.apply( tokens, [i, 1].concat(res.tokens) );
			tokensLength = tokens.length;
			i--; // continue at first inserted token
		} else if ( res.token ) {
			if ( res.token.rank === 2 ) {
				// token is done.
				if ( activeAccum ) {
					// push to accumulator
					activeAccum.push( res.token );
				} else {
					// If there is no accumulator yet, then directly return the
					// token to the parent. Collect them in localAccum for this
					// purpose.
					localAccum.push( res.token );
				}
			} else {
				// re-process token.
				tokens[i] = res.token;
				i--;
			}
		} else if ( res.async ) {
			//console.log( 'tokens returned' );
			// The child now switched to activeAccum, we have to create a new
			// accumulator for the next potential child.
			activeAccum = accum;
			accum = new TokenAccumulator( this, activeAccum.getParentCB( 'sibling' ) );
			cb = accum.getParentCB( 'child' );
		}


	}

	// Return finished tokens directly to caller, and indicate if further
	// async actions are outstanding. The caller needs to point a sibling to
	// the returned accumulator, or call .siblingDone() to mark the end of a
	// chain.
	return { tokens: localAccum, async: activeAccum };
};

/**
 * Callback from tokens fully processed for phase 0 and 1, which are now ready
 * for synchronous and globally in-order phase 2 processing.
 *
 * @method
 * @param {Array} chunk of tokens
 * @param {Mixed} Either a falsy value if this is the last callback
 * (everything is done), or a truish value if not yet done.
 */
AsyncTokenTransformManager.prototype._returnTokens = function ( tokens, notYetDone ) {
	//tokens = this._transformPhase2( this.frame, tokens, this.parentCB );
	
	//if ( tokens.length && tokens[tokens.length - 1].type === 'END' ) {
	//	this.env.dp( 'AsyncTokenTransformManager, stripping end ' );
	//	tokens.pop();
	//}

	this.env.dp('AsyncTokenTransformManager._returnTokens, emitting chunk: ' +
			JSON.stringify( tokens ) );

	this.emit( 'chunk', tokens );

	if ( ! notYetDone ) {
		//console.log('AsyncTokenTransformManager._returnTokens done. tokens:' + 
		//		JSON.stringify( tokens, null, 2 ) + ', listeners: ' +
		//		JSON.stringify( this.listeners( 'chunk' ), null, 2 ) );
		// signal our done-ness to consumers.
		//if ( this.atTopLevel ) {
		//	this.emit( 'chunk', [{type: 'END'}]);
		//}
		this.emit( 'end' );
		// and reset internal state.
		this._reset();
	}
};

AsyncTokenTransformManager.prototype._returnAttributes 
	= function ( token, cb, attributes, async ) 
{
	this.env.dp( 'AsyncTokenTransformManager._returnAttributes: ' + 
			JSON.stringify( token, null, 2 ) +
			JSON.stringify( attributes, null, 2 ) );
	token.attribs = attributes;
	

	if ( async ) {
		// Attributes were expanded asynchronously, so now we still need to
		// process the token.
		var res = this.transformTokens( [token], cb );
		if ( res.async ) {
			// Token transformation is again asynchronous. There is already a
			// TokenAccumulator associated with this token, so we only need to
			// be concerned with synchronously returned tokens.
			if ( res.tokens ) {
				// Pass on already-returned tokens to the cb
				cb( res.tokens, true );
			}
		} else if ( res.token ) {
			cb ( [res.token], false );
		} else {
			cb ( res.tokens, false );
		}
	}
};


/**
 * Callback for the end event emitted from the tokenizer.
 * Either signals the end of input to the tail of an ongoing asynchronous
 * processing pipeline, or directly emits 'end' if the processing was fully
 * synchronous.
 */
AsyncTokenTransformManager.prototype.onEndEvent = function () {
	if ( this.tailAccumulator ) {
		this.env.dp( 'AsyncTokenTransformManager.onEndEvent: calling siblingDone',
				this.loopAndDepthCheck );
		this.tailAccumulator.siblingDone();
	} else {
		// nothing was asynchronous, so we'll have to emit end here.
		this.env.dp( 'AsyncTokenTransformManager.onEndEvent: synchronous done',
				this.loopAndDepthCheck  );
		this.emit('end');
		this._reset();
	}
};






/*************** In-order, synchronous transformer (phase 1 and 3) ***************/

/**
 * Subclass for phase 3, in-order and synchronous processing.
 *
 * @class
 * @constructor
 * @param {Object} environment.
 */
function SyncTokenTransformManager ( env, phaseEndRank ) {
	// both inherited
	this._construct();
	this.phaseEndRank = phaseEndRank;
	this.args = {}; // no arguments at the top level
	this.env = env;
}

// Inherit from TokenTransformManager, and thus also from EventEmitter.
SyncTokenTransformManager.prototype = new TokenTransformManager();
SyncTokenTransformManager.prototype.constructor = SyncTokenTransformManager;


SyncTokenTransformManager.prototype.process = function ( tokens ) {
	if ( ! $.isArray ( tokens ) ) {
		tokens = [tokens];
	}
	this.onChunk( tokens );
	this.onEndEvent();
};


/**
 * Global in-order and synchronous traversal on token stream. Emits
 * transformed chunks of tokens in the 'chunk' event.
 *
 * @method
 * @param {Array} Token chunk.
 */
SyncTokenTransformManager.prototype.onChunk = function ( tokens ) {
	this.env.dp('SyncTokenTransformManager.onChunk, input: ' +
			JSON.stringify( tokens, null, 2 ) );
	var res,
		localAccum = [],
		localAccumLength = 0,
		tokensLength = tokens.length,
		cb, // XXX: not meaningful for purely synchronous processing!
		token,
		// Top-level frame only in phase 3, as everything is already expanded.
		ts = this.transformers;

	for ( var i = 0; i < tokensLength; i++ ) {
		token = tokens[i];
		
		switch( token.constructor ) {
			case String:
				res = this._transformToken( token, this.phaseEndRank, 
							ts.text, this.prevToken );
				break;
			case NlTk:
				res = this._transformToken( token, this.phaseEndRank, ts.newline, this.prevToken );
				break;
			case TagTk:
			case EndTagTk:
			case SelfclosingTagTk:
				res = this._transformTagToken( token, this.phaseEndRank, this.prevToken );
				break;
			default:
				switch( token.type ) {
					case 'COMMENT':
						res = this._transformToken( token, this.phaseEndRank, ts.comment, this.prevToken );
						break;
					case 'END':
						res = this._transformToken( token, this.phaseEndRank, ts.end, this.prevToken );
						break;
					default:
						res = this._transformToken( token, this.phaseEndRank, ts.martian, this.prevToken );
						break;
				}
		}

		if( res.tokens ) {
			// Splice in the returned tokens (while replacing the original
			// token), and process them next.
			[].splice.apply( tokens, [i, 1].concat(res.tokens) );
			tokensLength = tokens.length;
			i--; // continue at first inserted token
		} else if ( res.token ) {
			if ( res.token.rank === this.phaseEndRank ) {
				// token is done.
				localAccum.push(res.token);
				this.prevToken = res.token;
			} else {
				// re-process token.
				tokens[i] = res.token;
				i--;
			}
		}
	}
	this.env.dp( 'SyncTokenTransformManager.onChunk: emitting ' + 
			JSON.stringify( localAccum, null, 2 ) );
	this.emit( 'chunk', localAccum );
};

/**
 * Callback for the end event emitted from the tokenizer.
 * Either signals the end of input to the tail of an ongoing asynchronous
 * processing pipeline, or directly emits 'end' if the processing was fully
 * synchronous.
 */
SyncTokenTransformManager.prototype.onEndEvent = function () {
	// This phase is fully synchronous, so just pass the end along and prepare
	// for the next round.
	this.emit('end');
};


/********************** AttributeTransformManager *************************/

/**
 * Utility transformation manager for attributes, using an attribute
 * transformation pipeline (normally phase1 SyncTokenTransformManager and
 * phase2 AsyncTokenTransformManager). This pipeline needs to be independent
 * of the containing TokenTransformManager to isolate transforms from each
 * other. The AttributeTransformManager returns its result by calling the
 * supplied callback.
 *
 * @class
 * @constructor
 * @param {Object} Containing TokenTransformManager
 */
function AttributeTransformManager ( manager, callback ) {
	this.manager = manager;
	this.callback = callback;
	this.outstanding = 1;
	this.kvs = [];
	//this.pipe = manager.getAttributePipeline( manager.args );
}

AttributeTransformManager.prototype.process = function ( attributes ) {
	// Potentially need to use multiple pipelines to support concurrent async expansion
	//this.pipe.process( 
	var pipe,
		ref;
	//console.log( 'AttributeTransformManager.process: ' + JSON.stringify( attributes ) );

	// transform each argument (key and value), and handle asynchronous returns
	for ( var i = 0, l = attributes.length; i < l; i++ ) {
		var kv = { key: [], value: [] };
		this.kvs.push( kv );
		var cur = attributes[i];

		if ( cur.k.constructor !== String ) {
			// Assume that the return is async, will be decremented in callback
			this.outstanding++;

			// transform the key
			pipe = this.manager.getAttributePipeline( this.manager.args );
			pipe.addListener( 'chunk', 
					this.onChunk.bind( this, this._returnAttributeKey.bind( this, i ) ) 
					);
			pipe.addListener( 'end', 
					this.onEnd.bind( this, this._returnAttributeKey.bind( this, i ) ) 
					);
			pipe.process( attributes[i].k.concat([{type:'END'}]) );
		} else {
			kv.key = cur.k;
		}

		if ( cur.v.constructor !== String ) {
			// Assume that the return is async, will be decremented in callback
			this.outstanding++;

			// transform the value
			pipe = this.manager.getAttributePipeline( this.manager.args );
			pipe.addListener( 'chunk', 
					this.onChunk.bind( this, this._returnAttributeValue.bind( this, i ) ) 
					);
			pipe.addListener( 'end', 
					this.onEnd.bind( this, this._returnAttributeValue.bind( this, i ) ) 
					);
			//console.log('starting attribute transform of ' + JSON.stringify( attributes[i].v ) );
			pipe.process( cur.v.concat([{type:'END'}]) );
		} else {
			kv.value = cur.v;
		}
	}
	this.outstanding--;
	if ( this.outstanding === 0 ) {
		this._returnAttributes();
		// synchronous / done
		return false;
	} else {
		// async, will call back
		this.async = true;
		return true;
	}
};

AttributeTransformManager.prototype._returnAttributes = function ( ) {
	// convert attributes
	var out = [];
	for ( var i = 0, l = this.kvs.length; i < l; i++ ) {
		var kv = this.kvs[i];
		out.push( new KV(kv.key, kv.value) );
	}

	// and call the callback with the result
	//console.log('AttributeTransformManager._returnAttributes: ' + out );
	this.callback( out, this.async );
};

/**
 * Collect chunks returned from the pipeline
 */
AttributeTransformManager.prototype.onChunk = function ( cb, chunk ) {
	if ( chunk.length && chunk[chunk.length - 1].type === 'END' ) {
		chunk.pop();
	}
	cb( chunk, true );
};

/**
 * Empty the pipeline by returning to the parent
 */
AttributeTransformManager.prototype.onEnd = function ( cb ) {
	cb( [], false );
};


/**
 * Callback for async argument value expansions
 */
AttributeTransformManager.prototype._returnAttributeValue = function ( ref, tokens, notYetDone ) {
	//console.log( 'check _returnAttributeValue: ' + JSON.stringify( tokens ) + 
	//		' notYetDone:' + notYetDone );
	this.kvs[ref].value = this.kvs[ref].value.concat( tokens );
	if ( ! notYetDone ) {
		this.outstanding--;
		if ( this.outstanding === 0 ) {
			// this calls back to frame.cb, so no return here.
			this._returnAttributes();
		}
	}
};

/**
 * Callback for async argument key expansions
 */
AttributeTransformManager.prototype._returnAttributeKey = function ( ref, tokens, notYetDone ) {
	//console.log( 'check _returnAttributeKey: ' + JSON.stringify( tokens ) + 
	//		' notYetDone:' + notYetDone );
	this.kvs[ref].key = this.kvs[ref].key.concat( tokens );
	if ( ! notYetDone ) {
		this.outstanding--;
		if ( this.outstanding === 0 ) {
			// this calls back to frame.cb, so no return here.
			this._returnAttributes();
		}
	}
};


/******************************* TokenAccumulator *************************/
/**
 * Token accumulators buffer tokens between asynchronous processing points,
 * and return fully processed token chunks in-order and as soon as possible. 
 * They support the AsyncTokenTransformManager.
 *
 * @class
 * @constructor
 * @param {Object} next TokenAccumulator to link to
 * @param {Array} (optional) tokens, init accumulator with tokens or []
 */
function TokenAccumulator ( manager, parentCB ) {
	this.manager = manager;
	this.parentCB = parentCB;
	this.accum = [];
	// Wait for child and sibling by default
	// Note: Need to decrement outstanding on last accum
	// in a chain.
	this.outstanding = 2; 
}

/**
 * Curry a parentCB with the object and reference.
 *
 * @method
 * @param {Object} TokenAccumulator
 * @param {misc} Reference / key for callback
 * @returns {Function}
 */
TokenAccumulator.prototype.getParentCB = function ( reference ) {
	return this._returnTokens.bind( this, reference );
};

/**
 * Pass tokens to an accumulator
 *
 * @method
 * @param {Object} token
 */
TokenAccumulator.prototype._returnTokens = function ( reference, tokens, notYetDone ) {
	var res,
		cb,
		returnTokens = [];

	if ( ! notYetDone ) {
		this.outstanding--;
	}

	//console.log( 'TokenAccumulator._returnTokens' );
	if ( reference === 'child' ) {
		tokens = tokens.concat( this.accum );
		this.manager.env.dp('TokenAccumulator._returnTokens child: ' + 
				JSON.stringify( tokens, null, 2 ) + 
				' outstanding: ' + this.outstanding
				);
		this.accum = [];
		this.parentCB( tokens, this.outstanding );
		return null;
	} else {
		// sibling
		if ( this.outstanding === 0 ) {
			tokens = this.accum.concat( tokens );
			// A sibling will transform tokens, so we don't have to do this
			// again.
			this.manager.env.dp( 'TokenAccumulator._returnTokens: ' +
					'sibling done and parentCB ' +
					JSON.stringify( tokens ) );
			this.parentCB( tokens, false );
			return null;
		} else if ( this.outstanding === 1 && notYetDone ) {
			this.manager.env.dp( 'TokenAccumulator._returnTokens: ' +
					'sibling done and parentCB but notYetDone ' +
					JSON.stringify( tokens ) );
			// Sibling is not yet done, but child is. Return own parentCB to
			// allow the sibling to go direct, and call back parent with
			// tokens. The internal accumulator is empty at this stage, as its
			// tokens are passed to the parent when the child is done.
			return this.parentCB( tokens, true);
		} else {
			this.accum  = this.accum.concat( tokens );
			this.manager.env.dp( 'TokenAccumulator._returnTokens: sibling done, but not overall. notYetDone=' + 
					notYetDone + ', this.outstanding=' + this.outstanding +
					', this.accum=' + 
					JSON.stringify( this.accum, null, 2 ) +
					' manager.title=', this.manager.title );
		}


	}
};

/**
 * Mark the sibling as done (normally at the tail of a chain).
 */
TokenAccumulator.prototype.siblingDone = function () {
	//console.log( 'TokenAccumulator.siblingDone: ' );
	this._returnTokens ( 'sibling', [], false );
};


/**
 * Push a token into the accumulator
 *
 * @method
 * @param {Object} token
 */
TokenAccumulator.prototype.push = function ( token ) {
	return this.accum.push(token);
};

/**
 * Append tokens to an accumulator
 *
 * @method
 * @param {Object} token
 */
TokenAccumulator.prototype.append = function ( token ) {
	this.accum = this.accum.concat( token );
};


/**
 * Loop check helper class for AsyncTokenTransformManager.
 *
 * We use a bottom-up linked list to allow sharing of paths between async
 * expansions.
 *
 * @class
 * @constructor
 */
function LoopAndDepthCheck ( parent, title ) {
	if ( parent ) {
		this.depth = parent.depth + 1;
		this.parent = parent;
	} else {
		this.depth = 0;
		this.parent = null;
	}
	this.title = title;
}

/**
 * Check if expanding <title> would lead to a loop.
 *
 * @method
 * @param {String} Title to check.
 */
LoopAndDepthCheck.prototype.check = function ( title, maxDepth ) {
	// XXX: set limit really low for testing!
	if ( this.depth > maxDepth ) {
		// too deep
		//console.log( 'Loopcheck: ' + JSON.stringify( this, null, 2 ) );
		return 'Error: Expansion depth limit exceeded at ';
	}
	var elem = this;
	do {
		//console.log( 'loop check: ' + title + ' vs ' + elem.title );
		if ( elem.title === title ) {
			// Loop detected
			return 'Error: Expansion loop detected at ';
		}
		elem = elem.parent;
	} while ( elem );
	// No loop detected.
	return false;
};

if (typeof module == "object") {
	module.exports.AsyncTokenTransformManager = AsyncTokenTransformManager;
	module.exports.SyncTokenTransformManager = SyncTokenTransformManager;
	module.exports.AttributeTransformManager = AttributeTransformManager;
}
