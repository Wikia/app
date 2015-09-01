/*!
 * VisualEditor ContentEditable TableCellableNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable node which can behave as a table cell
 *
 * @class
 *
 * @abstract
 * @constructor
 */
ve.ce.TableCellableNode = function VeCeTableCellableNode() {
	if ( this.isCellable() && !this.isCellEditable() ) {
		this.$element.attr( 'title', ve.msg( 'visualeditor-aliennode-tooltip' ) );
	}
};

/* Inheritance */

OO.initClass( ve.ce.TableCellableNode );

/* Static Methods */

/* Methods */

/**
 * Set the editing mode of a table cell node
 *
 * @param {boolean} enable Enable editing
 */
ve.ce.TableCellableNode.prototype.setEditing = function () {
};
