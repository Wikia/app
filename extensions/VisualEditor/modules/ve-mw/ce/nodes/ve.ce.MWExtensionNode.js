/*!
 * VisualEditor ContentEditable MWExtensionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki extension node.
 *
 * Configuration options for .update():
 * - extsrc: override the contents of the tag (string)
 * - attrs: override the attributes of the tag (object)
 *
 * @class
 * @abstract
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.GeneratedContentNode
 *
 * @constructor
 */
ve.ce.MWExtensionNode = function VeCeMWExtensionNode() {
	// Mixin constructors
	ve.ce.FocusableNode.call( this, this.getFocusableElement() );
	ve.ce.GeneratedContentNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWExtensionNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWExtensionNode, ve.ce.FocusableNode );
OO.mixinClass( ve.ce.MWExtensionNode, ve.ce.GeneratedContentNode );

/* Static properties */

/**
 * Extension renders visible content when empty
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ce.MWExtensionNode.static.rendersEmpty = false;

/* Methods */

/** */
ve.ce.MWExtensionNode.prototype.generateContents = function ( config ) {
	var xhr,
		deferred = $.Deferred(),
		mwData = this.getModel().getAttribute( 'mw' ),
		extsrc = config && config.extsrc !== undefined ? config.extsrc : mwData.body.extsrc,
		attrs = config && config.attrs || mwData.attrs,
		tagName = this.getModel().getExtensionName(),
		// XML-like tags in wikitext are not actually XML and don't expect their contents to be escaped.
		wikitext = mw.html.element( tagName, attrs, new mw.html.Raw( extsrc ) );

	if ( !this.constructor.static.rendersEmpty && wikitext.trim() !== '' ) {
		xhr = ve.init.target.constructor.static.apiRequest( {
			action: 'visualeditor',
			paction: 'parsefragment',
			page: mw.config.get( 'wgRelevantPageName' ),
			wikitext: wikitext
		}, { type: 'POST' } )
			.done( this.onParseSuccess.bind( this, deferred ) )
			.fail( this.onParseError.bind( this, deferred ) );
		return deferred.promise( { abort: xhr.abort } );
	} else {
		deferred.resolve( $( '<span>&nbsp;</span>' ).get() );
		return deferred.promise();
	}
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWExtensionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var data = response.visualeditor, contentNodes = this.$( data.content ).get();
	deferred.resolve( contentNodes );
};

/** */
ve.ce.MWExtensionNode.prototype.afterRender = function () {
	// Rerender after images load
	// TODO: ignore shields, and count multiple images
	this.$element.find( 'img' ).on( 'load', function () {
		this.emit( 'rerender' );
	}.bind( this ) );
};

/**
 * Handle an unsuccessful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The promise object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWExtensionNode.prototype.onParseError = function ( deferred ) {
	deferred.reject();
};

/**
 * ContentEditable MediaWiki inline extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWInlineExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInlineExtensionNode = function VeCeMWInlineExtensionNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.MWExtensionNode.call( this );

	// DOM changes
	this.$element.addClass( 've-ce-mwInlineExtensionNode' );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInlineExtensionNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWInlineExtensionNode, ve.ce.MWExtensionNode );

/**
 * ContentEditable MediaWiki block extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWBlockExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWBlockExtensionNode = function VeCeMWBlockExtensionNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Mixin constructors
	ve.ce.MWExtensionNode.call( this );

	// DOM changes
	this.$element.addClass( 've-ce-mwBlockExtensionNode' );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWBlockExtensionNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.MWBlockExtensionNode, ve.ce.MWExtensionNode );
