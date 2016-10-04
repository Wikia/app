/*!
 * VisualEditor user interface WikiaImageInsertDialog class.
 */

/**
 * Dialog for inserting images.
 *
 * @class
 * @extends ve.ui.WikiaMediaInsertDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaImageInsertDialog = function VeUiMWImageInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaImageInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaImageInsertDialog, ve.ui.WikiaMediaInsertDialog );

/* Static Properties */

ve.ui.WikiaImageInsertDialog.static.name = 'wikiaImageInsert';

ve.ui.WikiaImageInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-image-insert-title' );

ve.ui.WikiaImageInsertDialog.static.trackingLabel = 'dialog-image-insert';

/* Methods */

ve.ui.windowFactory.register( ve.ui.WikiaImageInsertDialog );
