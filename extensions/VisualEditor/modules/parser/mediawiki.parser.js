/**
 *
 * Simple parser class. Should have lots of options for observing parse stages (or, use events).
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
 */

// make this global for now
// XXX: figure out a way to get away without a global for PEG actions!
$ = require('jquery');
var events = require( 'events' );

var fs = require('fs'),
	path = require('path'),
	PegTokenizer                = require('./mediawiki.tokenizer.peg.js').PegTokenizer,
	TokenTransformManager       = require('./mediawiki.TokenTransformManager.js'),

	NoIncludeOnly				= require('./ext.core.NoIncludeOnly.js'),
	IncludeOnly					= NoIncludeOnly.IncludeOnly,
	NoInclude					= NoIncludeOnly.NoInclude,
	QuoteTransformer            = require('./ext.core.QuoteTransformer.js').QuoteTransformer,
	PostExpandParagraphHandler  = require('./ext.core.PostExpandParagraphHandler.js')
																.PostExpandParagraphHandler,
	Sanitizer                   = require('./ext.core.Sanitizer.js').Sanitizer,
	TemplateHandler             = require('./ext.core.TemplateHandler.js').TemplateHandler,
	Cite                        = require('./ext.Cite.js').Cite,
	FauxHTML5                   = require('./mediawiki.HTML5TreeBuilder.node.js').FauxHTML5,
	DOMPostProcessor            = require('./mediawiki.DOMPostProcessor.js').DOMPostProcessor,
	DOMConverter                = require('./mediawiki.DOMConverter.js').DOMConverter;

/**
 * Set up a simple parser pipeline. There will be a single pipeline overall,
 * but there can be multiple sub-pipelines for template expansions etc, which
 * in turn differ by input type. The main input type will be fixed at
 * construction time though.
 *
 * @class
 * @constructor
 * @param {Object} Environment.
 */
function ParserPipeline( env, inputType ) {

	if ( ! inputType ) {
		// Actually the only one supported for now, but could also create
		// others for serialized tokens etc
		inputType = 'text/wiki';
	}


	// XXX: create a full-fledged environment based on
	// mediawiki.parser.environment.js.
	if ( !env ) {
		this.env = {};
	} else {
		this.env = env;
	}

	// set up a sub-pipeline cache
	this.pipelineCache = { 
		'text/wiki': { 
			'input': [], 
			'attribute': [] 
		} 
	};

	// Create an input pipeline for the given input type.
	this.inputPipeline = this.makeInputPipeline ( inputType, {}, true );
	this.inputPipeline.atTopLevel = true;
	this.inputPipeline.last.atTopLevel = true;


	this.tokenPostProcessor = new TokenTransformManager.SyncTokenTransformManager ( env );
	this.tokenPostProcessor.listenForTokensFrom ( this.inputPipeline );


	// Add token transformations..
	new QuoteTransformer( this.tokenPostProcessor );
	new PostExpandParagraphHandler( this.tokenPostProcessor );
	new Sanitizer( this.tokenPostProcessor );
	
	//var citeExtension = new Cite( this.tokenTransformer );


	/**
	* The tree builder creates a DOM tree from the token soup emitted from
	* the TokenTransformDispatcher.
	*/
	this.treeBuilder = new FauxHTML5.TreeBuilder();
	this.treeBuilder.listenForTokensFrom( this.tokenPostProcessor );
	//this.tokenPostProcessor.on('chunk', function( c ) {
	//	console.log( JSON.stringify( c, null, 2 ));
	//} );

	/**
	* Final processing on the HTML DOM.
	*/

	/* Generic DOM transformer.
	* This currently performs minor tree-dependent clean up like wrapping
	* plain text in paragraphs. For HTML output, it would also be configured
	* to perform more aggressive nesting cleanup.
	*/
	this.postProcessor = new DOMPostProcessor();
	this.postProcessor.listenForDocumentFrom( this.treeBuilder ); 


	/** 
	* Conversion from HTML DOM to WikiDOM.  This is not needed if plain HTML
	* DOM output is desired, so it should only be registered to the
	* DOMPostProcessor 'document' event if WikiDom output is requested. We
	* could emit events for 'dom', 'wikidom', 'html' and so on, but only
	* actually set up the needed pipeline stages if a listener is registered.
	* Overriding the addListener method should make this possible.
	*/
	this.DOMConverter = new DOMConverter();


	// Lame version for now, see above for an idea for the external async
	// interface and pipeline setup
	this.postProcessor.addListener( 'document', this.forwardDocument.bind( this ) );


}

// Inherit from EventEmitter
ParserPipeline.prototype = new events.EventEmitter();
ParserPipeline.prototype.constructor = ParserPipeline;

/**
 * Factory method for the input (up to async token transforms / phase two)
 * parts of the parser pipeline.
 *
 * @method
 * @param {String} Input type. Try 'text/wiki'.
 * @param {Object} Expanded template arguments to pass to the
 * AsyncTokenTransformManager.
 * @returns {Object} { first: <first stage>, last: AsyncTokenTransformManager }
 * First stage is supposed to implement a process() function
 * that can accept all input at once. The wikitext tokenizer for example
 * accepts the wiki text this way. The last stage of the input pipeline is
 * always an AsyncTokenTransformManager, which emits its output in events.
 */
ParserPipeline.prototype.makeInputPipeline = function ( inputType, args, isNoInclude ) {
	switch ( inputType ) {
		case 'text/wiki':
			//console.log( 'makeInputPipeline ' + JSON.stringify( args ) );
			if ( this.pipelineCache['text/wiki'].input.length ) {
				var pipe = this.pipelineCache['text/wiki'].input.pop();
				pipe.last.args = args;
				return pipe;
			} else {
				var wikiTokenizer = new PegTokenizer();

				/**
				* Token stream transformations.
				* This is where all the wiki-specific functionality is implemented.
				* See https://www.mediawiki.org/wiki/Future/Parser_development/Token_stream_transformations
				*/
				// XXX: Use this.env.config.transforms['inputType'][stage] or
				// somesuch to set up the transforms by input type
				var tokenPreProcessor = new TokenTransformManager.SyncTokenTransformManager ( this.env );
				tokenPreProcessor.listenForTokensFrom ( wikiTokenizer );

				new IncludeOnly( tokenPreProcessor, ! isNoInclude );
				// Add noinclude transform for now
				new NoInclude( tokenPreProcessor, ! isNoInclude );

				var tokenExpander = new TokenTransformManager.AsyncTokenTransformManager (
							{
								'input': this.makeInputPipeline.bind( this ),
								'attributes': this.makeAttributePipeline.bind( this )
							},
							args, this.env 
						);

				// Register template expansion extension
				new TemplateHandler( tokenExpander );

				tokenExpander.listenForTokensFrom ( tokenPreProcessor );
				// XXX: hack.
				tokenExpander.inputType = inputType;
				tokenPreProcessor.inputType = inputType;
			
				return new CachedTokenPipeline( 
						this.cachePipeline.bind( this, 'text/wiki', 'input' ),
						wikiTokenizer,
						tokenExpander
						);
			}
			break;

		default:
			console.trace();
			throw "ParserPipeline.makeInputPipeline: Unsupported input type " + inputType;
	}
};



/**
 * Factory for attribute transformations, with input type implicit in the
 * environment.
 */
ParserPipeline.prototype.makeAttributePipeline = function ( args ) {
	if ( this.pipelineCache['text/wiki'].attribute.length ) {
		var pipe = this.pipelineCache['text/wiki'].attribute.pop();
		pipe.last.args = args;
		return pipe;
	} else {
		/**
		* Token stream transformations.
		* This is where all the wiki-specific functionality is implemented.
		* See https://www.mediawiki.org/wiki/Future/Parser_development/Token_stream_transformations
		*/
		var tokenPreProcessor = new TokenTransformManager.SyncTokenTransformManager ( this.env );
		new NoInclude( tokenPreProcessor );

		var tokenExpander = new TokenTransformManager.AsyncTokenTransformManager (
				{
					'input': this.makeInputPipeline.bind( this ),
					'attributes': this.makeAttributePipeline.bind( this )
				},
				args, this.env 
				);
		new TemplateHandler( tokenExpander );
		tokenExpander.listenForTokensFrom ( tokenPreProcessor );

		return new CachedTokenPipeline( 
				this.cachePipeline.bind( this, 'text/wiki', 'attribute' ),
				tokenPreProcessor,
				tokenExpander
				);
	}
};

ParserPipeline.prototype.cachePipeline = function ( inputType, pipelinePart, pipe ) {
	var cache = this.pipelineCache[inputType][pipelinePart];
	if ( cache && cache.length < 2 ) {
		cache.push( pipe );
	}
};



/**
 * Feed the parser pipeline with some input, the output is emitted in events.
 *
 * @method
 * @param {Mixed} All arguments are passed through to the underlying input
 * pipeline's first element's process() method. For a wikitext pipeline (the
 * default), this would be the wikitext to tokenize:
 * pipeline.parse ( wikiText );
 */
ParserPipeline.prototype.parse = function ( ) {
	// Set the pipeline in motion by feeding the first element with the given
	// arguments.
	this.inputPipeline.process.apply( this.inputPipeline , arguments );
};

// Just bubble up the document event from the pipeline
ParserPipeline.prototype.forwardDocument = function ( document ) {
	this.emit( 'document', document );
};


// XXX: remove JSON serialization here, that should only be performed when
// needed (and normally without pretty-printing).
ParserPipeline.prototype.getWikiDom = function () {
	return JSON.stringify(
				this.DOMConverter.HTMLtoWiki( this.document.body ),
				null,
				2
			);
};


/************************ CachedTokenPipeline ********************************/

/**
 * Wrap a part of a pipeline. The last member of the pipeline is supposed to
 * emit 'end' and 'chunk' events, while the first is supposed to support a
 * process() method that sets the pipeline in motion.
 *
 * @class
 * @constructor
 * @param {Function} returnToCacheCB: Callback to return the
 * CachedTokenPipeline to a cache when processing has finished
 * @param {Object} first: First stage of the pipeline
 * @param {Object} last: Last stage of the pipeline
 */
function CachedTokenPipeline ( returnToCacheCB, first, last ) {
	this.returnToCacheCB = returnToCacheCB;
	this.first = first;
	this.last = last;
	this.last.addListener( 'end', this.forwardEndAndRecycleSelf.bind( this ) );
	this.last.addListener( 'chunk', this.forwardChunk.bind( this ) );
}

// Inherit from EventEmitter
CachedTokenPipeline.prototype = new events.EventEmitter();
CachedTokenPipeline.prototype.constructor = CachedTokenPipeline;


/**
 * Feed input tokens to the first pipeline stage
 */
CachedTokenPipeline.prototype.process = function ( chunk ) {
	//console.log( 'CachedTokenPipeline::process: ' + chunk );
	this.first.process( chunk );
};


/**
 * Forward chunks to our listeners
 */
CachedTokenPipeline.prototype.forwardChunk = function ( chunk ) {
	//console.log( 'CachedTokenPipeline.forwardChunk: ' +
	//			JSON.stringify( chunk, null, 2 )
	//		);

	this.emit( 'chunk', chunk );
};


/**
 * Chunk and end event consumer and emitter, that removes all listeners from
 * the given pipeline stage and returns it to a cache.
 */
CachedTokenPipeline.prototype.forwardEndAndRecycleSelf = function ( ) {
	//console.log( 'CachedTokenPipeline.forwardEndAndRecycleSelf: ' + 
	//		JSON.stringify( this.listeners( 'chunk' ), null, 2 ) );
	// first, forward the event
	this.emit( 'end' );
	// now recycle self
	if ( ! this.atTopLevel ) {
		this.removeAllListeners( 'end' );
		this.removeAllListeners( 'chunk' );
		this.returnToCacheCB ( this );
	}
};




if (typeof module == "object") {
	module.exports.ParserPipeline = ParserPipeline;
}
