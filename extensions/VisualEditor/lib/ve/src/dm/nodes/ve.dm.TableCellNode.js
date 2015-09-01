/*!
 * VisualEditor DataModel TableCellNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel table cell node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.TableCellableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.TableCellNode = function VeDmTableCellNode() {
	// Parent constructor
	ve.dm.TableCellNode.super.apply( this, arguments );

	// Mixin constructor
	ve.dm.TableCellableNode.call( this );

	// Events
	this.connect( this, {
		attributeChange: 'onAttributeChange'
	} );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableCellNode, ve.dm.BranchNode );

OO.mixinClass( ve.dm.TableCellNode, ve.dm.TableCellableNode );

/* Static Properties */

ve.dm.TableCellNode.static.name = 'tableCell';

ve.dm.TableCellNode.static.parentNodeTypes = [ 'tableRow' ];

ve.dm.TableCellNode.static.defaultAttributes = { style: 'data' };

ve.dm.TableCellNode.static.matchTagNames = [ 'td', 'th' ];

ve.dm.TableCellNode.static.isCellEditable = true;

// Blacklisting 'colspan' and 'rowspan' as they are managed explicitly
ve.dm.TableCellNode.static.preserveHtmlAttributes = function ( attribute ) {
	return attribute !== 'colspan' && attribute !== 'rowspan';
};

/* Static Methods */

ve.dm.TableCellNode.static.toDataElement = function ( domElements ) {
	var attributes = {};

	ve.dm.TableCellableNode.static.setAttributes( attributes, domElements );

	return {
		type: this.name,
		attributes: attributes
	};
};

ve.dm.TableCellNode.static.toDomElements = function ( dataElement, doc ) {
	var tag = dataElement.attributes && dataElement.attributes.style === 'header' ? 'th' : 'td',
		domElement = doc.createElement( tag ),
		attributes = dataElement.attributes;

	ve.dm.TableCellableNode.static.applyAttributes( attributes, domElement );

	return [ domElement ];
};

/**
 * Creates data that can be inserted into the model to create a new table cell.
 *
 * @param {Object} [options]
 * @param {string} [options.style='data'] Either 'header' or 'data'
 * @param {number} [options.rowspan=1] Number of rows the cell spans
 * @param {number} [options.colspan=1] Number of columns the cell spans
 * @param {Array} [options.content] Linear model data, defaults to empty wrapper paragraph
 * @return {Array} Model data for a new table cell
 */
ve.dm.TableCellNode.static.createData = function ( options ) {
	var opening, content;
	options = options || {};
	opening = {
		type: 'tableCell',
		attributes: {
			style: options.style || 'data',
			rowspan: options.rowspan || 1,
			colspan: options.colspan || 1
		}
	};
	content = options.content || [
		{ type: 'paragraph', internal: { generated: 'wrapper' } },
		{ type: '/paragraph' }
	];
	return [ opening ].concat( content ).concat( [ { type: '/tableCell' } ] );
};

/* Methods */

/**
 * Handle attributes changes
 *
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.dm.TableCellNode.prototype.onAttributeChange = function ( key ) {
	if ( this.getParent() && ( key === 'colspan' || key === 'rowspan' ) ) {
		// In practice the matrix should already be invalidated as you
		// shouldn't change a span without adding/removing other cells,
		// but it is possible to just change spans if you don't mind a
		// non-rectangular table.
		this.getParent().getParent().getParent().getMatrix().invalidate();
	}
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableCellNode );
