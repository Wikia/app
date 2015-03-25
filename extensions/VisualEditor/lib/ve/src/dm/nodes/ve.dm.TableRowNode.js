/*!
 * VisualEditor DataModel TableRowNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	ve.dm.TableRowNode.super.apply( this, arguments );

	// Events
	this.connect( this, { splice: 'onSplice' } );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableRowNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableRowNode.static.name = 'tableRow';

ve.dm.TableRowNode.static.childNodeTypes = [ 'tableCell' ];

ve.dm.TableRowNode.static.parentNodeTypes = [ 'tableSection' ];

ve.dm.TableRowNode.static.matchTagNames = [ 'tr' ];

/* Static Methods */

/**
 * Creates data that can be inserted into the model to create a new table row.
 *
 * @param {Object} [options] Creation options
 * @param {string} [options.style='data'] Cell style; 'data' or 'header'
 * @param {number} [options.cellCount=1] Number of cells to create
 * @return {Array} Model data for a new table row
 */
ve.dm.TableRowNode.static.createData = function ( options ) {
	options = options || {};

	var i, data = [],
		cellCount = options.cellCount || 1;

	data.push( { type: 'tableRow' } );
	for ( i = 0; i < cellCount; i++ ) {
		data = data.concat( ve.dm.TableCellNode.static.createData( options ) );
	}
	data.push( { type: '/tableRow' } );
	return data;
};

/* Methods */

/**
 * Handle splicing of child nodes
 */
ve.dm.TableRowNode.prototype.onSplice = function () {
	if ( this.getRoot() ) {
		this.getParent().getParent().getMatrix().invalidate();
	}
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableRowNode );
