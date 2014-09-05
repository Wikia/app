/*
 * VisualEditor user interface WikiaTemplateDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting templates.
 *
 * @class
 * @abstract
 * @extends ve.ui.MWTemplateDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface dialog is for
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateInsertDialog = function VeUiWikiaTemplateInsertDialog( config ) {
	// TODO: configured width needed?

	// Parent constructor
	ve.ui.WikiaTemplateInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaTemplateInsertDialog.static.name = 'wikiaTemplateInsert';

ve.ui.WikiaTemplateInsertDialog.static.icon = 'template';

ve.ui.WikiaTemplateInsertDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-transclusion-insert-template' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTemplateInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.searchInput = new OO.ui.TextInputWidget( {
		'$': this.$,
		'icon': 'search',
		'type': 'search',
		'placeholder': ve.msg( 'wikia-visualeditor-dialog-wikiatemplateinsert-search' )
	} );
	this.$search = this.$( '<div>' )
		.addClass( 've-ui-wikiaTemplateInsertDialog-search' )
		.append( this.searchInput.$element );
	this.select = new OO.ui.SelectWidget( { '$': this.$ } );

	// Events
	this.searchInput.on( 'change', ve.bind( this.onSearchInputChange, this ) );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaTemplateInsertDialog' );
	this.searchInput.$input.attr( 'tabindex', 1 );
	this.$body.append( this.$search );
};

/*
 * Handle change of value in search input
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onSearchInputChange = function () {
	// TODO
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTemplateInsertDialog );
