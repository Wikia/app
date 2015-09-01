/*!
 * VisualEditor UserInterface ToolbarDialog class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Toolbar dialog.
 *
 * @class
 * @abstract
 * @extends OO.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.ToolbarDialog = function VeUiToolbarDialog( config ) {
	// Parent constructor
	ve.ui.ToolbarDialog.super.call( this, config );

	// Properties
	this.disabled = false;
	this.$shield = $( '<div>' ).addClass( 've-ui-toolbarDialog-shield' );

	// Pre-initialization
	// This class needs to exist before setup to constrain the height
	// of the dialog when it first loads.
	this.$element.addClass( 've-ui-toolbarDialog' );
};

/* Inheritance */

OO.inheritClass( ve.ui.ToolbarDialog, OO.ui.Dialog );

/* Static Properties */

ve.ui.ToolbarDialog.static.size = 'full';

ve.ui.ToolbarDialog.static.activeSurface = true;

ve.ui.ToolbarDialog.static.padded = true;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ToolbarDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.ToolbarDialog.super.prototype.initialize.call( this );

	this.$body.append( this.$shield );
	this.$content.addClass( 've-ui-toolbarDialog-content' );
	if ( this.constructor.static.padded ) {
		this.$element.addClass( 've-ui-toolbarDialog-padded' );
	}
};

/**
 * Set the disabled state of the toolbar dialog
 *
 * @param {boolean} disabled Disable the dialog
 */
ve.ui.ToolbarDialog.prototype.setDisabled = function ( disabled ) {
	this.$content.addClass( 've-ui-toolbarDialog-content' );
	if ( disabled !== this.disabled ) {
		this.disabled = disabled;
		this.$body
			// Make sure sheild is last child
			.append( this.$shield )
			.toggleClass( 've-ui-toolbarDialog-disabled', this.disabled );
	}
};
