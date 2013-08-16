/*!
 * VisualEditor DataModel MWPreformattedNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki preformatted node.
 *
 * @class
 * @extends ve.dm.PreformattedNode
 * @constructor
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWPreformattedNode = function VeDmMWPreformattedNode( children, element ) {
	// Parent constructor
	ve.dm.PreformattedNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWPreformattedNode, ve.dm.PreformattedNode );

/* Static Properties */

ve.dm.MWPreformattedNode.static.name = 'mwPreformatted';

ve.dm.MWPreformattedNode.static.suggestedParentNodeTypes = [ 'document' ];

ve.dm.MWPreformattedNode.static.toDataElement = function () {
	return { 'type': 'mwPreformatted' };
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWPreformattedNode );
