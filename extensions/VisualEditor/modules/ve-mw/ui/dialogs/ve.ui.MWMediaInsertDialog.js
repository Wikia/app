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
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaInsertDialog = function VeUiMWMediaInsertDialog( surface, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'footless': true }, config );

	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );

	// Properties
	this.item = null;
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMediaInsertDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWMediaInsertDialog.static.name = 'mediaInsert';

ve.ui.MWMediaInsertDialog.static.titleMessage = 'visualeditor-dialog-media-insert-title';

ve.ui.MWMediaInsertDialog.static.icon = 'picture';

/* Methods */

/** */
ve.ui.MWMediaInsertDialog.prototype.onSearchSelect = function ( item ) {
	this.item = item;
	if ( item ) {
		this.close( 'insert' );
	}
};

/** */
ve.ui.MWMediaInsertDialog.prototype.onOpen = function () {
	// Parent method
	ve.ui.MWDialog.prototype.onOpen.call( this );

	// Initialization
	this.search.getQuery().$input.focus().select();
	this.search.getResults().selectItem();
	this.search.getResults().highlightItem();
};

/** */
ve.ui.MWMediaInsertDialog.prototype.onClose = function ( action ) {
	var info;

	// Parent method
	ve.ui.MWDialog.prototype.onClose.call( this );

	if ( action === 'insert' ) {
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
};

/** */
ve.ui.MWMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.search = new ve.ui.MWMediaSearchWidget( { '$$': this.frame.$$ } );

	// Events
	this.search.connect( this, { 'select': 'onSearchSelect' } );

	// Initialization
	this.search.$.addClass( 've-ui-mwMediaInsertDialog-select' );
	this.$body.append( this.search.$ );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMediaInsertDialog );
