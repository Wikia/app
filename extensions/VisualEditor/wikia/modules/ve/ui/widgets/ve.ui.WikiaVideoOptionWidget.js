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
 * @param {Mixed} model Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaVideoOptionWidget = function VeUiWikiaVideoOptionWidget( model, config ) {
	var $icon, $duration;

	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.WikiaVideoOptionWidget.super.call( this, model, config );

	// Initialization
	$icon = $( '<span>' ).addClass( 've-ui-wikiaVideoOptionWidget-icon' );
	this.$element.append( $icon );

	if ( typeof model.duration === 'string' && model.duration !== '' ) {
		$duration = $( '<span>' )
			.addClass( 've-ui-wikiaVideoOptionWidget-duration' )
			.text( model.duration );
		this.$element.append( $duration );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaVideoOptionWidget, ve.ui.WikiaMediaOptionWidget );

/* Methods */

