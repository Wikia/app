/*!
 * VisualEditor ContentEditable PreformattedNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable preformatted node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.PreformattedNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.PreformattedNode = function VeCePreformattedNode( model, config ) {
	// Parent constructor
	ve.ce.ContentBranchNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.PreformattedNode, ve.ce.ContentBranchNode );

/* Static Properties */

ve.ce.PreformattedNode.static.name = 'preformatted';

ve.ce.PreformattedNode.static.tagName = 'pre';

ve.ce.PreformattedNode.static.canBeSplit = true;

/* Registration */

ve.ce.nodeFactory.register( ve.ce.PreformattedNode );
