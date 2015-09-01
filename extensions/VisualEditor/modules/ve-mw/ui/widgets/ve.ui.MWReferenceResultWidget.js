/*!
 * VisualEditor UserInterface MWReferenceResultWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
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
 */
ve.ui.MWReferenceResultWidget = function VeUiMWReferenceResultWidget() {
	// Parent constructor
	ve.ui.MWReferenceResultWidget.super.apply( this, arguments );

	// Initialization
	this.$element
		.addClass( 've-ui-mwReferenceResultWidget' )
		.append(
			$( '<div>' ).addClass( 've-ui-mwReferenceResultWidget-shield' )
		);
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceResultWidget, OO.ui.OptionWidget );
