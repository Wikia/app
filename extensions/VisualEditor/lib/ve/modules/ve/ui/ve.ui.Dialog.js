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

	// FIXME: In the worst case scope is traversed three times to access same object (parent).
	if ( config.disableAnimation ) {
		this.frame.$element.parent().addClass( 've-ui-noAnimation' );
	}
	if ( config.width ) {
		this.frame.$element.parent().css( 'width', config.width );
	}
	if ( config.height ) {
		this.frame.$element.parent().css( 'height', config.height );
	}

	// Properties
	this.fragment = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.Dialog, OO.ui.Dialog );

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.open = function ( fragment, data, surface ) {
	this.fragment = fragment;
	this.surface = surface;

	// Parent method
	return ve.ui.Dialog.super.prototype.open.call( this, data );
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.close = function ( data ) {
	// Parent method
	return ve.ui.Dialog.super.prototype.close.call( this, data )
		.then( ve.bind( function () {
			this.fragment = null;
		}, this ) );
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.Dialog.super.prototype.getTeardownProcess.apply( this, data )
		.next( function () {
			// Restore selection
			// HACK: Integration is a mess, and to prevent teardown being called multiple times we
			// need to rethink a whole lot of it, and spend a fair amount of time rewriting it - but
			// instead of doing all of that, we can just put this band aid (checking if there is a
			// fragment before calling select on it) and closed bug 63954 for now.
			if ( this.fragment ) {
				this.fragment.select();
			}
		}, this );
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
