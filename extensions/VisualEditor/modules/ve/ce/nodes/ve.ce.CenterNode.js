/**
 * VisualEditor content editable CenterNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a center tag.
 *
 * @class
 * @constructor
 * @extends {ve.ce.BranchNode}
 * @param {ve.dm.CenterNode} model Model to observe
 */
ve.ce.CenterNode = function VeCeCenterNode( model ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, 'center', model, $( '<center>') );
};

/* Inheritance */

ve.inheritClass( ve.ce.CenterNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.CenterNode.rules = {
	'canBeSplit': false
};

/* Registration */

ve.ce.nodeFactory.register( 'center', ve.ce.CenterNode );
