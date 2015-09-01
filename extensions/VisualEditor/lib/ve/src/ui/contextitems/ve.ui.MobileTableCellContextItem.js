/*!
 * VisualEditor MobileTableCellContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context item for a table cell in mobile.
 *
 * @class
 * @extends ve.ui.LinearContextItem
 *
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.Model} model Model item is related to
 * @param {Object} config Configuration options
 */
ve.ui.MobileTableCellContextItem = function VeUiMobileTableCellContextItem() {
	// Parent constructor
	ve.ui.MobileTableCellContextItem.super.apply( this, arguments );

	// Initialization
	this.$element.addClass( 've-ui-mobileTableCellContextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileTableCellContextItem, ve.ui.LinearContextItem );

/* Static Properties */

ve.ui.MobileTableCellContextItem.static.name = 'tableCell';

ve.ui.MobileTableCellContextItem.static.icon = 'table';

ve.ui.MobileTableCellContextItem.static.label = OO.ui.deferMsg( 'visualeditor-tablecell-contextitem' );

ve.ui.MobileTableCellContextItem.static.modelClasses = [ ve.dm.TableCellNode ];

ve.ui.MobileTableCellContextItem.static.deletable = false;

ve.ui.MobileTableCellContextItem.static.embeddable = false;

ve.ui.MobileTableCellContextItem.static.commandName = 'enterTableCell';

/* Registration */

ve.ui.contextItemFactory.register( ve.ui.MobileTableCellContextItem );
