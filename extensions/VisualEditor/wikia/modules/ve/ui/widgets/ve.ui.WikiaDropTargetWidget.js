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
 * @param {Object} [config] Configuration options
 * @cfg {Object} [upload] An instance of ve.ui.WikiaUploadWidget
 * @cfg {Object} [surface] Instance of parent dialog surface
 * @cfg {Object} [frame] Instance of parent dialog frame
 */
ve.ui.WikiaDropTargetWidget = function VeUiWikiaDropTargetWidget ( config ) {
	// Configuration initialization
	ve.ui.Widget.call( this, config );

	// set classname of element
	this.className = 've-ui-widget-droptarget';

	// instance of WikiaMediaUploadWidget
	this.upload = config.upload;
	// the full window overlay that sits below modal
	this.$overlay = config.surface.$globalOverlay.find( '.ve-ui-window' );
	// the frame of the MediaInsertDialog
	this.$frame = config.frame.$document;

	this.initialize();
};

ve.inheritClass( ve.ui.WikiaDropTargetWidget, ve.ui.Widget );

ve.ui.WikiaDropTargetWidget.prototype.initialize = function() {
	// Create drop target
	this.$ = this.$$( '<div>' ).addClass( this.className );

	//TODO: Temporary code
	this.$.css({
		height: '1000px',
		position: 'absolute',
		top: 0,
		left: 0,
		width: '100%',
		background: 'salmon',
		display: 'none'
	});

	this.$insertMediaDialog = this.$overlay.find( '.ve-ui-window-frame' );
	this.$.appendTo( this.$insertMediaDialog );

	this.$overlay.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );
	this.$overlay.on( 'dragleave dragend drop', ve.bind( this.onFileDragEnd, this ) );

	this.$.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );
	this.$.on( 'drop', ve.bind( this.onFileDrop, this ) );

	this.$frame.on( 'dragenter dragover', ve.bind( this.onFileDrag, this ) );

	this.fadeTimeout = null;
};

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
	var files,
			transfer;

	e.preventDefault();

	// fade out the drop zone
	this.$.fadeOut();

	transfer = e.originalEvent.dataTransfer;
	files = transfer.files;

	// trigger file upload
	this.upload.$file.trigger( 'change', files[0] );
};
