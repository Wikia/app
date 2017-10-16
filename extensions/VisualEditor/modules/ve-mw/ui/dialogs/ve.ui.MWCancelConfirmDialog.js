/*
 * VisualEditor user interface MWCancelConfirmDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for letting the user choose how to switch to wikitext mode.
 *
 * @class
 * @extends OO.ui.MessageDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCancelConfirmDialog = function VeUiMWCancelConfirmDialog( config ) {
	// Parent constructor
	ve.ui.MWCancelConfirmDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCancelConfirmDialog, OO.ui.MessageDialog );

/* Static Properties */

ve.ui.MWCancelConfirmDialog.static.name = 'cancelconfirm';

ve.ui.MWCancelConfirmDialog.static.verbose = true;

ve.ui.MWCancelConfirmDialog.static.size = 'small';

ve.ui.MWCancelConfirmDialog.static.icon = 'help';

ve.ui.MWCancelConfirmDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-viewpage-savewarning-title' );

ve.ui.MWCancelConfirmDialog.static.message =
	OO.ui.deferMsg( 'visualeditor-viewpage-savewarning' );

ve.ui.MWCancelConfirmDialog.static.actions = [
	{ action: 'discard', label: OO.ui.deferMsg( 'visualeditor-viewpage-savewarning-discard' ), flags: [ 'primary', 'destructive' ] },
	{ action: 'keep', label: OO.ui.deferMsg( 'visualeditor-viewpage-savewarning-keep' ), flags: 'safe' }
];

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWCancelConfirmDialog );
