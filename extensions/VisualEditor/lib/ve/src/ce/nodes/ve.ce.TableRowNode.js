/*!
 * VisualEditor ContentEditable TableRowNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable table row node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.TableRowNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.TableRowNode = function VeCeTableRowNode() {
	// Parent constructor
	ve.ce.TableRowNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.TableRowNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.TableRowNode.static.name = 'tableRow';

ve.ce.TableRowNode.static.tagName = 'tr';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableRowNode );
