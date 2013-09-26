/*!
 * VisualEditor ContentEditable MWMathNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global MathJax */

/**
 * ContentEditable MediaWiki math node.
 *
 * @class
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWMathNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.MWMathNode = function VeCeMWMathNode( model, config ) {
	// Parent constructor
	ve.ce.MWExtensionNode.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwMathNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWMathNode, ve.ce.MWExtensionNode );

/* Static Properties */

ve.ce.MWMathNode.static.name = 'mwMath';

/* Methods */

/** */
ve.ce.MWMathNode.prototype.onParseSuccess = function ( deferred, response ) {
	var data = response.visualeditor, contentNodes = $( data.content ).get();
	// HACK: unwrap paragraph from PHP parser
	contentNodes = Array.prototype.slice.apply( contentNodes[0].childNodes );
	deferred.resolve( contentNodes );
	if ( $( contentNodes ).is( 'span.tex' ) ) {
		// MathJax
		MathJax.Hub.Queue( [ 'Typeset', MathJax.Hub ] );
	} else {
		// Rerender after image load
		this.$.find( 'img' ).on( 'load', ve.bind( function () {
			this.emit( 'rerender' );
		}, this ) );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWMathNode );
