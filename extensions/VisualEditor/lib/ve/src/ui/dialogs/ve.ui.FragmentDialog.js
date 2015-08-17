/*!
 * VisualEditor UserInterface FragmentDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Dialog for working with fragments of content.
 *
 * @class
 * @abstract
 * @extends OO.ui.ProcessDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.FragmentDialog = function VeUiFragmentDialog( config ) {
	// Parent constructor
	ve.ui.FragmentDialog.super.call( this, config );

	// Properties
	this.fragment = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.FragmentDialog, OO.ui.ProcessDialog );

/**
 * @inheritdoc
 * @throws {Error} If fragment was not provided through data parameter
 */
ve.ui.FragmentDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.FragmentDialog.super.prototype.getSetupProcess.apply( this, data )
		.next( function () {
			if ( !( data.fragment instanceof ve.dm.SurfaceFragment ) ) {
				throw new Error( 'Cannot open dialog: opening data must contain a fragment' );
			}
			this.fragment = data.fragment;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.FragmentDialog.super.prototype.getTeardownProcess.apply( this, data )
		.first( function () {
			this.fragment.select();
			this.fragment = null;
		}, this );
};

/**
 * Get the surface fragment the dialog is for
 *
 * @returns {ve.dm.SurfaceFragment|null} Surface fragment the dialog is for, null if the dialog is closed
 */
ve.ui.FragmentDialog.prototype.getFragment = function () {
	return this.fragment;
};
