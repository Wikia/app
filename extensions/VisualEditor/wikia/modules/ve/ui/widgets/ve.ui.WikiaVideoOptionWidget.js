/*!
 * VisualEditor UserInterface WikiaVideoOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends ve.ui.WikiaMediaOptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaVideoOptionWidget = function VeUiWikiaVideoOptionWidget( data, config ) {
	var $icon, $duration;

	// Parent constructor
	ve.ui.WikiaVideoOptionWidget.super.call( this, data, config );

	// Initialization
	$icon = this.$( '<span>' )
		.addClass( 've-ui-wikiaVideoOptionWidget-icon' );
	$duration = this.$( '<span>' )
		.addClass( 've-ui-wikiaVideoOptionWidget-duration' )
		.text( this.data.duration );

	// DOM changes
	this.$element.append( $icon, $duration );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaVideoOptionWidget, ve.ui.WikiaMediaOptionWidget );
