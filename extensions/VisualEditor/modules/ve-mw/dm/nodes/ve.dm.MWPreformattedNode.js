/*!
 * VisualEditor DataModel MWPreformattedNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki preformatted node.
 *
 * @class
 * @extends ve.dm.PreformattedNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWPreformattedNode = function VeDmMWPreformattedNode() {
	// Parent constructor
	ve.dm.PreformattedNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWPreformattedNode, ve.dm.PreformattedNode );

/* Static Properties */

ve.dm.MWPreformattedNode.static.name = 'mwPreformatted';

ve.dm.MWPreformattedNode.static.suggestedParentNodeTypes = [ 'document', 'tableCell' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWPreformattedNode );
