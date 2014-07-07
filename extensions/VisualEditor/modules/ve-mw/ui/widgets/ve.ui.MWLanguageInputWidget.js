/*!
 * VisualEditor UserInterface LanguageInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWLanguageInputWidget object.
 *
 * @class
 * @extends ve.ui.LanguageInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLanguageInputWidget = function VeUiMWLanguageInputWidget( config ) {
	// Parent constructor
	ve.ui.LanguageInputWidget.call( this, config );

	var changeButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-languageinspector-widget-changelang' ),
		// Add 'href' so the button returns true on click and triggers ULS
		'href': '#',
		'flags': ['primary']
	} );

	// Events
	changeButton.$element.uls( {
		'onSelect': ve.bind( function ( language ) {
			this.setAnnotationFromValues( language, $.uls.data.getDir( language ) );
		}, this ),
		'compact': true,
		// Temporary Quicklist for the Prototype:
		// (This will likely change once we find a better list)
		'quickList': [ 'en', 'hi', 'he', 'ml', 'ta', 'fr' ]
	} );

	// TODO: Rethink the layout, maybe integrate the change button into the language field
	// TODO: Consider using getAutonym to display a nicer language name label somewhere

	// Initialization
	this.$element.prepend( $( '<div>' ).addClass( 've-ui-mwLangugageInputWidget-uls' ).append( changeButton.$element ) );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLanguageInputWidget, ve.ui.LanguageInputWidget );
