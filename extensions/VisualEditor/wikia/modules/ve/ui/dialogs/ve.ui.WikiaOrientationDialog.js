/*!
 * VisualEditor user interface WikiaOrientationDialog class.
 */

/*global veTrack */

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
	config =  $.extend( config, {
		width: '550px',
		height: '300px',
		disableAnimation: true
	} );

	// Parent constructor
	ve.ui.WikiaOrientationDialog.super.call( this, config );
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
	ve.ui.WikiaOrientationDialog.super.prototype.initialize.call( this );

	// Properties
	this.$image = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-image' );
	this.$headline = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-headline' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-orientation-headline' )
		);
	this.$textBody = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-text' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-orientation-text' )
		);
	this.startButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-orientation-start-button' ),
		'flags': [ 'primary' ]
	} );

	// Events
	this.startButton.connect( this, { 'click': [ 'close' ] } );

	// Initialization
	this.$content = this.$( '<div>' )
		.addClass( 've-ui-wikiaOrientationDialog-content' )
		.append( this.$image, this.$headline, this.$textBody, this.startButton.$element )
		.appendTo( this.$body );

	this.frame.$content.addClass( 've-ui-wikiaOrientationDialog' );
};

/**
 * Handle setup after the dialog opens.
 *
 * @method
 */
ve.ui.WikiaOrientationDialog.prototype.setup = function () {
	// Parent method
	ve.ui.WikiaOrientationDialog.super.prototype.setup.call( this );
	this.$( '.ve-ui-wikiaFocusWidget' ).hide();
	if ( window.veTrack ) {
		veTrack( { action: 've-orientation-view' } );
	}
};

/**
 * @inheritdoc
 */
ve.ui.WikiaOrientationDialog.prototype.close = function ( data ) {
	if ( window.veTrack ) {
		veTrack( {
			action: (
				data && data.action && data.action === 'cancel' ?
				've-orientation-click-x' :
				've-orientation-click-start'
			)
		} );
	}
	this.$( '.ve-ui-wikiaFocusWidget' ).show();
	// Parent method
	ve.ui.WikiaOrientationDialog.super.prototype.close.call( this, data );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaOrientationDialog );
