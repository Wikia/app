/*!
 * VisualEditor user interface WikiaVideoInsertDialog class.
 */

/**
 * Dialog for inserting videos.
 *
 * @class
 * @extends ve.ui.WikiaMediaInsertDialog
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

ve.ui.WikiaVideoInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-video-insert-title' );

ve.ui.WikiaVideoInsertDialog.static.trackingLabel = 'dialog-video-insert';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaVideoInsertDialog.prototype.initialize = function () {
	var uploadWidget;

	// Parent method
	ve.ui.WikiaVideoInsertDialog.super.prototype.initialize.call( this );

	this.pages.removePages( [ this.mainPage ] );

	uploadWidget = this.query.getUpload();
	uploadWidget.getUploadButton().toggle();
};

ve.ui.windowFactory.register( ve.ui.WikiaVideoInsertDialog );
