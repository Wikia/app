/*!
 * VisualEditor user interface MediaInsertDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaInsertDialog = function VeUiMWMediaInsertDialog( windowSet, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'footless': true }, config );

	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );

	// Properties
	this.item = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaInsertDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWMediaInsertDialog.static.name = 'mediaInsert';

ve.ui.MWMediaInsertDialog.static.titleMessage = 'visualeditor-dialog-media-insert-title';

ve.ui.MWMediaInsertDialog.static.icon = 'picture';

/* Methods */

/**
 * Handle search result selection.
 *
 * @param {ve.ui.MWMediaResultWidget|null} item Selected item
 */
ve.ui.MWMediaInsertDialog.prototype.onSearchSelect = function ( item ) {
	this.item = item;
	if ( item ) {
		this.close( { 'action': 'insert' } );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.search = new ve.ui.MWMediaSearchWidget( { '$': this.$ } );

	// Events
	this.search.connect( this, { 'select': 'onSearchSelect' } );

	// Initialization
	this.search.$element.addClass( 've-ui-mwMediaInsertDialog-select' );
	this.$body.append( this.search.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWDialog.prototype.setup.call( this, data );

	// Initialization
	this.search.getQuery().$input.focus().select();
	this.search.getResults().selectItem();
	this.search.getResults().highlightItem();
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.teardown = function ( data ) {
	var info;

	// Data initialization
	data = data || {};

	if ( data.action === 'insert' ) {
		info = this.item.imageinfo[0];
		this.surface.getModel().getFragment().collapseRangeToEnd().insertContent( [
			{
				'type': 'mwBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'default',
					//'href': info.descriptionurl,
					'href': './' + this.item.title,
					'src': info.thumburl,
					'width': info.thumbwidth,
					'height': info.thumbheight,
					'resource': './' + this.item.title
				}
			},
			{ 'type': 'mwImageCaption' },
			{ 'type': '/mwImageCaption' },
			{ 'type': '/mwBlockImage' }
		] );
	}

	// Parent method
	ve.ui.MWDialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMediaInsertDialog );
