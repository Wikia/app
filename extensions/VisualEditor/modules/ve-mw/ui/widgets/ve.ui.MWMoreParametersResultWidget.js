/*!
 * VisualEditor UserInterface MWMoreParametersResultWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWMoreParametersResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {number} [data.remainder] Remaining items that can be shown
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMoreParametersResultWidget = function VeUiMWMoreParametersResultWidget( data, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'icon': 'parameter-set' }, config );

	// Parent constructor
	OO.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$element.addClass( 've-ui-mwMoreParametersResultWidget' );
	this.setLabel( this.buildLabel() );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMoreParametersResultWidget, OO.ui.OptionWidget );

/* Methods */

/** */
ve.ui.MWMoreParametersResultWidget.prototype.buildLabel = function () {
	return this.$( '<div>' )
		.addClass( 've-ui-mwMoreParametersResultWidget-label' )
		.text( ve.msg( 'visualeditor-parameter-search-more', this.data.remainder ) );
};
