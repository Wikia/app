/*!
 * VisualEditor UserInterface WindowSet class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface window set.
 *
 * @class
 * @extends ve.Element
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {ve.Factory} factory Window factory
 * @param {Object} [config] Configuration options
 */
ve.ui.WindowSet = function VeUiWindowSet( surface, factory, config ) {
	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.surface = surface;
	this.factory = factory;
	this.windows = {};
	this.currentWindow = null;

	// Initialization
	this.$.addClass( 've-ui-windowSet' );
};

/* Inheritance */

ve.inheritClass( ve.ui.WindowSet, ve.Element );

ve.mixinClass( ve.ui.WindowSet, ve.EventEmitter );

/* Events */

/**
 * @event setup
 * @param {ve.ui.Window} win Window that's been setup
 */

/**
 * @event open
 * @param {ve.ui.Window} win Window that's been opened
 */

/**
 * @event close
 * @param {ve.ui.Window} win Window that's been closed
 * @param {string} action Action that caused the window to be closed
 */

/* Methods */

/**
 * Handle a window being setup.
 *
 * @method
 * @param {ve.ui.Window} win Window that's been setup
 * @emits setup
 */
ve.ui.WindowSet.prototype.onWindowSetup = function ( win ) {
	this.emit( 'setup', win );
};

/**
 * Handle a window being opened.
 *
 * @method
 * @param {ve.ui.Window} win Window that's been opened
 * @emits open
 */
ve.ui.WindowSet.prototype.onWindowOpen = function ( win ) {
	this.currentWindow = win;
	this.emit( 'open', win );
};

/**
 * Handle a window being closed.
 *
 * @method
 * @param {ve.ui.Window} win Window that's been opened
 * @param {boolean} accept Changes have been accepted
 * @emits close
 */
ve.ui.WindowSet.prototype.onWindowClose = function ( win, accept ) {
	this.currentWindow = null;
	this.emit( 'close', win, accept );
};

/**
 * Get the current window.
 *
 * @method
 * @returns {ve.ui.Window} Current window
 */
ve.ui.WindowSet.prototype.getCurrent = function () {
	return this.currentWindow;
};

/**
 * Opens a given window.
 *
 * Any already open dialog will be closed.
 *
 * @method
 * @param {string} name Symbolic name of window
 * @param {Object} [config] Configuration options to be sent to the window class constructor
 * @chainable
 */
ve.ui.WindowSet.prototype.open = function ( name, config ) {
	var win;

	if ( !this.factory.lookup( name ) ) {
		throw new Error( 'Unknown window: ' + name );
	}
	if ( this.currentWindow ) {
		throw new Error( 'Cannot open another window while another one is active' );
	}
	if ( !( name in this.windows ) ) {
		win = this.windows[name] = this.factory.create( name, this.surface, config );
		win.connect( this, {
			'setup': ['onWindowSetup', win],
			'open': ['onWindowOpen', win],
			'close': ['onWindowClose', win]
		} );
		this.$.append( win.$ );
		win.getFrame().load();
	}

	this.windows[name].open();

	return this;
};
