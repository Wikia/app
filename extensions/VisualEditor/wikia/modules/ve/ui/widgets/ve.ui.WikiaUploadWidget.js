/*!
 * VisualEditor UserInterface WikiaUploadWidget class.
 */

/* global mw */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaUploadWidget = function VeUiWikiaUploadWidget( config ) {
	// Parent constructor
	ve.ui.Widget.call( this, config );

	this.$uploadIcon = this.$$( '<span>' )
		.addClass( 've-ui-iconedElement-icon ve-ui-icon-upload' );

	this.$uploadLabel = this.$$( '<span>' )
		.text( ve.msg( 'visualeditor-wikiauploadwidget-label' ) );

	this.uploadButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-wikiauploadwidget-button' ),
		'flags': ['constructive']
	} );

	this.$file = this.$$( '<input>' ).attr( 'type', 'file' );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaUploadButtonWidget' )
		.append( this.$uploadIcon )
		.append( this.$uploadLabel )
		.append( this.uploadButton.$ )
		.append( this.$file );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaUploadWidget, ve.ui.Widget );
