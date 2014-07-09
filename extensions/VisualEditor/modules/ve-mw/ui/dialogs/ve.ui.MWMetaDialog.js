/*!
 * VisualEditor user interface MWMetaDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki page meta information.
 *
 * @class
 * @extends ve.ui.ActionDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMetaDialog = function VeUiMWMetaDialog( config ) {
	// Parent constructor
	ve.ui.MWMetaDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMetaDialog, ve.ui.ActionDialog );

/* Static Properties */

ve.ui.MWMetaDialog.static.name = 'meta';

ve.ui.MWMetaDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-meta-title' );

ve.ui.MWMetaDialog.static.icon = 'window';

ve.ui.MWMetaDialog.static.defaultSize = 'large';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWMetaDialog.super.prototype.initialize.call( this );

	// Properties
	this.bookletLayout = new OO.ui.BookletLayout( { '$': this.$, 'outlined': true } );
	this.settingsPage = new ve.ui.MWSettingsPage(
		'settings',
		{ '$': this.$ }
	);
	this.categoriesPage = new ve.ui.MWCategoriesPage(
		'categories',
		{
			'$': this.$,
			'$overlay': this.$overlay
		}
	);
	this.languagesPage = new ve.ui.MWLanguagesPage(
		'languages',
		{ '$': this.$ }
	);

	// Initialization
	this.panels.addItems( [ this.bookletLayout ] );
	this.bookletLayout.addPages( [
		this.settingsPage,
		this.categoriesPage,
		this.languagesPage
	] );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWMetaDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Data initialization
			data = data || {};

			var surfaceModel = this.getFragment().getSurface();

			if ( data.page && this.bookletLayout.getPage( data.page ) ) {
				this.bookletLayout.setPage( data.page );
			}

			// Force all previous transactions to be separate from this history state
			surfaceModel.breakpoint();
			surfaceModel.stopHistoryTracking();

			// Let each page set itself up ('languages' page doesn't need this yet)
			this.settingsPage.setup( surfaceModel.metaList, data );
			this.categoriesPage.setup( surfaceModel.metaList, data );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWMetaDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var surfaceModel = this.getFragment().getSurface(),
				// Place transactions made while dialog was open in a common history state
				hasTransactions = surfaceModel.breakpoint();

			// Data initialization
			data = data || {};

			// Undo everything done in the dialog and prevent redoing those changes
			if ( data.action === 'cancel' && hasTransactions ) {
				surfaceModel.undo();
				surfaceModel.truncateUndoStack();
			}

			// Let each page tear itself down ('languages' page doesn't need this yet)
			this.settingsPage.teardown( data );
			this.categoriesPage.teardown( data );

			// Return to normal tracking behavior
			surfaceModel.startHistoryTracking();
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMetaDialog );
