/*!
 * VisualEditor UserInterface DesktopInspectorWindowManager class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Window manager for desktop inspectors.
 *
 * @class
 * @extends ve.ui.WindowManager
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {ve.ui.Overlay} [overlay] Overlay to use for menus
 */
ve.ui.DesktopInspectorWindowManager = function VeUiDesktopInspectorWindowManager( config ) {
	// Parent constructor
	ve.ui.DesktopInspectorWindowManager.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.DesktopInspectorWindowManager, ve.ui.WindowManager );

/* Static Properties */

ve.ui.DesktopInspectorWindowManager.static.sizes = {
	small: {
		width: 200,
		maxHeight: '100%'
	},
	medium: {
		width: 300,
		maxHeight: '100%'
	},
	large: {
		width: 400,
		maxHeight: '100%'
	},
	full: {
		// These can be non-numeric because they are never used in calculations
		width: '100%',
		height: '100%'
	}
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.DesktopInspectorWindowManager.prototype.getSetupDelay = function () {
	return 0;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopInspectorWindowManager.prototype.getReadyDelay = function () {
	return 0;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopInspectorWindowManager.prototype.getHoldDelay = function () {
	return 0;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopInspectorWindowManager.prototype.getTeardownDelay = function () {
	return 0;
};
