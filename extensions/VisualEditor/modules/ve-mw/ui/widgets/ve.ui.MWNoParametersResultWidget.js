/*!
 * VisualEditor UserInterface MWNoParametersResultWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWNoParametersResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 */
ve.ui.MWNoParametersResultWidget = function VeUiMWNoParametersResultWidget( data, config ) {
	// Parent constructor
	OO.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$element.addClass( 've-ui-mwNoParametersResultWidget' );
	this.setLabel( this.buildLabel() );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWNoParametersResultWidget, OO.ui.OptionWidget );

/* Methods */

/** */
ve.ui.MWNoParametersResultWidget.prototype.buildLabel = function () {
	return this.$( '<div>' )
		.addClass( 've-ui-mwNoParametersResultWidget-label' )
		.text( ve.msg( 'visualeditor-parameter-search-no-unused' ) );
};
