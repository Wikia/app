/*!
 * VisualEditor UserInterface ToolbarDialogWindowManager class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Window manager for toolbar dialogs.
 *
 * @class
 * @extends ve.ui.WindowManager
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {ve.ui.Overlay} [overlay] Overlay to use for menus
 */
ve.ui.ToolbarDialogWindowManager = function VeUiToolbarDialogWindowManager( config ) {
	// Parent constructor
	ve.ui.ToolbarDialogWindowManager.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.ToolbarDialogWindowManager, ve.ui.WindowManager );

/* Static Properties */

ve.ui.ToolbarDialogWindowManager.static.sizes.full = {
	width: '100%',
	maxHeight: '100%'
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ToolbarDialogWindowManager.prototype.getTeardownDelay = function () {
	return 250;
};
