/*!
 * VisualEditor UserInterface Dialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog with an associated surface fragment.
 *
 * @class
 * @abstract
 * @extends OO.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.Dialog = function VeUiDialog( config ) {
	// Parent constructor
	OO.ui.Dialog.call( this, config );

	// Properties
	this.fragment = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.Dialog, OO.ui.Dialog );

/**
 * @param {ve.dm.SurfaceFragment} fragment Surface fragment
 * @param {Object} data Dialog opening data
 * @param {string} data.dir Directionality of fragment
 */
ve.ui.Dialog.prototype.open = function ( fragment, data ) {
	this.fragment = fragment;

	// Parent method
	OO.ui.Dialog.prototype.open.call( this, data );
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.teardown = function () {
	// Parent method
	OO.ui.Dialog.prototype.teardown.apply( this, arguments );

	// Restore selection
	// HACK: Integration is a mess, and to prevent teardown being called multiple times we need to
	// rethink a whole lot of it, and spend a fair amount of time rewriting it - but instead of
	// doing all of that, we can just put this band aid (checking if there is a fragment before
	// calling select on it) and closed bug 63954 for now.
	if ( this.fragment ) {
		this.fragment.select();
	}

	this.fragment = null;

	var label = ve.track.nameToLabel( this.constructor.static.name );
	ve.track( 'wikia', { 'action': ve.track.actions.CLOSE, 'label': 'dialog-' + label } );
};

/**
 * Get the surface fragment the dialog is for
 *
 * @returns {ve.dm.SurfaceFragment|null} Surface fragment the dialog is for, null if the dialog is closed
 */
ve.ui.Dialog.prototype.getFragment = function () {
	return this.fragment;
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.onCloseButtonClick = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name );

	OO.ui.Dialog.prototype.onCloseButtonClick.apply( this, arguments );

	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-' + label + '-button-close'
	} );
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.setup = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name ),
		params = { 'action': ve.track.actions.OPEN, 'label': 'dialog-' + label };

	OO.ui.Dialog.prototype.setup.apply( this, arguments );

	if ( this.openCount ) {
		params.value = this.openCount;
	}

	ve.track( 'wikia', params );
};
