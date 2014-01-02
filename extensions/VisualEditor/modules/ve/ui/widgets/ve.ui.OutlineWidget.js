/*!
 * VisualEditor UserInterface OutlineWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Create an ve.ui.OutlineWidget object.
 *
 * @class
 * @extends ve.ui.SelectWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.OutlineWidget = function VeUiOutlineWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.SelectWidget.call( this, config );

	// Initialization
	this.$.addClass( 've-ui-outlineWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.OutlineWidget, ve.ui.SelectWidget );
