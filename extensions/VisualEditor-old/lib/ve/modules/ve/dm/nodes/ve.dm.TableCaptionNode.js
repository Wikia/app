/*!
 * VisualEditor DataModel TableCaptionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel table caption node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.TableCaptionNode = function VeDmTableCaptionNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableCaptionNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableCaptionNode.static.name = 'tableCaption';

ve.dm.TableCaptionNode.static.parentNodeTypes = [ 'table' ];

ve.dm.TableCaptionNode.static.matchTagNames = [ 'caption' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableCaptionNode );
