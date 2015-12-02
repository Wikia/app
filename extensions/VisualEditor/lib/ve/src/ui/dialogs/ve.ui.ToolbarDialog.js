/*!
 * VisualEditor UserInterface ToolbarDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Toolbar dialog.
 *
 * @class
 * @abstract
 * @extends OO.ui.Dialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.ToolbarDialog = function VeUiToolbarDialog( config ) {
	// Parent constructor
	ve.ui.ToolbarDialog.super.call( this, config );

	// Pre-initialization
	// This class needs to exist before setup to constrain the height
	// of the dialog when it first loads.
	this.$element.addClass( 've-ui-toolbarDialog' );
};

/* Inheritance */

OO.inheritClass( ve.ui.ToolbarDialog, OO.ui.Dialog );

/* Static Properties */

ve.ui.ToolbarDialog.static.size = 'full';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ToolbarDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.ToolbarDialog.super.prototype.initialize.call( this );

	this.$content.addClass( 've-ui-toolbarDialog-content' );
};
