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
 * @extends OO.ui.DecoratedOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {Mixed} [config.data] Item data
 * @param {number} [config.data.remainder] Remaining items that can be shown
 */
ve.ui.MWMoreParametersResultWidget = function VeUiMWMoreParametersResultWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( { icon: 'parameter-set' }, config );

	// Parent constructor
	OO.ui.DecoratedOptionWidget.call( this, config );

	// Initialization
	this.$element.addClass( 've-ui-mwMoreParametersResultWidget' );
	this.setLabel( this.buildLabel() );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMoreParametersResultWidget, OO.ui.DecoratedOptionWidget );

/* Methods */

/** */
ve.ui.MWMoreParametersResultWidget.prototype.buildLabel = function () {
	return this.$( '<div>' )
		.addClass( 've-ui-mwMoreParametersResultWidget-label' )
		.text( ve.msg( 'visualeditor-parameter-search-more', this.data.remainder ) );
};
