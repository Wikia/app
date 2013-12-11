/*!
 * VisualEditor UserInterface WikiaMediaOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} config Configuration options
 * @cfg {ve.ui.WikiaUploadWidget} upload An instance of ve.ui.WikiaUploadWidget
 * @cfg {Object} surface Instance of parent dialog surface
 * @cfg {Object} frame Instance of parent dialog frame
 */
ve.ui.WikiaDropTargetWidget = function VeUiWikiaDropTargetWidget ( config ) {

	// Configuration initialization
	ve.ui.Widget.call( this, config );

	// Properties
	this.upload = config.upload;
	this.$overlay = config.surface.$globalOverlay.find( '.ve-ui-window' );
	this.$frame = config.frame.$document;
	this.$insertMediaDialog = this.$overlay.find( '.ve-ui-window-frame' );
	this.fadeTimeout = null;

	// Events
	this.$overlay.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );
	this.$overlay.on( 'dragleave dragend drop', ve.bind( this.onFileDragEnd, this ) );

	this.$.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );
	this.$.on( 'drop', ve.bind( this.onFileDrop, this ) );

	this.$frame.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );

	// Initialization
	this.$
		.removeClass( 've-ui-widget' )
		.html( '<div>' + ve.msg( 'wikia-visualeditor-dialog-drop-target-callout' ) + '</div>' );

	this.$.addClass( 've-ui-widget-droptarget' ).prependTo( this.$insertMediaDialog );
};

/* Inheritance */
ve.inheritClass( ve.ui.WikiaDropTargetWidget, ve.ui.Widget );

/**
 * Handles dragenter/over & shows drop zone
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDrag = function( e ) {
	e.preventDefault();
	if ( this.fadeTimeout ) {
		clearTimeout( this.fadeTimeout );
	}
	if ( this.$.is( ':visible' ) ) {
		return;
	}
	this.$.fadeIn();
};

/**
 * Handles dragend/leave & hides drop zone
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDragEnd = function( e ) {
	e.preventDefault();
	if ( !this.$.is( ':visible' ) ) {
		return;
	}
	this.fadeTimeout = setTimeout( ve.bind( function() {
		this.$.fadeOut();
	}, this ), 200 );
};

/**
 * Handles drop events
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDrop = function( e ) {
	var	transfer = e.originalEvent.dataTransfer,
			files = transfer.files;

	e.preventDefault();

	// fade out the drop zone
	this.$.fadeOut();

	// trigger file upload
	this.emit( 'upload', files[0] );
};
