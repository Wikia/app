/*!
 * VisualEditor UserInterface MWReferenceResultWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWReferenceResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [divider] Section divider item, not highlightable or selectable
 */
ve.ui.MWReferenceResultWidget = function VeUiMWReferenceResultWidget( config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	OO.ui.OptionWidget.call( this, config );

	// Properties
	this.$shield = this.$( '<div>' );

	// Initialization
	this.$shield.addClass( 've-ui-mwReferenceResultWidget-shield' );
	this.$element
		.addClass( 've-ui-mwReferenceResultWidget' )
		.append( this.$shield );
	if ( config.divider ) {
		this.$element.addClass( 've-ui-mwReferenceResultWidget-divider' );
		this.setDisabled( true );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceResultWidget, OO.ui.OptionWidget );
