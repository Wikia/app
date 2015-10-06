/*!
 * VisualEditor UserInterface WikiaMapOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends ve.ui.WikiaMediaOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaMapOptionWidget = function VeUiWikiaMapOptionWidget( config ) {
	var $sublabel;

	// Parent constructor
	ve.ui.WikiaMapOptionWidget.super.call( this, config );

	// Properties
	$sublabel = this.$( '<span>' )
		.addClass( 've-ui-wikiaMapOptionWidget-sublabel' )
		// TODO: i18n/messaging for pins
		.text( config.data.pins );

	// DOM changes
	$sublabel.insertAfter( this.$label );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMapOptionWidget, ve.ui.WikiaMediaOptionWidget );
