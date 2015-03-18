/*!
 * VisualEditor ContentEditable DocumentNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable document node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.DocumentNode} model Model to observe
 * @param {ve.ce.Surface} surface Surface document is part of
 * @param {Object} [config] Configuration options
 */
ve.ce.DocumentNode = function VeCeDocumentNode( model, surface, config ) {
	// Parent constructor
	ve.ce.DocumentNode.super.call( this, model, config );

	// Properties
	this.surface = surface;

	// Set root
	this.setRoot( this );

	// DOM changes
	this.$element.addClass( 've-ce-documentNode' );
	this.$element.prop( { contentEditable: 'true', spellcheck: true } );
};

/* Inheritance */

OO.inheritClass( ve.ce.DocumentNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DocumentNode.static.name = 'document';

/* Methods */

/**
 * Get the outer length.
 *
 * For a document node is the same as the inner length, which is why we override it here.
 *
 * @method
 * @returns {number} Length of the entire node
 */
ve.ce.DocumentNode.prototype.getOuterLength = function () {
	return this.length;
};

/**
 * Get the surface the document is attached to.
 *
 * @method
 * @returns {ve.ce.Surface} Surface the document is attached to
 */
ve.ce.DocumentNode.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Disable editing.
 *
 * @method
 */
ve.ce.DocumentNode.prototype.disable = function () {
	this.$element.prop( 'contentEditable', 'false' );
};

/**
 * Enable editing.
 *
 * @method
 */
ve.ce.DocumentNode.prototype.enable = function () {
	this.$element.prop( 'contentEditable', 'true' );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.DocumentNode );
