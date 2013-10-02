/*!
 * VisualEditor UserInterface LanguageInputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.LanguageInputWidget object.
 *
 * @class
 * @extends ve.ui.TextInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInputWidget = function VeUiLanguageInputWidget( config ) {
	var ulsParams, langInpObj, table;

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Visual Properties
	this.$langCodeDisp = this.getDisplayElement( config ); // language code
	this.$langNameDisp = this.getDisplayElement( config ); // human-readable language name
	this.$dirDisp = this.getDisplayElement( config );

	// Placeholders for attribute values
	this.lang = '';
	this.dir = '';

	// Create the informational table:
	table = $( '<table>' ).css( { 'width': '100%' } )
		.addClass( 've-LanguageInspector-information' )
		.append( $( '<tr>' )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-title' )
				.text( ve.msg( 'visualeditor-languageinspector-widget-label-language' ) ) )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-langname' )
			.append( this.$langNameDisp ) ) )
		.append( $( '<tr>' )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-title' )
				.text( ve.msg( 'visualeditor-languageinspector-widget-label-langcode' ) ) )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-langcode' )
			.append( this.$langCodeDisp ) ) )
		.append( $( '<tr>' )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-title' )
				.text( ve.msg( 'visualeditor-languageinspector-widget-label-direction' ) ) )
			.append( $( '<td>' )
				.addClass( 've-ui-LanguageInspector-info-dir' )
			.append( this.$dirDisp ) ) );
	this.$.append( table );

	// Use a different reference than 'this' to avoid scope problems
	// inside the $.ULS callback:
	langInpObj = this;

	// Initialization
	this.$.addClass( 've-ui-LangInputWidget' );

	ulsParams = {
		onSelect: function( language ) {
			// Save the attributes:
			langInpObj.setAttributes( language, $.uls.data.getDir( language ) );
		},
		compact: true,
		// Temporary Quicklist for the Prototype:
		// (This will likely change once we find a better list)
		quickList: [ 'en', 'hi', 'he', 'ml', 'ta', 'fr' ]
	};

	// Create a 'change language' Button:
	this.$button = new ve.ui.ButtonWidget({
		'label': ve.msg( 'visualeditor-languageinspector-widget-changelang' ),
		'flags': ['primary']
	});

	// Attach ULS event call
	this.$button.$.uls( ulsParams );

	this.$.append( this.$button.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.LanguageInputWidget, ve.ui.Widget );

/* Static properties */

/* Methods */

/**
 * Get display element. This replaces the 'getInputElement'
 * of the InputWidget
 *
 * @method
 * @param {Object} [config] Configuration options
 * @returns {jQuery} span element
 */
ve.ui.LanguageInputWidget.prototype.getDisplayElement = function () {
	return this.$$( '<span>' );
};

/**
 * Return the current language attributes
 *
 */
ve.ui.LanguageInputWidget.prototype.getAttributes = function () {
	return {
		'lang': this.lang,
		'dir': this.dir
	};
};

/**
 * Set the current language attributes
 *
 */
ve.ui.LanguageInputWidget.prototype.setAttributes = function ( lang, dir ) {
	this.lang = lang;
	this.dir = dir;
	// Update the view:
	this.updateLanguageTable();
};

/**
 * Get the language value of the current annotation
 * This is required by the AnnotationInspector onClose method
 */
ve.ui.LanguageInputWidget.prototype.getValue = function () {
	// Specifically to be displayed
	return this.$langNameDisp.text();
};

/**
 * Updates the language value in the display table
 *
 * This shouldn't be used directly. It is called from the
 * setAttributes method after receiving annotation details
 * to make sure the annotation and the table are synchronized.
 *
 * @method
 */
ve.ui.LanguageInputWidget.prototype.updateLanguageTable = function () {
	var langNameDisp = '';

	if ( this.lang ) {
		langNameDisp = $.uls.data.getAutonym( this.lang );
	}

	// Display the information in the table:
	this.$langCodeDisp.html( this.lang );
	this.$langNameDisp.html( langNameDisp );
	this.$dirDisp.html( this.dir );
};
