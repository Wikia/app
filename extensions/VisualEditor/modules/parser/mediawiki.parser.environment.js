var MWParserEnvironment = function(opts) {
	var options = {
		tagHooks: {},
		parserFunctions: {},
		pageCache: {}, // @fixme use something with managed space
		debug: false,
		trace: false,
		wgScriptPath: "http://en.wikipedia.org/w",
		wgScriptExtension: ".php",
		fetchTemplates: false,
		maxDepth: 40
	};
	$.extend(options, opts);
	$.extend(this, options);
};

// Outstanding page requests (for templates etc)
// Class-static
MWParserEnvironment.prototype.requestQueue = {};

MWParserEnvironment.prototype.lookupKV = function ( kvs, key ) {
	if ( ! kvs ) {
		return null;
	}
	var kv;
	for ( var i = 0, l = kvs.length; i < l; i++ ) {
		kv = kvs[i];
		if ( kv.k === key ) {
			// found, return it.
			return kv;
		}
	}
	// nothing found!
	return null;
};

MWParserEnvironment.prototype.KVtoHash = function ( kvs ) {
	if ( ! kvs ) {
		console.log( "Invalid kvs!: " + JSON.stringify( kvs, null, 2 ) );
		return {};
	}
	var res = {};
	for ( var i = 0, l = kvs.length; i < l; i++ ) {
		var kv = kvs[i],
			key = this.tokensToString( kv.k ).trim();
		if( res[key] === undefined ) {
			res[key] = kv.v;
		}
	}
	//console.log( 'KVtoHash: ' + JSON.stringify( res ));
	return res;
}

// Does this need separate UI/content inputs?
MWParserEnvironment.prototype.formatNum = function( num ) {
	return num + '';
};

MWParserEnvironment.prototype.getVariable = function( varname, options ) {
		//
};

/**
 * @return MWParserFunction
 */
MWParserEnvironment.prototype.getParserFunction = function( name ) {
	if (name in this.parserFunctions) {
		return new this.parserFunctions[name]( this );
	} else {
		return null;
	}
};

/**
 * @return MWParserTagHook
 */
MWParserEnvironment.prototype.getTagHook = function( name ) {
	if (name in this.tagHooks) {
		return new this.tagHooks[name](this);
	} else {
		return null;
	}
};

MWParserEnvironment.prototype.normalizeTitle = function( name ) {
	if (typeof name !== 'string') {
		throw new Error('nooooooooo not a string');
	}
	name = name.trim().replace(/[\s_]+/g, '_');
	function upperFirst( s ) { return s.substr(0, 1).toUpperCase() + s.substr(1); }
	name = name.split(':').map( upperFirst ).join(':');
	//if (name === '') {
	//	throw new Error('Invalid/empty title');
	//}
	return name;
};

/**
 * @fixme do this for real eh
 */
MWParserEnvironment.prototype.resolveTitle = function( name, namespace ) {
	// hack!
	if (name.indexOf(':') == -1 && typeof namespace ) {
		// hack hack hack
		name = namespace + ':' + this.normalizeTitle( name );
	}
	return name;
};

MWParserEnvironment.prototype.tokensToString = function ( tokens ) {
	var out = [];
	//console.log( 'MWParserEnvironment.tokensToString, tokens: ' + JSON.stringify( tokens ) );
	// XXX: quick hack, track down non-array sources later!
	if ( ! $.isArray( tokens ) ) {
		tokens = [ tokens ];
	}
	for ( var i = 0, l = tokens.length; i < l; i++ ) {
		var token = tokens[i];
		if ( token === undefined ) {
			console.trace();
			this.tp( 'MWParserEnvironment.tokensToString, invalid token: ' + 
							JSON.stringify( token ) +
							' tokens:' + JSON.stringify( tokens, null, 2 ));
			continue;
		}
		if ( token.constructor === String ) {
			out.push( token );
		} else if ( token.type === 'COMMENT' || token.type === 'NEWLINE' ) {
			// strip comments and newlines
		} else {
			var tstring = JSON.stringify( token );
			this.dp ( 'MWParserEnvironment.tokensToString, non-text token: ' + 
					tstring + JSON.stringify( tokens, null, 2 ) );
			//out.push( tstring );
		}
	}
	//console.log( 'MWParserEnvironment.tokensToString result: ' + out.join('') );
	return out.join('');
};


/**
 * Simple debug helper
 */
MWParserEnvironment.prototype.dp = function ( ) {
	if ( this.debug ) {
		if ( arguments.length > 1 ) {
			console.log( JSON.stringify( arguments, null, 2 ) );
		} else {
			console.log( arguments[0] );
		}
	}
};

/**
 * Simple debug helper, trace-only
 */
MWParserEnvironment.prototype.tp = function ( ) {
	if ( this.debug || this.trace ) {
		if ( arguments.length > 1 ) {
			console.log( JSON.stringify( arguments, null, 2 ) );
		} else {
			console.log( arguments[0] );
		}
	}
};


if (typeof module == "object") {
	module.exports.MWParserEnvironment = MWParserEnvironment;
}
