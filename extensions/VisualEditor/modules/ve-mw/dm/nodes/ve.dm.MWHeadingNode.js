/*!
 * VisualEditor DataModel MWHeadingNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki heading node.
 *
 * @class
 * @extends ve.dm.HeadingNode
 * @constructor
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWHeadingNode = function VeDmMWHeadingNode( children, element ) {
	// Parent constructor
	ve.dm.HeadingNode.call( this, children, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWHeadingNode, ve.dm.HeadingNode );

/* Static Properties */

ve.dm.MWHeadingNode.static.name = 'mwHeading';

ve.dm.MWHeadingNode.static.suggestedParentNodeTypes = [ 'document' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHeadingNode );
