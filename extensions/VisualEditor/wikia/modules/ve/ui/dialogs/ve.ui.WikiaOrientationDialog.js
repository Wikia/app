/*!
 * VisualEditor user interface WikiaOrientationDialog class.
 */

/**
 * Dialog for orientating users new to VE.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaOrientationDialog = function VeUiWikiaOrientationDialog( config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaOrientationDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaOrientationDialog.static.name = 'wikiaOrientation';

ve.ui.WikiaOrientationDialog.static.title = '';

ve.ui.WikiaOrientationDialog.static.icon = '';

/* Methods */

/**
 * Initialize the dialog.
 *
 * @method
 */
ve.ui.WikiaOrientationDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.Dialog.prototype.initialize.call( this );

	// Properties
	this.$image = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-image' );
	this.$headline = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-headline' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-wikiaorientation-headline' )
		);
	this.$textBody = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-text' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-wikiaorientation-text' )
		);
	this.startButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-wikiaorientation-start-button' ),
		'flags': ['primary']
	} );

	// Events
	this.startButton.connect( this, { 'click': [ 'close' ] } );

	// Initialization
	this.$content = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-content' )
		.append( this.$image, this.$headline, this.$textBody, this.startButton.$element );

	this.$body.append( this.$content );
	this.frame.$content.addClass( 've-ui-wikiaOrientationDialog' );
	// Use this class to prevent scaling animation when the dialog is opened
	this.frame.$element.parent().addClass( 've-ui-wikiaOrientationDialogFrame' );
};

/**
 * Handle opening the dialog.
 *
 * @method
 */
ve.ui.WikiaOrientationDialog.prototype.open = function ( fragment, data ) {
	// Constrain the dimensions of the dialog
	this.frame.$element.parent().css( { 'width': '550px', 'max-height': '308px' } );
	// Parent method
	ve.ui.Dialog.prototype.open.call( this, fragment, data );
};

/**
 * Handle setup after the dialog opens.
 *
 * @method
 */
ve.ui.WikiaOrientationDialog.prototype.setup = function () {
	// Parent method
	ve.ui.Dialog.prototype.setup.call( this );
	$( '.ve-ui-wikiaFocusWidget' ).hide();
	if ( window.veTrack ) {
		veTrack( { action: 've-orientation-view' } );
	}
};

/**
 * @inheritdoc
 */
ve.ui.WikiaOrientationDialog.prototype.close = function ( data ) {
	if ( window.veTrack ) {
		veTrack( { action: ( data && data.action && data.action === 'cancel' ? 've-orientation-click-x' :
			've-orientation-click-start' ) } );
	}
	$( '.ve-ui-wikiaFocusWidget' ).show();
	// Parent method
	ve.ui.Dialog.prototype.close.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaOrientationDialog );
