/*!
 * VisualEditor ContentEditable MWTransclusionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * ContentEditable MediaWiki transclusion node.
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 * @mixins ve.ce.GeneratedContentNode
 *
 * @constructor
 * @param {ve.dm.MWTransclusionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWTransclusionNode = function VeCeMWTransclusionNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.ProtectedNode.call( this );
	ve.ce.FocusableNode.call( this );
	ve.ce.RelocatableNode.call( this );
	ve.ce.GeneratedContentNode.call( this );

	// DOM changes
	this.$.addClass( 've-ce-mwTransclusionNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWTransclusionNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.MWTransclusionNode, ve.ce.ProtectedNode );

ve.mixinClass( ve.ce.MWTransclusionNode, ve.ce.FocusableNode );

ve.mixinClass( ve.ce.MWTransclusionNode, ve.ce.RelocatableNode );

ve.mixinClass( ve.ce.MWTransclusionNode, ve.ce.GeneratedContentNode );

/* Static Properties */

ve.ce.MWTransclusionNode.static.name = 'mwTransclusion';

ve.ce.MWTransclusionNode.static.renderHtmlAttributes = false;

/* Methods */

/** */
ve.ce.MWTransclusionNode.prototype.generateContents = function ( config ) {
	var xhr, promise, deferred = $.Deferred();
	xhr = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'visualeditor',
			'paction': 'parsefragment',
			'page': mw.config.get( 'wgRelevantPageName' ),
			'wikitext': ( config && config.wikitext ) || this.model.getWikitext(),
			'token': mw.user.tokens.get( 'editToken' ),
			'format': 'json'
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( this.onParseSuccess, this, deferred ),
		'error': ve.bind( this.onParseError, this, deferred )
	} );
	promise = deferred.promise();
	promise.abort = function () {
		xhr.abort();
	};
	return promise;
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by #generateContents
 * @param {Object} response Response data
 */
ve.ce.MWTransclusionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var contentNodes;

	if ( !response || response.error || !response.visualeditor || response.visualeditor.result !== 'success' ) {
		return this.onParseError.call( this, deferred );
	}

	contentNodes = $( response.visualeditor.content ).get();
	// HACK: if $content consists of a single paragraph, unwrap it.
	// We have to do this because the PHP parser wraps everything in <p>s, and inline templates
	// will render strangely when wrapped in <p>s.
	if ( contentNodes.length === 1 && contentNodes[0].nodeName.toLowerCase() === 'p' ) {
		contentNodes = Array.prototype.slice.apply( contentNodes[0].childNodes );
	}
	deferred.resolve( contentNodes );
};

/**
 * Handle an unsuccessful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The promise object created by #generateContents
 * @param {Object} response Response data
 */
ve.ce.MWTransclusionNode.prototype.onParseError = function ( deferred ) {
	deferred.reject();
};

/* Concrete subclasses */

/**
 * ContentEditable MediaWiki transclusion block node.
 *
 * @class
 * @extends ve.ce.MWTransclusionNode
 * @constructor
 * @param {ve.dm.MWTransclusionBlockNode} model Model to observe
 */
ve.ce.MWTransclusionBlockNode = function VeCeMWTransclusionBlockNode( model ) {
	// Parent constructor
	ve.ce.MWTransclusionNode.call( this, model );

	// DOM changes
	this.$.addClass( 've-ce-mwTransclusionBlockNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWTransclusionBlockNode, ve.ce.MWTransclusionNode );

/* Static Properties */

ve.ce.MWTransclusionBlockNode.static.name = 'mwTransclusionBlock';

ve.ce.MWTransclusionBlockNode.static.tagName = 'div';

/**
 * ContentEditable MediaWiki transclusion inline node.
 *
 * @class
 * @extends ve.ce.MWTransclusionNode
 * @constructor
 * @param {ve.dm.MWTransclusionInlineNode} model Model to observe
 */
ve.ce.MWTransclusionInlineNode = function VeCeMWTransclusionInlineNode( model ) {
	// Parent constructor
	ve.ce.MWTransclusionNode.call( this, model );

	// DOM changes
	this.$.addClass( 've-ce-mwTransclusionInlineNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWTransclusionInlineNode, ve.ce.MWTransclusionNode );

/* Static Properties */

ve.ce.MWTransclusionInlineNode.static.name = 'mwTransclusionInline';

ve.ce.MWTransclusionInlineNode.static.tagName = 'span';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWTransclusionNode );
ve.ce.nodeFactory.register( ve.ce.MWTransclusionBlockNode );
ve.ce.nodeFactory.register( ve.ce.MWTransclusionInlineNode );
