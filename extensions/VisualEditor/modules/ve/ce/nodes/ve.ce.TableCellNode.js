/**
 * VisualEditor content editable TableCellNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a table cell.
 *
 * @class
 * @constructor
 * @extends {ve.ce.BranchNode}
 * @param {ve.dm.TableCellNode} model Model to observe
 */
ve.ce.TableCellNode = function VeCeTableCellNode( model ) {
	// Parent constructor
	ve.ce.BranchNode.call(
		this, 'tableCell', model, ve.ce.BranchNode.getDomWrapper( model, 'style' )
	);

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );
};

/* Inheritance */

ve.inheritClass( ve.ce.TableCellNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.TableCellNode.rules = {
	'canBeSplit': false
};

/**
 * Mapping of list item style values and DOM wrapper element types.
 *
 * @static
 * @member
 */
ve.ce.TableCellNode.domWrapperElementTypes = {
	'data': 'td',
	'header': 'th'
};

/* Methods */

/**
 * Responds to model update events.
 *
 * If the style changed since last update the DOM wrapper will be replaced with an appropriate one.
 *
 * @method
 */
ve.ce.TableCellNode.prototype.onUpdate = function () {
	this.updateDomWrapper( 'style' );
};

/* Registration */

ve.ce.nodeFactory.register( 'tableCell', ve.ce.TableCellNode );
