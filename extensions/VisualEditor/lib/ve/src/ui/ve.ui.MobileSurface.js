/*!
 * VisualEditor UserInterface MobileSurface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * A surface is a top-level object which contains both a surface model and a surface view.
 * This is the mobile version of the surface.
 *
 * @class
 * @extends ve.ui.Surface
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 */
ve.ui.MobileSurface = function VeUiMobileSurface() {
	// Parent constructor
	ve.ui.Surface.apply( this, arguments );

	// Properties
	this.scrollPosition = null;

	// Events
	this.dialogs.connect( this, { opening: 'onWindowOpening' } );
	this.context.getInspectors().connect( this, { opening: 'onWindowOpening' } );

	// Initialization
	this.localOverlay.$element
		.addClass( 've-ui-mobileSurface-overlay ve-ui-mobileSurface-overlay-local' );
	this.globalOverlay.$element
		.addClass( 've-ui-mobileSurface-overlay ve-ui-mobileSurface-overlay-global' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileSurface, ve.ui.Surface );

/* Methods */

/**
 * Handle an dialog opening event.
 *
 * @param {OO.ui.Window} win Window that's being opened
 * @param {jQuery.Promise} opening Promise resolved when window is opened; when the promise is
 *   resolved the first argument will be a promise which will be resolved when the window begins
 *   closing, the second argument will be the opening data
 * @param {Object} data Window opening data
 */
ve.ui.MobileSurface.prototype.onWindowOpening = function ( win, opening ) {
	var surface = this;
	opening
		.progress( function ( data ) {
			if ( data.state === 'setup' ) {
				surface.toggleGlobalOverlay( true );
			}
		} )
		.always( function ( opened ) {
			opened.always( function ( closed ) {
				closed.always( function () {
					surface.toggleGlobalOverlay( false );
				} );
			} );
		} );
};

/**
 * @inheritdoc
 */
ve.ui.MobileSurface.prototype.createContext = function () {
	return new ve.ui.MobileContext( this, { $: this.$ } );
};

/**
 * @inheritdoc
 */
ve.ui.MobileSurface.prototype.createDialogWindowManager = function () {
	return new ve.ui.MobileWindowManager( {
		factory: ve.ui.windowFactory,
		overlay: this.globalOverlay
	} );
};

/**
 * Show or hide global overlay.
 *
 * @param {boolean} show If true, show global overlay, otherwise hide it.
 */
ve.ui.MobileSurface.prototype.toggleGlobalOverlay = function ( show ) {
	var $body = $( 'body' );

	// Store current position before we set overflow: hidden on body
	if ( show ) {
		this.scrollPosition = $body.scrollTop();
	}

	$( 'html, body' ).toggleClass( 've-ui-mobileSurface-overlay-global-enabled', show );
	this.globalOverlay.$element.toggleClass( 've-ui-mobileSurface-overlay-global-visible', show );

	// Restore previous position after we remove overflow: hidden on body
	if ( !show ) {
		$body.scrollTop( this.scrollPosition );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MobileSurface.prototype.destroy = function () {
	// Parent method
	ve.ui.MobileSurface.super.prototype.destroy.call( this );

	this.toggleGlobalOverlay( false );
};
