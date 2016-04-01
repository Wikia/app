/*!
 * VisualEditor UserInterface WindowManager class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Window manager.
 *
 * @class
 * @extends OO.ui.WindowManager
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {ve.ui.Overlay} [overlay] Overlay to use for menus
 */
ve.ui.WindowManager = function VeUiWindowManager( config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.WindowManager.super.call( this, config );

	// Properties
	this.overlay = config.overlay || null;
};

/* Inheritance */

OO.inheritClass( ve.ui.WindowManager, OO.ui.WindowManager );

/* Methods */

/**
 * Get overlay for menus.
 *
 * @return {ve.ui.Overlay|null} Menu overlay, null if none was configured
 */
ve.ui.WindowManager.prototype.getOverlay = function () {
	return this.overlay;
};

/**
 * @inheritdoc
 */
ve.ui.WindowManager.prototype.getReadyDelay = function () {
	// HACK: Really this should be measured by OOjs UI so it can vary by theme
	return 250;
};

/**
 * Set dialog size.
 *
 * Fullscreen mode will be used if the dialog is too wide to fit in the screen.
 *
 * @chainable
 */
ve.ui.WindowManager.prototype.updateWindowSize = function ( win ) {
	// Bypass for non-current, and thus invisible, windows
	if ( win !== this.currentWindow ) {
		return;
	}

	var viewport = OO.ui.Element.static.getDimensions( win.getElementWindow() ),
		sizes = this.constructor.static.sizes,
		size = win.getSize();

	if ( size === 'dynamic' && typeof win.getDynamicSize === 'function' ) {
		sizes.dynamic = { width: function () { return win.getDynamicSize() } };
	}

	if ( !sizes[size] ) {
		size = this.constructor.static.defaultSize;
	}

	if ( size !== 'full' && viewport.rect.right - viewport.rect.left < sizes[size].width ) {
		size = 'full';
	}

	this.$element.toggleClass( 'oo-ui-windowManager-fullscreen', size === 'full' );
	this.$element.toggleClass( 'oo-ui-windowManager-floating', size !== 'full' );
	win.setDimensions( sizes[size] );

	this.emit( 'resize', win );

	return this;
};
