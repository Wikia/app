/*!
 * VisualEditor ContentEditable MWEntityNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki entity node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @constructor
 * @param {ve.dm.MWEntityNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWEntityNode = function VeCeMWEntityNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwEntityNode' );
	// Need CE=false to prevent selection issues
	this.$.prop( 'contentEditable', 'false' );

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );

	// Initialization
	this.onUpdate();
};

/* Inheritance */

ve.inheritClass( ve.ce.MWEntityNode, ve.ce.LeafNode );

/* Static Properties */

ve.ce.MWEntityNode.static.name = 'mwEntity';

/* Methods */

/**
 * Handle model update events.
 *
 * If the source changed since last update the image's src attribute will be updated accordingly.
 *
 * @method
 */
ve.ce.MWEntityNode.prototype.onUpdate = function () {
	this.$.text( this.model.getAttribute( 'character' ) );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWEntityNode );
