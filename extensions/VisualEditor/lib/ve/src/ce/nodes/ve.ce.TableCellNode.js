/*!
 * VisualEditor ContentEditable TableCellNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable table cell node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.TableCellableNode
 * @constructor
 * @param {ve.dm.TableCellNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.TableCellNode = function VeCeTableCellNode() {
	var rowspan, colspan;

	// Parent constructor
	ve.ce.TableCellNode.super.apply( this, arguments );

	// Mixin constructors
	ve.ce.TableCellableNode.call( this );

	rowspan = this.model.getRowspan();
	colspan = this.model.getColspan();

	// DOM changes
	this.$element
		// The following classes can be used here:
		// ve-ce-tableCellNode-data
		// ve-ce-tableCellNode-header
		.addClass( 've-ce-tableCellNode ve-ce-tableCellNode-' + this.model.getAttribute( 'style' ) );

	// Set attributes (keep in sync with #onSetup)
	if ( rowspan > 1 ) {
		this.$element.attr( 'rowspan', rowspan );
	}
	if ( colspan > 1 ) {
		this.$element.attr( 'colspan', colspan );
	}

	// Add tooltip
	this.$element.attr( 'title', ve.msg( 'visualeditor-tablecell-tooltip' ) );

	// Events
	this.model.connect( this, {
		update: 'onUpdate',
		attributeChange: 'onAttributeChange'
	} );
};

/* Inheritance */

OO.inheritClass( ve.ce.TableCellNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.TableCellNode, ve.ce.TableCellableNode );

/* Static Properties */

ve.ce.TableCellNode.static.name = 'tableCell';

/* Methods */

/**
 * Get the HTML tag name.
 *
 * Tag name is selected based on the model's style attribute.
 *
 * @return {string} HTML tag name
 * @throws {Error} Invalid style
 */
ve.ce.TableCellNode.prototype.getTagName = function () {
	var style = this.model.getAttribute( 'style' ),
		types = { data: 'td', header: 'th' };

	if ( !Object.prototype.hasOwnProperty.call( types, style ) ) {
		throw new Error( 'Invalid style' );
	}
	return types[ style ];
};

/**
 * Set the editing mode of a table cell node
 *
 * @param {boolean} enable Enable editing
 */
ve.ce.TableCellNode.prototype.setEditing = function ( enable ) {
	this.$element
		.toggleClass( 've-ce-tableCellNode-editing', enable )
		.prop( 'contentEditable', enable.toString() );
};

/**
 * Handle model update events.
 *
 * If the style changed since last update the DOM wrapper will be replaced with an appropriate one.
 *
 * @method
 */
ve.ce.TableCellNode.prototype.onUpdate = function () {
	this.updateTagName();
};

/**
 * @inheritdoc
 */
ve.ce.TableCellNode.prototype.onSetup = function () {
	var rowspan, colspan;
	// Parent method
	ve.ce.TableCellNode.super.prototype.onSetup.call( this );

	rowspan = this.model.getRowspan();
	colspan = this.model.getColspan();
	// Set attributes (duplicated from constructor in case this.$element is replaced)
	if ( rowspan > 1 ) {
		this.$element.attr( 'rowspan', rowspan );
	}
	if ( colspan > 1 ) {
		this.$element.attr( 'colspan', colspan );
	}
};

/**
 * Handle attribute changes to keep the live HTML element updated.
 */
ve.ce.TableCellNode.prototype.onAttributeChange = function ( key, from, to ) {
	switch ( key ) {
		case 'colspan':
		case 'rowspan':
			if ( to > 1 ) {
				this.$element.attr( key, to );
			} else {
				this.$element.removeAttr( key );
			}
			break;
		case 'style':
			this.$element
				.removeClass( 've-ce-tableCellNode-' + from )
				.addClass( 've-ce-tableCellNode-' + to );
			this.updateTagName();
			break;
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableCellNode );
