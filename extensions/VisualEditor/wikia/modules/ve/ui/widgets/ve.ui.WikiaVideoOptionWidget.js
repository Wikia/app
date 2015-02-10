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
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaVideoOptionWidget = function VeUiWikiaVideoOptionWidget( config ) {
	var $icon, $duration;

	// Parent constructor
	ve.ui.WikiaVideoOptionWidget.super.call( this, config );

	// Initialization
	$icon = this.$( '<span>' )
		.addClass( 've-ui-wikiaVideoOptionWidget-icon' );
	$duration = this.$( '<span>' )
		.addClass( 've-ui-wikiaVideoOptionWidget-duration' )
		.text( this.constructor.static.formatDuration( this.data.duration ) );

	// DOM changes
	this.$element.append( $icon, $duration );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaVideoOptionWidget, ve.ui.WikiaMediaOptionWidget );

/* Static Methods */

ve.ui.WikiaVideoOptionWidget.static.formatDuration = function ( totalSeconds ) {
	var hours = Math.floor( totalSeconds / 3600 ),
		minutes = Math.floor( ( totalSeconds - ( hours * 3600 ) ) / 60 ),
		seconds = totalSeconds - ( hours * 3600 ) - ( minutes * 60 );
	if ( hours < 10 ) {
		hours = '0' + hours;
	}
	if ( minutes < 10 ) {
		minutes = '0' + minutes;
	}
	if ( seconds < 10 ) {
		seconds = '0' + seconds;
	}
	if ( totalSeconds >= 3600 ) {
		return hours + ':' + minutes + ':' + seconds;
	} else {
		return minutes + ':' + seconds;
	}
};
