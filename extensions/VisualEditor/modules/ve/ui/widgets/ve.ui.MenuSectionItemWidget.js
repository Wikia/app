/*!
 * VisualEditor UserInterface MenuSectionItemWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MenuSectionItemWidget object.
 *
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Config options
 */
ve.ui.MenuSectionItemWidget = function VeUiMenuSectionItemWidget( data, config ) {
	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$.addClass( 've-ui-menuSectionItemWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MenuSectionItemWidget, ve.ui.OptionWidget );

ve.ui.MenuSectionItemWidget.static.selectable = false;

ve.ui.MenuSectionItemWidget.static.highlightable = false;
