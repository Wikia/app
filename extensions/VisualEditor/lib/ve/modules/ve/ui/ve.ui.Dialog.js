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

ve.ui.Dialog.prototype.setDraggable = function () {
	this.draggable = true;
	this.$element.addClass( 'oo-ui-dialog-draggable' );

	this.$dragHandle = this.$( '<div>' ).addClass( 'oo-ui-dialog-drag-handle oo-ui-icon-grabber' );
	this.$dragIframeFix = this.$( '<div>' ).addClass( 'oo-ui-dialog-drag-iframe-fix' );

	this.frame.$element.parent().draggable( {
		'handle': this.$dragHandle,
		'start': ve.bind( this.onDragStart, this ),
		'stop': ve.bind( this.onDragStop, this ),
		'containment': 'window',
		'scroll': false
	} );

	this.frame.$element.parent().prepend( this.$dragIframeFix, this.$dragHandle );
};

ve.ui.Dialog.prototype.unsetDraggable = function () {
	this.draggable = false;
	this.$element.removeClass( 'oo-ui-dialog-draggable' );

	this.$dragHandle.remove();
	this.$dragIframeFix.remove();
	this.$dragHandle = this.$dragIframeFix = null;

	this.frame.$element.parent().css( { 'top': '', 'left': '' } );
};

ve.ui.Dialog.prototype.setOverlayless = function () {
	this.overlayless = true;
	this.$element.addClass( 'oo-ui-dialog-overlayless' );
};

ve.ui.Dialog.prototype.unsetOverlayless = function () {
	this.overlayless = false;
	this.$element.removeClass( 'oo-ui-dialog-overlayless' );
};

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

/*
 * Handle when dragging begins
 */
ve.ui.Dialog.prototype.onDragStart = function () {
	this.$element.addClass( 'oo-ui-dialog-dragging' );
};

/*
 * Handle when dragging ends
 */
ve.ui.Dialog.prototype.onDragStop = function () {
	this.$element.removeClass( 'oo-ui-dialog-dragging' );
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

			ve.track( 'wikia', {
				'action': ve.track.actions.CLOSE,
				'label': 'dialog-' + ve.track.nameToLabel( this.constructor.static.name )
			} );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.Dialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.Dialog.super.prototype.getSetupProcess.apply( this, data )
		.next( function () {
			var label = ve.track.nameToLabel( this.constructor.static.name ),
				params = { 'action': ve.track.actions.OPEN, 'label': 'dialog-' + label };

			if ( this.openCount ) {
				params.value = this.openCount;
			}

			ve.track( 'wikia', params );
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
