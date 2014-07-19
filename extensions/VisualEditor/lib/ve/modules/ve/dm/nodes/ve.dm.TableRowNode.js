/*!
 * VisualEditor DataModel TableRowNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel table row node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.TableRowNode = function VeDmTableRowNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableRowNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableRowNode.static.name = 'tableRow';

ve.dm.TableRowNode.static.childNodeTypes = [ 'tableCell' ];

ve.dm.TableRowNode.static.parentNodeTypes = [ 'tableSection' ];

ve.dm.TableRowNode.static.matchTagNames = [ 'tr' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableRowNode );
