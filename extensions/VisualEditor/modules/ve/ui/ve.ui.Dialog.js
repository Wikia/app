/*!
 * VisualEditor UserInterface Dialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface dialog.
 *
 * @class
 * @abstract
 * @extends ve.ui.Window
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [footless] Hide foot
 */
ve.ui.Dialog = function VeUiDialog( surface, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Window.call( this, surface, config );

	// Properties
	this.visible = false;
	this.footless = !!config.footless;
	this.small = !!config.small;
	this.onWindowMouseWheelHandler = ve.bind( this.onWindowMouseWheel, this );
	this.onDocumentKeyDownHandler = ve.bind( this.onDocumentKeyDown, this );

	// Events
	this.$.on( 'mousedown', false );

	// Initialization
	this.$.addClass( 've-ui-dialog' );
};

/* Inheritance */

ve.inheritClass( ve.ui.Dialog, ve.ui.Window );

/* Static Properties */

/**
 * Symbolic name of dialog.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.Dialog.static.name = '';

/* Methods */

/**
 * Handle close button click events.
 *
 * @method
 */
ve.ui.Dialog.prototype.onCloseButtonClick = function () {
	this.close( 'cancel' );
};

/**
 * Handle window mouse wheel events.
 *
 * @method
 * @param {jQuery.Event} e Mouse wheel event
 */
ve.ui.Dialog.prototype.onWindowMouseWheel = function () {
	return false;
};

/**
 * Handle document key down events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 */
ve.ui.Dialog.prototype.onDocumentKeyDown = function ( e ) {
	switch ( e.which ) {
		case ve.Keys.PAGEUP:
		case ve.Keys.PAGEDOWN:
		case ve.Keys.END:
		case ve.Keys.HOME:
		case ve.Keys.LEFT:
		case ve.Keys.UP:
		case ve.Keys.RIGHT:
		case ve.Keys.DOWN:
			// Prevent any key events that might cause scrolling
			return false;
	}
};

/**
 * Handle frame document key down events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 */
ve.ui.Dialog.prototype.onFrameDocumentKeyDown = function ( e ) {
	if ( e.which === ve.Keys.ESCAPE ) {
		this.close( 'cancel' );
		return false;
	}
};

/**
 * Open window.
 *
 * Wraps the parent open method. Disables native top-level window scrolling behavior.
 *
 * @method
 * @emits setup
 * @emits open
 */
ve.ui.Dialog.prototype.open = function () {
	ve.ui.Window.prototype.open.call( this );
	// Prevent scrolling in top-level window
	$( window ).on( 'mousewheel', this.onWindowMouseWheelHandler );
	$( document ).on( 'keydown', this.onDocumentKeyDownHandler );
};

/**
 * Close dialog.
 *
 * Wraps the parent close method. Allows animation by delaying parent close call, while still
 * providing the same recursion blocking. Restores native top-level window scrolling behavior.
 *
 * @method
 * @param {boolean} action Action that caused the window to be closed
 * @emits close
 */
ve.ui.Dialog.prototype.close = function ( action ) {
	if ( !this.closing ) {
		this.$.addClass( 've-ui-dialog-closing' );
		setTimeout( ve.bind( function () {
			ve.ui.Window.prototype.close.call( this, action );
			this.$.removeClass( 've-ui-dialog-closing' );
		}, this ), 250 );
		// Allow scrolling in top-level window
		$( window ).off( 'mousewheel', this.onWindowMouseWheelHandler );
		$( document ).off( 'keydown', this.onDocumentKeyDownHandler );
	}
};

/** */
ve.ui.Dialog.prototype.initialize = function () {
	// Parent method
	ve.ui.Window.prototype.initialize.call( this );

	// Properties
	this.closeButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$, 'title': ve.msg( 'visualeditor-dialog-action-close' ), 'icon': 'close'
	} );

	// Events
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );
	this.frame.$document.on( 'keydown', ve.bind( this.onFrameDocumentKeyDown, this ) );

	// Initialization
	this.frame.$content.addClass( 've-ui-dialog-content' );
	if ( this.footless ) {
		this.frame.$content.addClass( 've-ui-dialog-content-footless' );
	}
	if ( this.small ) {
		this.$frame.addClass( 've-ui-window-frame-small' );
	}
	this.closeButton.$.addClass( 've-ui-window-closeButton' );
	this.$head.append( this.closeButton.$ );
};
