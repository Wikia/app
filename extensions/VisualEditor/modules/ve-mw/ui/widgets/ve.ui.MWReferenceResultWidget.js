/*!
 * VisualEditor UserInterface MWReferenceResultWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWReferenceResultWidget object.
 *
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [divider] Section divider item, not highlightable or selectable
 */
ve.ui.MWReferenceResultWidget = function VeUiMWReferenceResultWidget( data, config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Properties
	this.$shield = this.$$( '<div>' );

	// Initialization
	this.$shield.addClass( 've-ui-mwReferenceResultWidget-shield' );
	this.$
		.addClass( 've-ui-mwReferenceResultWidget' )
		.append( this.$shield );
	if ( config.divider ) {
		this.$.addClass( 've-ui-mwReferenceResultWidget-divider' );
		this.setDisabled( true );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.MWReferenceResultWidget, ve.ui.OptionWidget );
