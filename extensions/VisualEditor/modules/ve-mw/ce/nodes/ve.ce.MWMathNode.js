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
 * @param {Object} [config] Configuration options
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
	if ( contentNodes[0] && contentNodes[0].childNodes ) {
		contentNodes = Array.prototype.slice.apply( contentNodes[0].childNodes );
	}
	deferred.resolve( contentNodes );
};

/** */
ve.ce.MWExtensionNode.prototype.afterRender = function ( domElements ) {
	if ( $( domElements ).is( 'span.tex' ) ) {
		// MathJax
		MathJax.Hub.Queue(
			[ 'Typeset', MathJax.Hub, this.$[0] ],
			[ this, this.emit, 'rerender' ]
		);
	} else {
		// Rerender after image load
		this.$.find( 'img.tex' ).on( 'load', ve.bind( function () {
			this.emit( 'rerender' );
		}, this ) );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWMathNode );
