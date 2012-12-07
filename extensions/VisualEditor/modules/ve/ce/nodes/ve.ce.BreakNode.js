/**
 * VisualEditor content editable BreakNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a line break.
 *
 * @class
 * @constructor
 * @extends {ve.ce.LeafNode}
 * @param {ve.dm.BreakNode} model Model to observe
 */
ve.ce.BreakNode = function VeCeBreakNode( model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, 'break', model, $( '<br>' ) );

	// DOM Changes
	this.$.addClass( 've-ce-BreakNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.BreakNode, ve.ce.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.BreakNode.rules = {
	'canBeSplit': false
};

/* Registration */

ve.ce.nodeFactory.register( 'break', ve.ce.BreakNode );
