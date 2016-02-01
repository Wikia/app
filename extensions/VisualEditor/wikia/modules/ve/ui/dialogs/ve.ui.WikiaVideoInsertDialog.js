/*!
 * VisualEditor user interface WikiaVideoInsertDialog class.
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaVideoInsertDialog = function VeUiMWMediaInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaVideoInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaVideoInsertDialog, ve.ui.WikiaMediaInsertDialog );

/* Static Properties */

ve.ui.WikiaVideoInsertDialog.static.name = 'wikiaVideoInsert';

ve.ui.WikiaVideoInsertDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-video-insert-title' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaVideoInsertDialog.prototype.initialize = function () {
	this.initializeWrapper(false);
	$('.ve-ui-wikiaMediaQueryWidget-uploadWrapper').addClass('ve-ui-wikiaMediaQueryWidget-uploadWrapper-video');
};

/**
 * Inserts media items into the document
 *
 * @method
 * @param {Object} items Items to insert
 * @param {ve.dm.SurfaceFragment} fragment
 */
ve.ui.WikiaVideoInsertDialog.prototype.insertPermanentMediaCallback = function ( items, fragment ) {
	this.insertPermanentMediaCallbackWrapper( items, fragment, 'dialog-video-insert');
};

ve.ui.windowFactory.register( ve.ui.WikiaVideoInsertDialog );
