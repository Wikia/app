/*!
 * VisualEditor UserInterface WikiaMediaOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} config Configuration options
 */
ve.ui.WikiaDropTargetWidget = function VeUiWikiaDropTargetWidget( config ) {
	// Configuration initialization
	ve.ui.WikiaDropTargetWidget.super.call( this, config );

	// Properties
	this.$overlay = config.$overlay.find( '.oo-ui-window' );
	this.$frame = config.$frame;
	this.fadeTimeout = null;

	// Events
	this.$frame.on( 'dragenter dragover', this.onFileDrag.bind( this ) );
	this.$element.on( 'drop', this.onFileDrop.bind( this ) );

	// Initialization
	this.$element
		.removeClass( 'oo-ui-widget' )
		.html( '<div>' + ve.msg( 'wikia-visualeditor-dialog-drop-target-callout' ) + '</div>' );

	this.$element.addClass( 've-ui-widget-droptarget' );
};

/* Inheritance */
OO.inheritClass( ve.ui.WikiaDropTargetWidget, OO.ui.Widget );

/**
 * Handles dragenter/over & shows drop zone
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDrag = function ( e ) {
	e.preventDefault();
	if ( this.fadeTimeout ) {
		clearTimeout( this.fadeTimeout );
	}
	if ( this.$element.is( ':visible' ) ) {
		return;
	}
	this.$element.fadeIn();
};

/* Event Handlers */
/**
 * Handles dragend/leave & hides drop zone
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDragEnd = function ( e ) {
	e.preventDefault();
	if ( !this.$element.is( ':visible' ) ) {
		return;
	}
	this.fadeTimeout = setTimeout( function () {
		this.$element.fadeOut();
	}.bind( this ), 200 );
};

/**
 * Handles drop events
 * @method
 * @param {Object} jQuery event
 */
ve.ui.WikiaDropTargetWidget.prototype.onFileDrop = function ( event ) {
	var transfer = event.originalEvent.dataTransfer,
		files = transfer.files;

	event.preventDefault();

	// fade out the drop zone
	this.$element.fadeOut();

	// trigger file drop
	this.emit( 'drop', files[0] );
};

/* Methods */

/**
 * Binds events
 * @method
 */
ve.ui.WikiaDropTargetWidget.prototype.setup = function () {
	this.$overlay.on( 'dragenter.dropTarget dragover.dropTarget', this.onFileDrag.bind( this ) );
	this.$overlay.on( 'dragleave.dropTarget dragend.dropTarget drop.dropTarget', this.onFileDragEnd.bind( this ) );
};

/**
 * Unbinds events
 * @method
 */
ve.ui.WikiaDropTargetWidget.prototype.teardown = function () {
	this.$overlay.off( '.dropTarget' );
};
