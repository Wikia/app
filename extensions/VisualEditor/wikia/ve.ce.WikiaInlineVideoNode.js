/*!
 * VisualEditor ContentEditable WikiaInlineVideoNode class.
 */

/**
 * ContentEditable Wikia video node.
 *
 * @class
 * @extends ve.ce.MWInlineImageNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 *
 * @constructor
 * @param {ve.dm.WikiaInlineVideoNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaInlineVideoNode = function VeCeWikiaInlineVideoNode( model, config ) {
	// Parent constructor
	ve.ce.MWInlineImageNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaInlineVideoNode, ve.ce.MWInlineImageNode );

/* Static Properties */

ve.ce.WikiaInlineVideoNode.static.name = 'wikiaInlineVideo';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaInlineVideoNode );
