/*!
 * VisualEditor DataModel MWHeadingNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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

ve.inheritClass( ve.dm.MWHeadingNode, ve.dm.HeadingNode );

/* Static Properties */

ve.dm.MWHeadingNode.static.name = 'mwHeading';

ve.dm.MWHeadingNode.static.suggestedParentNodeTypes = [ 'document' ];

ve.dm.MWHeadingNode.static.toDataElement = function () {
	var parentElement = ve.dm.HeadingNode.static.toDataElement.apply( this, arguments );
	parentElement.type = 'mwHeading';
	return parentElement;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHeadingNode );
