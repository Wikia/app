/*!
 * VisualEditor user interface MWMetaDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki page information.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMetaDialog = function VeUiMWMetaDialog( config ) {
	// Parent constructor
	ve.ui.MWMetaDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMetaDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.MWMetaDialog.static.name = 'meta';

ve.ui.MWMetaDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-meta-title' );

ve.ui.MWMetaDialog.static.icon = 'window';

ve.ui.MWMetaDialog.static.size = 'large';

ve.ui.MWMetaDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ]
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe'
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getBodyHeight = function () {
	return 400;
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWMetaDialog.super.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackLayout( { $: this.$ } );
	this.bookletLayout = new OO.ui.BookletLayout( { $: this.$, outlined: true } );
	this.settingsPage = new ve.ui.MWSettingsPage(
		'settings',
		{
			$: this.$,
			$overlay: this.$overlay
		}
	);
	this.advancedSettingsPage = new ve.ui.MWAdvancedSettingsPage(
		'advancedSettings',
		{ $: this.$ }
	);
	this.categoriesPage = new ve.ui.MWCategoriesPage(
		'categories',
		{
			$: this.$,
			$overlay: this.$overlay,
			$popupOverlay: this.$innerOverlay
		}
	);
	this.languagesPage = new ve.ui.MWLanguagesPage(
		'languages',
		{ $: this.$ }
	);

	// Initialization
	this.$body.append( this.panels.$element );
	this.panels.addItems( [ this.bookletLayout ] );
	this.bookletLayout.addPages( [
		this.settingsPage,
		this.advancedSettingsPage,
		this.categoriesPage,
		this.languagesPage
	] );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getActionProcess = function ( action ) {
	var surfaceModel = this.getFragment().getSurface();

	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			surfaceModel.applyStaging();
			this.close( { action: action } );
		}, this );
	}

	return ve.ui.MWMetaDialog.super.prototype.getActionProcess.call( this, action )
		.next( function () {
			surfaceModel.popStaging();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.MWMetaDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var surfaceModel = this.getFragment().getSurface();

			if ( data.page && this.bookletLayout.getPage( data.page ) ) {
				this.bookletLayout.setPage( data.page );
			}

			// Force all previous transactions to be separate from this history state
			surfaceModel.pushStaging();

			// Let each page set itself up ('languages' page doesn't need this yet)
			this.settingsPage.setup( surfaceModel.metaList, data );
			this.advancedSettingsPage.setup( surfaceModel.metaList, data );
			this.categoriesPage.setup( surfaceModel.metaList, data );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.getTeardownProcess = function ( data ) {
	data = data || {};
	return ve.ui.MWMetaDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Let each page tear itself down ('languages' page doesn't need this yet)
			this.settingsPage.teardown( { action: data.action } );
			this.advancedSettingsPage.teardown( { action: data.action } );
			this.categoriesPage.teardown( { action: data.action } );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMetaDialog );
