/*!
 * VisualEditor UserInterface WikiaMediaEditDialog class.
 */

/**
 * Dialog for editing MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWMediaEditDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMediaEditDialog = function VeUiWikiaMediaEditDialog( config ) {
	// Parent constructor
	ve.ui.MWMediaEditDialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaEditDialog, ve.ui.MWMediaEditDialog );

/* Static Properties */

ve.ui.WikiaMediaEditDialog.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo' ] },
	// Style
	{ 'include': [ 'bold', 'italic', 'link' ] },
	{
		'type': 'list',
		'icon': 'text-style',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		'include': [ 'subscript', 'superscript', 'strikethrough', 'underline', 'clear' ]
	},
	// Insert
	{
		'type': 'list',
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'indicator': 'down',
		'include': [ 'transclusion', 'reference' ]
	}
];

/* Methods */

ve.ui.WikiaMediaEditDialog.prototype.setup = function ( data ) {
	ve.ui.MWMediaEditDialog.prototype.setup.call( this, data );
	this.captionSurface.$element.addClass( 'WikiaArticle' );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaEditDialog );
