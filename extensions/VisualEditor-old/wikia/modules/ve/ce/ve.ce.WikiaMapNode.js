/*!
 * VisualEditor ContentEditable WikiaMapNode class.
 */

/**
 * ContentEditable Wikia map node.
 *
 * @class
 * @extends ve.ce.MWBlockExtensionNode
 *
 * @constructor
 * @param {ve.dm.WikiaMapNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaMapNode = function VeCeWikiaMapNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaMapNode.super.call( this, model, config );

	// DOM changes
	// Size provided as a fix for https://wikia-inc.atlassian.net/browse/VE-1343
	this.$element
		.addClass( 've-ce-wikiaMapNode' )
		.height( 382 )
		.width( 680 );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaMapNode, ve.ce.MWBlockExtensionNode );

/* Static Properties */

ve.ce.WikiaMapNode.static.name = 'wikiaMap';

ve.ce.WikiaMapNode.static.tagName = 'figure';

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.WikiaMapNode.prototype.onSetup = function () {
	ve.ce.WikiaMapNode.super.prototype.onSetup.apply( this, arguments );
	// Remove the "View" link
	this.$element.find( '.view' ).remove();
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaMapNode );
