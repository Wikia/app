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
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWHeadingNode = function VeDmMWHeadingNode() {
	// Parent constructor
	ve.dm.HeadingNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWHeadingNode, ve.dm.HeadingNode );

/* Static Properties */

ve.dm.MWHeadingNode.static.name = 'mwHeading';

ve.dm.MWHeadingNode.static.suggestedParentNodeTypes = [ 'document', 'tableCell' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHeadingNode );
