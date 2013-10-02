/*!
 * VisualEditor DataModel MWMathNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki math node.
 *
 * @class
 * @extends ve.dm.MWExtensionNode
 *
 * @constructor
 */
ve.dm.MWMathNode = function VeDmMWMathNode( length, element ) {
	// Parent constructor
	ve.dm.MWExtensionNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWMathNode, ve.dm.MWExtensionNode );

/* Static members */

ve.dm.MWMathNode.static.name = 'mwMath';

ve.dm.MWMathNode.static.tagName = 'img';

ve.dm.MWMathNode.static.extensionName = 'math';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWMathNode );
