/*!
 * VisualEditor ContentEditable MWExtensionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * ContentEditable MediaWiki extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.GeneratedContentNode
 *
 * @constructor
 * @param {ve.dm.MWExtensionNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.MWExtensionNode = function VeCeMWExtensionNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );
	ve.ce.ProtectedNode.call( this );
	ve.ce.GeneratedContentNode.call( this );

	// DOM changes
	this.$.addClass( 've-ce-mwExtensionNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWExtensionNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.MWExtensionNode, ve.ce.FocusableNode );
ve.mixinClass( ve.ce.MWExtensionNode, ve.ce.ProtectedNode );
ve.mixinClass( ve.ce.MWExtensionNode, ve.ce.GeneratedContentNode );

/* Methods */

/** */
ve.ce.MWExtensionNode.prototype.generateContents = function () {
	var deferred = $.Deferred(),
		extensionName = this.getModel().getExtensionName();

	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'visualeditor',
			'paction': 'parsefragment',
			'page': mw.config.get( 'wgRelevantPageName' ),
			'wikitext':
				'<' + extensionName + '>' +
					this.getModel().getAttribute( 'mw' ).body.extsrc +
				'</' + extensionName + '>',
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
	return deferred.promise();
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWExtensionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var data = response.visualeditor, contentNodes = $( data.content ).get();
	deferred.resolve( contentNodes );
	// Rerender after images load
	this.$.find( 'img' ).on( 'load', ve.bind( function () {
		this.emit( 'rerender' );
	}, this ) );
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
