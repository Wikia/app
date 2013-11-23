/*!
 * VisualEditor UserInterface MWDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki dialog.
 *
 * @class
 * @abstract
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWDialog = function VeUiMWDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWDialog, ve.ui.Dialog );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWDialog.prototype.onCloseButtonClick = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name );

	ve.ui.Dialog.prototype.onCloseButtonClick.apply( this, arguments );

	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-' + label + '-button-close'
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWDialog.prototype.setup = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name ),
		params = { 'action': ve.track.actions.OPEN, 'label': 'dialog-' + label };

	ve.ui.Dialog.prototype.setup.apply( this, arguments );

	if ( this.openCount ) {
		params.value = this.openCount;
	}

	ve.track( 'wikia', params );
};

/**
 * @inheritdoc
 */
ve.ui.MWDialog.prototype.teardown = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name );

	ve.ui.Dialog.prototype.teardown.apply( this, arguments );

	ve.track( 'wikia', { 'action': ve.track.actions.CLOSE, 'label': 'dialog-' + label } );
};
