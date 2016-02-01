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
// OO.inheritClass( ve.ui.WikiaImageInsertDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaImageInsertDialog.static.name = 'wikiaImageInsert';

ve.ui.WikiaImageInsertDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-image-insert-title' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaImageInsertDialog.prototype.initialize = function () {
	this.initializeWrapper(true);
};

/**
 * Inserts media items into the document
 *
 * @method
 * @param {Object} items Items to insert
 * @param {ve.dm.SurfaceFragment} fragment
 */
ve.ui.WikiaImageInsertDialog.prototype.insertPermanentMediaCallback = function ( items, fragment ) {
	this.insertPermanentMediaCallbackWrapper( items, fragment, 'dialog-image-insert');
};

ve.ui.windowFactory.register( ve.ui.WikiaImageInsertDialog );
