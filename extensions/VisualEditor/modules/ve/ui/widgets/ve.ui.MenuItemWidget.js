/*!
 * VisualEditor UserInterface MenuItemWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MenuItemWidget object.
 *
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 */
ve.ui.MenuItemWidget = function VeUiMenuItemWidget( data, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'icon': 'check' }, config );

	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$.addClass( 've-ui-menuItemWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MenuItemWidget, ve.ui.OptionWidget );
